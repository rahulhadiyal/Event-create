<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        $number1 = rand(0, 10);
        $number2 = rand(0, 10);
        $operator = ['+', '-', '*', '/'][rand(0, 3)];

        switch ($operator) {
            case '+':
                $result = $number1 + $number2;
                break;
            case '-':
                $result = $number1 - $number2;
                break;
            case '*':
                $result = $number1 * $number2;
                break;
            case '/':
                $result = $number1 / $number2;
                break;
        }

        Session::put('captcha_result', $result);
        return response()->json([
            'equation' => "$number1 $operator $number2",
        ]);
    }
}
