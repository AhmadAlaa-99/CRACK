<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\NowPaymentsController;
use Illuminate\Support\Facades\Storage;
use App\Models\Purchase;
use App\Models\File;

class NowPaymentsController extends Controller
{
    private function baseUrl(): string
    {
        return config('services.nowpayments.sandbox')
            ? 'https://api-sandbox.nowpayments.io/v1'
            : 'https://api.nowpayments.io/v1';
    }

    public function createPaymentTest(Request $request)
    {
        $planId  = $request->input('plan_id', 1);
        $plan    = $this->getPlanDetails($planId);
        $orderId = hash('sha512', 'testpay' . rand() . time());
        $token   = hash('sha512', 'testpay' . rand() . time());

        // ??? ?????? ????? ?? ??????
        Session::put('order_details', [
            'gateway'   => 'nowpayments',
            'order_id'  => $orderId,
            'plan_id'   => $planId,
            'amount'    => $plan['price'],
            'file_path' => $plan['file_path'],
        ]);
        Session::put('payment_token', $token);

        // 1) ?????? ?? ????? ????? ?? ????
        $existingPurchase = Purchase::where('user_id', auth()->id())
            ->where('plan_id', $planId)
            ->where('status', 'completed')
            ->first();

        if ($existingPurchase) {

            $ipMatches        = $existingPurchase->ip_address === $request->ip();
            $adminUnlocked    = $existingPurchase->download_allowed;

            /** 
             * ? ??? ??? ??? IP ??????? ?? ?? ?????? ??? ??????? 
             *    ? ???? ?????? ??? ???????
             */
            if ($ipMatches || $adminUnlocked) {

                // ??? ??? ??????? ??????? ??? ?????? ??? ??? ?? ??? ??? IP
                // ????? ????? ?????? ??? ??? ????? (???????)
                if ($adminUnlocked && !$ipMatches) {
                    $existingPurchase->update(['download_allowed' => false]);
                }

                return redirect()
                    ->route('download.plan', ['p' => $planId])
                    ->with('info', 'You can download your plan now.');
            }

            /** 
             * ? ?? IP ????? ??? ??? ?? ?????? 
             */
            return redirect()
                ->route('index')
                ->with(
                    'error',
                    'You have purchased this plan before. Use the same device/network or contact administrator to unlock the download.'
                );
        }

        // 3) ?? ????? ?? ??? ? ???? ????? (?????? ?????)
        $purchase = Purchase::create([
            'user_id'    => auth()->id(),
            'plan_id'    => $planId,
            'order_id'   => $orderId,
            'amount'     => $plan['price'],
            'currency'   => 'USD',
            'status'     => 'pending',
            'ip_address' => $request->ip(),
        ]);

        $purchase->update([
            'status'     => 'completed', // ? ?? ????? ???????? ???
            'payment_id' => 'test_payment_id_' . rand(10000, 99999),
        ]);

        return redirect()->route('now.success');
    }




    public function createPayment(Request $request)
    {
        $planId   = $request->input('plan_id', 1);
        $plan     = $this->getPlanDetails($planId);
        $orderId  = hash('sha512', 'nowpay' . rand() . time());
        $token    = hash('sha512', 'nowpay' . rand() . time());
        Session::put('order_details', [
            'gateway'   => 'nowpayments',
            'order_id'  => $orderId,
            'plan_id'   => $planId,
            'amount'    => $plan['price'],
            'file_path' => $plan['file_path'],
        ]);
        Session::put('payment_token', $token);
        // 1) ?????? ?? ????? ????? ?? ????
        $existingPurchase = Purchase::where('user_id', auth()->id())
            ->where('plan_id', $planId)
            ->where('status', 'completed')
            ->first();

        if ($existingPurchase) {

            $ipMatches        = $existingPurchase->ip_address === $request->ip();
            $adminUnlocked    = $existingPurchase->download_allowed;

            /** 
             * ? ??? ??? ??? IP ??????? ?? ?? ?????? ??? ??????? 
             *    ? ???? ?????? ??? ???????
             */
            if ($ipMatches || $adminUnlocked) {

                // ??? ??? ??????? ??????? ??? ?????? ??? ??? ?? ??? ??? IP
                // ????? ????? ?????? ??? ??? ????? (???????)
                if ($adminUnlocked && !$ipMatches) {
                    $existingPurchase->update(['download_allowed' => false]);
                }

                return redirect()
                    ->route('download.plan', ['p' => $planId])
                    ->with('info', 'You can download your plan now.');
            }

            /** 
             * ? ?? IP ????? ??? ??? ?? ?????? 
             */
            return redirect()
                ->route('index')
                ->with(
                    'error',
                    'You have purchased this plan before. Use the same device/network or contact administrator to unlock the download.'
                );
        }


        $payload = [
            'price_amount'       => $plan['price'],
            'price_currency'     => 'usd',
            'pay_currency'       => 'btc',               // ?? ????? ?????? ?????? ??????
            'order_id'           => $orderId,
            'order_description'  => "Payment for " . $plan['name'],
            'ipn_callback_url'   => route('now.ipn', ['token' => $token]),
            'success_url'        => route('now.success'),
            'cancel_url'         => route('now.cancel'),
            'is_fixed_rate'      => true,                // ???????
        ];

        $response = Http::withHeaders([
            'x-api-key' => config('services.nowpayments.key'),
            'Content-Type' => 'application/json',
        ])
            ->post($this->baseUrl() . '/payment', $payload)
            ->throw()
            ->json();                              // ?????? ? pay_address, ? payment_id, ? invoice_url

        Log::info('NOWPayments order created', $response);

        Session::put('now_payment_id', $response['payment_id']);
        if (isset($response['invoice_url']) && !empty($response['invoice_url'])) {
            return redirect()->away($response['invoice_url']);   // ????? ???????? ??????????
        }

        $response = Http::withHeaders([
            'x-api-key'      => config('services.nowpayments.key'),
            'Content-Type'   => 'application/json',
        ])->post($this->baseUrl() . '/invoice', [
            'price_amount'      => $plan['price'],
            'price_currency'    => 'usd',
            'order_id'          => $orderId,
            'order_description' => "Payment for " . $plan['name'],
            'ipn_callback_url'  => route('now.ipn', ['token' => $token]),
            'success_url'       => route('now.success'),
            'cancel_url'        => route('now.cancel'),
        ])->throw()->json();                   // ????? ??? invoice_url



        Purchase::create([
            'user_id'   => auth()->id(),
            'plan_id'   => $planId,
            'order_id'  => $orderId,
            'amount'    => $plan['price'],
            'currency'  => 'USD',
            'status'    => 'pending',
            'ip_address' => $request->ip(),   // ??? IP ???? ??? ???
        ]);



        return redirect()->away($response['invoice_url']);
    }

