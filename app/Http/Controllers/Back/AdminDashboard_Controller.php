<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboard_Controller extends Controller
{
    public function dashboard(){
        return view('Back.dashboard.dashboard');
    }
}
