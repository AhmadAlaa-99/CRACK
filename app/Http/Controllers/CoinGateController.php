<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CoinGate\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\File;

class CoinGateController extends Controller
{
    /**
     * Create a payment and redirect to CoinGate payment page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPayment(Request $request)
    {
        // Get the plan details or use default values
        $planId = $request->input('plan_id', 1);
        $planDetails = $this->getPlanDetails($planId);

        $order_id = uniqid();
        $description = "Payment for " . $planDetails['name'];
        $amount = $planDetails['price'];
        $currency = 'USD';

        // Store order information in session for later verification
        Session::put('order_details', [
            'order_id' => $order_id,
            'plan_id' => $planId,
            'amount' => $amount,
            'file_path' => $planDetails['file_path'],
        ]);

        // Generate a unique token for this transaction
        $token = hash('sha512', 'coingate' . rand() . time());
        Session::put('payment_token', $token);

        // Initialize CoinGate client (use sandbox for testing, set to false for production)
        $client = new Client('xT5_bYF2pQq35SBMPPMDtTz3A7uVx4zz3MMRcbXw', true);
        // Create the payment order
        $params = array(
            'order_id'          => $order_id,
            'price_amount'      => $amount,
            'price_currency'    => $currency,
            'receive_currency'  => 'BTC', // Receive in Bitcoin
            'callback_url' => route('coingate.callback', ['token' => $token]),
            'cancel_url'        => route('coingate.cancel'),
            'success_url'       => route('coingate.success'),
            'title'             => $planDetails['name'],
            'description'       => $description,
               'token'             => $token, // إضافة الرمز مباشرة كمعلمة
            'purchaser_email'   => $request->input('email', '') // إضافة بريد المشتري إذا كان متاحًا
        );
//return $params;

        try {
            $order = $client->order->create($params);
        } catch (\Exception $e) {
            dd($e);
        }

        try {
            $order = $client->order->create($params);
            // Log the created order for debugging
            Log::info('CoinGate order created', ['order_id' => $order_id, 'payment_id' => $order->id]);

            // Store CoinGate order ID in session
            Session::put('coingate_order_id', $order->id);

            // Redirect to CoinGate payment page
            return redirect($order->payment_url);
        } catch (\Exception $e) {
            Log::error('CoinGate order creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle the callback from CoinGate.
     *
     * @param Request $request
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request, $token)
    {
        $storedToken = Session::get('payment_token');
        if (!$storedToken || $token !== $storedToken) {
            Log::warning('Invalid payment token received', ['received' => $token]);
            return response('Invalid token', 400);
        }
        // التحقق من الرمز المستلم من CoinGate
        $receivedToken = $request->input('token');
        $storedToken = Session::get('payment_token');

        if (!$storedToken || $receivedToken !== $storedToken) {
            Log::warning('Invalid payment token received', ['received' => $receivedToken]);
            return response('Invalid token', 400);
        }


        // Get the CoinGate data
        $orderId = $request->input('order_id');
        $status = $request->input('status');
        $coingateId = $request->input('id');

        // Verify the order ID
        $orderDetails = Session::get('order_details');
        if (!$orderDetails || $orderDetails['order_id'] !== $orderId) {
            Log::warning('Order ID mismatch', [
                'received' => $orderId,
                'expected' => $orderDetails['order_id'] ?? 'not found'
            ]);
            return response('Order verification failed', 400);
        }

        // Update payment status in your database
        if ($status === 'paid') {
            // Payment successful - update your database
            // Here you would typically update the payment status in your database
            $this->updatePaymentStatus($orderId, 'completed', $coingateId);

            Log::info('Payment successful', ['order_id' => $orderId, 'coingate_id' => $coingateId]);
        } else {
            // Payment failed or pending
            $this->updatePaymentStatus($orderId, $status, $coingateId);

            Log::info('Payment status update', [
                'order_id' => $orderId,
                'status' => $status,
                'coingate_id' => $coingateId
            ]);
        }

        return response('OK', 200);
    }
    // تعديل إنشاء الطلب
    /**
     * Handle successful payment redirect.
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $orderDetails = Session::get('order_details');

        if (!$orderDetails) {
            return redirect()->route('home')->with('error', 'Order details not found.');
        }

        // Check if payment was marked as completed in the callback
        // You could check this from your database

        return view('payment.success', [
            'orderDetails' => $orderDetails,
            'downloadUrl' => route('download.plan', ['order_id' => $orderDetails['order_id']])
        ]);
    }

    /**
     * Handle cancelled payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        return redirect()->route('plans')->with('info', 'Payment was cancelled.');
    }

    /**
     * Download the plan file after successful payment.
     *
     * @param Request $request
     * @param string $orderId
     * @return \Illuminate\Http\Response
     */
    public function downloadPlan(Request $request, $orderId)
    {


        $orderDetails = Session::get('order_details');
        //{"order_id":"67f96f2169223","plan_id":1,"amount":49.99,"file_path":"plans\/personal_license.zip"}
      

        // Verify payment status from your database
        $paymentStatus = $this->getPaymentStatus($orderId);

        $file = File::first();
        $filePath = $file->path; //uploads/AEkpWfHkdr3bqhQnyOAcRQBA283H86zNMfrGwnUs.png
        // Check if file exists
        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'The requested file could not be found.');
        }

        // Return the file download
        return Storage::disk('public')->download($filePath);
    }

    /**
     * Get plan details based on plan ID.
     *
     * @param int $planId
     * @return array
     */
    private function getPlanDetails($planId)
    {
        // In a real application, you would fetch this from your database
        // This is just a placeholder example
        $plans = [
            1 => [
                'name' => 'Personal License',
                'price' => 49.99,
                'file_path' => 'plans/personal_license.zip',
            ],
        ];

        return $plans[$planId] ?? $plans[1]; // Default to first plan if not found
    }

    /**
     * Update payment status in database.
     *
     * @param string $orderId
     * @param string $status
     * @param string $coingateId
     * @return void
     */
    private function updatePaymentStatus($orderId, $status, $coingateId)
    {
        // In a real application, you would update your database
        // Example:
        // Payment::where('order_id', $orderId)->update([
        //     'status' => $status,
        //     'coingate_id' => $coingateId,
        //     'updated_at' => now(),
        // ]);

        // For this example, we'll just log it
        Log::info('Payment status updated', [
            'order_id' => $orderId,
            'status' => $status,
            'coingate_id' => $coingateId
        ]);
    }

    /**
     * Get payment status from database.
     *
     * @param string $orderId
     * @return string
     */
    private function getPaymentStatus($orderId)
    {
        // In a real application, you would check your database
        // Example:
        // return Payment::where('order_id', $orderId)->value('status');

        // For this example, we'll assume payment was completed if order details exist
        return Session::has('order_details') ? 'completed' : 'pending';
    }
}
