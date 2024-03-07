<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\UsersWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $user_id = Auth::user()->id;
            $data = Event::where('user_id', $user_id)->orderBy('id','desc')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('event.index');
    }

    public function create(Request $request){
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'venue' => 'required|max:255',
            'seats' => 'required|integer',
            'ticket_price' => 'required|numeric',
        ]);
        $user_id = auth()->user()->id;
        $wallet =  UsersWallet::firstOrCreate(['user_id' => $user_id]);
        if($wallet->wallet <= config('constant.event_price')){
            return redirect()->route('wallet')->with('error', 'Please enter balance to add event.');
        }
        $wallet->update(['wallet' => DB::raw('wallet - ' . config('constant.event_price'))]);

        $event = new Event();
        $event->title = $validatedData['title'];
        $event->user_id = $user_id;
        $event->description = $validatedData['description'];
        $event->date = $validatedData['date'];
        $event->time = $validatedData['time'];
        $event->venue = $validatedData['venue'];
        $event->seats = $validatedData['seats'];
        $event->ticket_price = $validatedData['ticket_price'];
        $event->save();

        return redirect()->route('event.index')->with('success', 'Event created successfully');
    }
}
