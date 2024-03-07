<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use App\Models\UsersWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class UserController extends Controller
{
    public function wallet(){
        $user_id = auth()->user()->id;
        $wallet = UsersWallet::firstOrCreate(['user_id' => $user_id]);
        return view('wallet', compact('wallet'));
    }

    public function addBalance(Request $request){
        $stripe = new StripeClient(config('constant.STRIPE_SECRET'));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Add Balance",
                        ],
                        'unit_amount' => $request->amount * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('add.balance.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        if(isset($response->id) && $response->id != ''){
            session()->put('product_name', "Add Balance");
            session()->put('quantity', 1);
            session()->put('price', $request->amount);
            return redirect($response->url);
        } else {
            DB::rollBack();
            return redirect()->back()->with('error', 'Payment is canceled.');
        }
    }

    public function success(Request $request)
    {
        if(isset($request->session_id)) {
            $stripe = new StripeClient(config('constant.STRIPE_SECRET'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            $user_id = auth()->user()->id;
            $user_id = auth()->user()->id;
            UsersWallet::updateOrCreate(['user_id' => $user_id], ['wallet' => DB::raw('wallet + ' . session()->get('price'))]);

            $payment = new PaymentHistory();
            $payment->payment_id = $response->id;
            $payment->product_name = session()->get('product_name');
            $payment->quantity = session()->get('quantity');
            $payment->amount = session()->get('price');
            $payment->currency = $response->currency;
            $payment->customer_name = $response->customer_details->name;
            $payment->customer_email = $response->customer_details->email;
            $payment->payment_status = $response->status;
            $payment->payment_method = "Stripe";
            $payment->save();

            return redirect()->route('wallet')->with('success', 'Payment is successful');
            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');
        } else {
            return redirect()->back()->with('error', 'Payment is canceled.');
        }
    }
}
