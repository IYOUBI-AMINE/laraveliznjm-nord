<?php

namespace App\Http\Controllers\ResetPassword;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{


    use SendsPasswordResetEmails;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
