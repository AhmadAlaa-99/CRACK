<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\OtpVerification;

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
     * Handle the initial registration step.
     */
    public function registerStep1(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Store registration data in session
        Session::put('registration_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Will be hashed later
            'city' => $request->city,
            'last_login_ip' => $request->ip(),
        ]);

        // Generate OTP
        $otp = rand(100000, 999999); // 6-digit OTP

        // Store OTP in database
        OtpVerification::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(15), // OTP valid for 15 minutes
            ]
        );

        // Send OTP to user's email
        $this->sendOtpEmail($request->email, $otp);

        // Redirect to OTP verification page
        return redirect()->route('verify.otp.form')->with('success', 'Please check your email for the verification code');
    }

    /**
     * Show OTP verification form.
     */
    public function showOtpForm()
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register')->with('error', 'Registration information missing');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify OTP and complete registration.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        if (!Session::has('registration_data')) {
            return redirect()->route('register')->with('error', 'Registration information missing');
        }

        $registrationData = Session::get('registration_data');
        $email = $registrationData['email'];

        $otpVerification = OtpVerification::where('email', $email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpVerification) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP'])->withInput();
        }

        // Create the user
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($registrationData['password']),
            'city' => $registrationData['city'],
            'last_login_ip' => $registrationData['last_login_ip'],
            'email_verified_at' => now(),
        ]);

        $user->assignRole('user');

        // Delete the OTP record
        $otpVerification->delete();

        // Clear the session data
        Session::forget('registration_data');

        // Log the user in
        Auth::login($user);

        return redirect('/')->with('success', 'Account created and verified successfully');
    }

    /**
     * Resend OTP to user's email.
     */
    public function resendOtp(Request $request)
    {
        if (!Session::has('registration_data')) {
            return redirect()->route('register')->with('error', 'Registration information missing');
        }

        $registrationData = Session::get('registration_data');
        $email = $registrationData['email'];

        // Generate new OTP
        $otp = rand(100000, 999999);

        // Update OTP in database
        OtpVerification::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(15),
            ]
        );

        // Send OTP to user's email
        $this->sendOtpEmail($email, $otp);

        return back()->with('success', 'Verification code has been resent to your email');
    }

    /**
     * Send OTP email to user.
     */
    private function sendOtpEmail($email, $otp)
    {
        // Make sure we have valid data
        if (empty($email) || empty($otp)) {
            \Log::error('Missing email or OTP in sendOtpEmail function', [
                'email' => $email,
                'otp' => $otp
            ]);
            return false;
        }

        try {
            Mail::send('emails.otp-verification', ['otp' => $otp, 'email' => $email], function($message) use ($email) {
                $message->to($email)
                    ->subject('Verification Code for Registration');
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
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
