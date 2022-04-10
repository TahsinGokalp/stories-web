<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function index(): RedirectResponse
    {
        if(! auth()->user()){
            return redirect()->route('login');
        }

        if(auth()->user()->hasRole(User::PARENT)){
            return redirect()->route('dashboard');
        }

        return redirect()->route('child.books');
    }
}
