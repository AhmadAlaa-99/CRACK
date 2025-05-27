<?php

namespace App\Services;

use BTCPayServer\Client\Invoice as InvoiceClient;
use BTCPayServer\Client\InvoiceCheckoutOptions;
use BTCPayServer\Util\PreciseNumber;

class BTCPayService
{
    private InvoiceClient $client;
    private string        $storeId;

    public function __construct()
    {
        $this->client  = new InvoiceClient(
            config('btcpay.server_url'),
            config('btcpay.api_key')
        );
        $this->storeId = config('btcpay.store_id');
    }

    public function createInvoice(
        float  $amount,
        string $currency,
        string $orderId,
        string $redirectUrl
    ) {
        /* ❶ metadata ترجع لك فى الـ Webhook */
        $metadata = ['orderId' => $orderId];

        /* ❷ كائن خيارات صفحة الدفع */
        $checkout = new InvoiceCheckoutOptions();
        $checkout
            ->setRedirectUrl($redirectUrl)        // الحروف الكبيرة صحيحة
            ->setRedirectAutomatically(true);

        /* ❸ إنشاء الفاتورة */
  $metadata = [
    'orderId' => $orderId,      // أعدناه هنا
    'plan'    => 'Personal License'
];

return $this->client->createInvoice(
    $this->storeId,
    $currency,
    PreciseNumber::parseFloat($amount, 2),
    null,            // الوسيط الرابع = null لنتجنّب «ambiguous»
    null,            // buyerEmail
    $metadata,       // ← الآن يحوي orderId
    $checkout
);


    }
}
