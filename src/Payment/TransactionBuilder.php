<?php

namespace Zhineng\Bubble\Payment;

use DateTimeInterface;
use Zhineng\Bubble\Http\Response;

class TransactionBuilder
{
    /**
     * Merchant which transaction transferred to.
     *
     * @var string
     */
    protected string $merchantId;

    /**
     * Order number for internal tracking.
     *
     * @var string
     */
    protected string $orderNumber;

    /**
     * Simple description for the transaction.
     *
     * @var string
     */
    protected string $description;

    /**
     * Expiration for the transaction.
     *
     * @var DateTimeInterface|null
     */
    protected ?DateTimeInterface $expiration = null;

    /**
     * Metadata attached to the transaction.
     *
     * @var array
     */
    protected array $metadata = [];

    /**
     * Callback URL for payment notification.
     *
     * @var string
     */
    protected string $pingUrl;

    /**
     * The amount in cent which should be collected.
     *
     * @var int
     */
    protected int $amount;

    /**
     * Currency for the transaction amount.
     *
     * @var string
     */
    protected string $currency;

    /**
     * User who should pay for the transaction.
     *
     * @var string
     */
    protected string $openId;

    /**
     * App associated with the user who pays the transaction.
     *
     * @var string|null
     */
    protected ?string $appId = null;

    /**
     * Indicates whether the profit should be shared by multiparty.
     *
     * @var bool|null
     */
    protected ?bool $profitSharing = null;

    public function __construct(
        protected App $app,
        protected string $channel
    ) {
        //
    }

    /**
     * Set the merchant which the transaction should be transferred to.
     *
     * @param  string  $merchantId
     * @return $this
     */
    public function forMerchant(string $merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * Set internal order number for the transaction.
     *
     * @param  string  $orderNumber
     * @return $this
     */
    public function orderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Set description for the transaction.
     *
     * @param  string  $description
     * @return $this
     */
    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set expiration for the transaction.
     *
     * @param  DateTimeInterface  $datetime
     * @return TransactionBuilder
     */
    public function expires(DateTimeInterface $datetime): self
    {
        $this->expiration = $datetime;

        return $this;
    }

    /**
     * Set metadata which be attached to the transaction.
     *
     * @param  array  $metadata
     * @return $this
     */
    public function metadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Set callback url for notification.
     *
     * @param  string  $url
     * @return $this
     */
    public function ping(string $url): self
    {
        $this->pingUrl = $url;

        return $this;
    }

    /**
     * Set amount intended to be collected by this transaction.
     *
     * @param  int  $amount  Currency amount in cent.
     * @param  string  $currency  Three-letter ISO currency code.
     * @return $this
     */
    public function amount(int $amount, string $currency = 'CNY'): self
    {
        $this->amount = $amount;
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set payer who should pay for the transaction.
     *
     * @param  string  $openid
     * @return $this
     */
    public function payer(string $openid): self
    {
        $this->openId = $openid;

        return $this;
    }

    /**
     * Set payer from another app who should pay for the transaction.
     *
     * @param  string  $openId
     * @param  string  $appId
     * @return $this
     */
    public function payerFrom(string $openId, string $appId): self
    {
        $this->openId = $openId;
        $this->appId = $appId;

        return $this;
    }

    /**
     * Set whether the profit should be shared by multiparty.
     *
     * @param  bool  $sharesProfit
     * @return $this
     */
    public function sharesProfit(bool $sharesProfit = true): self
    {
        $this->profitSharing = $sharesProfit;

        return $this;
    }

    /**
     * Request payload for creating a new transaction.
     *
     * @return array
     */
    protected function data(): array
    {
        $data = [
            'sp_appid' => $this->app->appId(),
            'sp_mchid' => $this->app->merchantId(),
            'sub_mchid' => $this->merchantId,
            'description' => $this->description,
            'out_trade_no' => $this->orderNumber,
            'attach' => $this->metadata,
            'notify_url' => $this->pingUrl,
            'amount' => [
                'total' => $this->amount,
                'currency' => $this->currency,
            ],
            'payer' => [
                $this->appId ? 'sub_openid' : 'sp_openid' => $this->openId,
            ],
        ];

        if (! is_null($this->appId)) {
            $data['sub_appid'] = $this->appId;
        }

        if (! is_null($this->expiration)) {
            $data['time_expire'] = $this->expiration->format(DateTimeInterface::RFC3339);
        }

        if (! is_null($this->profitSharing)) {
            $data['settle_info']['profit_sharing'] = $this->profitSharing;
        }

        return $data;
    }

    /**
     * Send the transaction creating request.
     *
     * @return \Zhineng\Bubble\Http\Response
     */
    public function create(): Response
    {
        return $this->app->newRequest()
            ->post('/v3/pay/partner/transactions/'.$this->channel, $this->data());
    }
}
