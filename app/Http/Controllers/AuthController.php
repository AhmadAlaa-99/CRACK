<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt($request->only('email', 'password'))) {
            // Check if the logged-in user has the 'admin' role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('dashboard')->with('success', 'Welcome, Admin!');
            }

            $ipAddress = $request->ip();
            $user = Auth::user();
            // Log the IP to the database
            $user->update(['last_login_ip' => $ipAddress]);
    
            //dd($user);
            return redirect('/')->with('success', 'Logged in successfully');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city' => $request->city,
            'last_login_ip' => $request->ip(),
        ]);
        $user->assignRole('user');

        Auth::login($user);

        return redirect('/')->with('success', 'Account created successfully');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully');
    }
}
