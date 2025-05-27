<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Purchase;

class DashboardController extends Controller
{

    public function allow(Purchase $purchase)
    {
        $purchase->update(['download_allowed' => true]);
        return back()->with('success', 'Download unlocked for the buyer.');
    }

    public function revoke(Purchase $purchase)
    {
        $purchase->update(['download_allowed' => false]);
        return back()->with('success', 'Download permission revoked.');
    }
    
    
    public function index()
    {
        $users = User::all(); // Retrieve all users
        $hideNavbar = true;
        return view('admin.dashboard', compact('users', 'hideNavbar'));
    }
    
    public function purchases(Plan $plan)
{
    $purchases = $plan->purchases()->with('user')->latest()->paginate(20);
    return view('admin.plans.purchases', compact('plan', 'purchases'));
}

}
