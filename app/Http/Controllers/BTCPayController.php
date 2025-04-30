<?php
namespace App\Http\Controllers;

use App\Services\BTCPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BTCPayController extends Controller
{
    /** يبادِر عملية الدفع ويُنشئ الفاتورة */
    public function createPayment(Request $request, BTCPayService $btcpay)
    {
        $plan = [ 'name' => 'Personal License', 'price' => 49.99 ];
        $orderId = Str::uuid()->toString();

        // نسجّل الطلب (فى Cache للتجربة فقط)
        Cache::put("order:$orderId", [ 'status' => 'processing', 'plan' => $plan ], now()->addHours(1));

        $redirect   = route('btcpay.processing', $orderId);
        $invoice    = $btcpay->createInvoice($plan['price'], 'USD', $orderId, $redirect);

        return redirect($invoice->getCheckoutLink());
    }

    /** صفحة وسيطة: جارٍ معالجة الدفع */
    public function processing(string $id)
    {
        return view('payment.processing', ['orderId' => $id]);
    }

    /** يعرض حالة الطلب عبر AJAX */
    public function status(string $id)
    {
        $order = Cache::get("order:$id");
        return response()->json(['status' => $order['status'] ?? 'unknown']);
    }

    /** Webhook من BTCPay */
    public function webhook(Request $request)
    {
        $payload = $request->json()->all();
        Log::info('BTCPay Webhook', $payload);

        if (($payload['type'] ?? '') === 'InvoiceSettled') {
            $orderId = $payload['metadata']['orderId'] ?? null;
            if ($orderId) {
                Cache::put("order:$orderId", [ 'status' => 'completed' ], now()->addHours(1));
            }
        }
        return response('OK', 200);
    }

    /** يعرض صفحة نجاح فعلية بعد التحقق */
    public function success(string $id)
    {
        $order = Cache::get("order:$id");
        abort_unless($order && $order['status']==='completed', 404);
        return view('payment.success');
    }

    public function cancel() { return back()->with('info', 'Payment cancelled.'); }
}
