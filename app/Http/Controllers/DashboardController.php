<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->only(['dashboard']);
        $this->middleware('permission:dashboard')->only('dashboard');
    }

    public function dashboard() {
        return view('pages.dashboard');
    }
}
