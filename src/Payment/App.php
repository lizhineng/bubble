<?php

namespace Zhineng\Bubble\Payment;

use Zhineng\Bubble\Contracts\ApiClient;
use Zhineng\Bubble\ManagesHttp;

class App implements ApiClient
{
    use ManagesHttp;

    public function __construct(
        protected string $appId,
        protected string $merchantId
    ) {
        //
    }

    public function apiEndpoint(): string
    {
        return 'https://api.mch.weixin.qq.com';
    }

    /**
     * Create a new transaction with given channel.
     *
     * @param  string  $channel
     * @return TransactionBuilder
     */
    public function newTransactionVia(string $channel): TransactionBuilder
    {
        return new TransactionBuilder($this, $channel);
    }

    /**
     * Retrieve app ID.
     *
     * @return string
     */
    public function appId(): string
    {
        return $this->appId;
    }

    /**
     * Retrieve merchant ID.
     *
     * @return string
     */
    public function merchantId(): string
    {
        return $this->merchantId;
    }
}
