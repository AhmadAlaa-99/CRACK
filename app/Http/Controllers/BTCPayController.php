<?php

namespace App\Http\Controllers;

use App\Services\BTCPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BTCPayController extends Controller
{
    /* ====================== إنشاء الفاتورة ====================== */
    public function createPayment(Request $request, BTCPayService $btcpay)
    {
        $plan = ['name' => 'Personal License', 'price' => 10.00];

        $orderId = Str::uuid()->toString();                 // رقم فريد للطلب
        $redirect = route('btcpay.processing', ['id'=>$orderId]);

        // نحفظ الطلب مؤقتاً (يمكنك استبداله بقاعدة بيانات)
        Cache::put("order:$orderId", [
            'status' => 'processing',
            'plan'   => $plan,
        ], now()->addHours(1));

        // إنشاء الفاتورة وإعادة توجيه العميل لصفحة الدفع
        $invoice = $btcpay->createInvoice(
            $plan['price'],
            'USD',
            $orderId,
            $redirect              // redirectURL
        );

        return redirect($invoice->getCheckoutLink());
    }

    /* ============== صفحة انتظار الدفع (/btcpay/processing) ============== */
    public function processing(string $id)
    {
        return view('payment.processing', ['orderId' => $id]);
    }

    /* ============== استعلام AJAX ============== */
public function status(string $id)
{
    $order = Cache::get("order:$id");
    return response()->json([
        'status' => $order['status'] ?? 'unknown',
        'plan'   => $order['plan'  ]['name'] ?? ''
    ]);
}

/* ================== Webhook ================= */
/* ======================= Webhook من BTCPay ======================= */
public function webhook(Request $request)
{
    /* 1) فحص ترويسة التوقيع وإعادة حسابه */
    $sigHeader = $request->header('BTCPay-Sig');            // sha256=HASH
    if (!$sigHeader || !str_contains($sigHeader,'=')) {
        return response('Bad sig header', 400);
    }
    [$algo, $sig] = explode('=', $sigHeader, 2);

    $secret  = env('BTCPAY_WEBHOOK_SECRET');                // من .env
    $calc    = hash_hmac($algo, $request->getContent(), $secret);

    if (!hash_equals($calc, $sig)) {                        // مقارنة آمنة
        Log::warning('Bad BTCPay sig', compact('sig','calc'));
        return response('Invalid signature', 400);
    }

    /* 2) حمولة الحدث */
    $p       = $request->json()->all();
    $type    = $p['type']                    ?? '';
    $orderId = $p['metadata']['orderId']     ?? null;

    if (!$orderId) return response('OK', 200);

    /* 3) جلب الطلب ثم تعديل الحالة فقط */
    $order = Cache::get("order:$orderId", []);              // مصفوفة الطلب

    if ($type === 'InvoiceSettled') {
        $order['status'] = 'completed';                     // نجاح
    }

    if (in_array($type, ['InvoiceExpired','InvoiceInvalid'])) {
        $order['status'] = 'failed';                        // فشل
    }

    Cache::put("order:$orderId", $order, now()->addHours(1));
    return response('OK', 200);
}





    /* ======================= صفحة النجاح ======================= */
   public function success(string $id)
{
    $order = Cache::get("order:$id");
    abort_unless($order && $order['status']==='completed', 404);

    return view('payment.success', [
        'plan'    => $order['plan']['name'],
        'orderId' => $id,
        'downloadUrl' => route('download.plan', ['order_id'=>$id]) // أو حسب مسارك
    ]);
}


    /* (اختياري) إلغاء */
    public function cancel()
    {
        return back()->with('info', 'Payment cancelled.');
    }
}