    public function ipn(Request $request, $token)
    {
        // 1) ??????? ?? ?????? ????
        if ($token !== Session::get('payment_token')) {
            return response('Token mismatch', 400);
        }
        // 2) ??????? ?? ??????? X-NOWPayments-Sig
        $signature = $request->header('x-nowpayments-sig');
        $calculated = hash_hmac('sha512', $request->getContent(), config('services.nowpayments.secret'));
        if ($signature !== $calculated) {
            return response('Bad signature', 400);
        }
        // 3) ??? ?????? ?????
        $data     = $request->json()->all();        // payment_status, payment_id, order_id …
        $status   = $data['payment_status'];
        $orderId  = $data['order_id'];
        // 4) ??? ?????? ?? ????? ???????? ??? ???? ?? CoinGate
        $purchase = Purchase::where('order_id', $orderId)->first();
        if ($purchase) {
            $purchase->update([
                'status'     => $status === 'finished' ? 'completed' : $status,
                'payment_id' => $orderId,
            ]);
        }


        $this->updatePaymentStatus($orderId, $status, $data['payment_id']);

        return response('OK', 200);
    }
    // ????? ????? ?????
    /**
     * Handle successful payment redirect.
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $orderDetails = Session::get('order_details');
        /*
        {"gateway":"nowpayments","order_id":"3e0eeb42b054968e361adb502829e40f6c7ca68af53fb81a13453a6642429503badc547d05353e3d0a025dddee3ac9992e9e395ef885d249a7f94ec0843f58f2","plan_id":"1","amount":15,"file_path":"plans\/personal_license.zip"}
        */

        if (!$orderDetails) {
            return redirect()->route('home')->with('error', 'Order details not found.');
        }

        // Check if payment was marked as completed in the callback
        // You could check this from your database



        return view('payment.success', [
            'orderDetails' => $orderDetails,
            'downloadUrl' => route('download.plan', ['p' => $orderDetails['plan_id']])

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
    public function downloadPlan(Request $request, Plan $plan)
    {
        $purchase = Purchase::where('user_id', auth()->id())
            ->where('plan_id', $plan->id)
            ->where('status', 'completed')
            ->first();

        if (!$purchase) {
            return back()->with('error', '?? ???? ???? ????.');
        }

        // ? ?????? ??? ??? ??? IP ????? **??** ?????? ??? ???????
        $ipMatches = $purchase->ip_address === $request->ip();
        if (!$ipMatches && !$purchase->download_allowed) {
            return back()->with('error', 'You must use the same device/network or contact the administration.');
        }

        // ? ??? ??? ??????? ??????? ?????? ?????? ????? ???? ???? ?????:
        if ($purchase->download_allowed && !$ipMatches) {
            $purchase->update(['download_allowed' => false]); // ????? ????? ??? ???????
        }

        $filePath = $plan->file_path;
        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', '????? ??? ?????.');
        }

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
        //"/var/www/craxsratandroid/storage/app/public/uploads/CRAXS.rar" 
        //"/var/www/craxsratandroid/storage/app/public/uploads/CraxsRat_V7.3.rar"
        $plans = [
            1 => [
                'name' => 'Plan1',
                'price' => 1510,
                'file_path' => 'plans/CraxsRat_V7.3.rar',
            ],
            2 => [
                'name' => 'Plan12',
                'price' => 9020,
                'file_path' => 'plans/CRAXS.rar',
            ],
        ];

        return $plans[$planId] ?? $plans[1]; // Default to first plan if not found
    }
    /* success(), cancel(), downloadPlan() ?????? ??? ???? ??????? */

    /* getPlanDetails(), updatePaymentStatus(), getPaymentStatus() ??? ?? CoinGateController */
}
