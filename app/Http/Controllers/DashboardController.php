<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all(); // Retrieve all users
        $hideNavbar = true;
        return view('admin.dashboard', compact('users', 'hideNavbar'));
    }
}
