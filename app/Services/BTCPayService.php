<?php
namespace App\Services;

use BTCPayServer\Client\Invoice as InvoiceClient;
use BTCPayServer\Util\PreciseNumber;

class BTCPayService
{
    private InvoiceClient $client;
    private string $storeId;

    public function __construct()
    {
        $this->client  = new InvoiceClient(config('btcpay.server_url'), config('btcpay.api_key'));
        $this->storeId = config('btcpay.store_id');
    }

    public function createInvoice(float $amount, string $currency, string $orderId, string $redirectUrl)
    {
        return $this->client->createInvoice(
            $this->storeId,
            $currency,
            PreciseNumber::parseFloat($amount, 2),
            $orderId,
            null,
            [
                'redirectUrl'           => $redirectUrl,      // أين سيُعاد توجيه العميل مباشرةً بعد الدفع
                'redirectAutomatically' => true,
            ]
        );
    }
}
