<?php

namespace Zhineng\Bubble\Tests\Payment;

use Carbon\Carbon;
use Zhineng\Bubble\Http\Request;
use Zhineng\Bubble\Payment\App;
use Zhineng\Bubble\Payment\TransactionBuilder;
use Zhineng\Bubble\Tests\HttpTest;

class TransactionAbilityTest extends HttpTest
{
    public function test_transaction_can_be_created_via_jsapi()
    {
        $this->newTransaction()->create();

        $this->http->assertSent(function (Request $request) {
            return $request->url() === 'https://api.mch.weixin.qq.com/v3/pay/partner/transactions/jsapi'
                && $request['sp_appid'] === 'sp_app_id'
                && $request['sp_mchid'] === 'sp_merchant_id'
                && $request['sub_mchid'] === 'merchant_id'
                && $request['description'] === 'Custom Payment'
                && $request['out_trade_no'] === 'order_number'
                && $request['notify_url'] === 'https://example.com/callback'
                && $request['amount']['total'] === 1
                && $request['amount']['currency'] === 'CNY'
                && $request['payer']['sp_openid'] === 'openid';
        });
    }

    public function test_metadata_can_be_attached()
    {
        $this->newTransaction()->metadata(['foo' => 'bar'])->create();

        $this->http->assertSent(function ($request) {
            return $request['attach'] === ['foo' => 'bar'];
        });
    }

    public function test_it_may_have_expiration()
    {
        $this->newTransaction()->expires(Carbon::now())->create();

        $this->http->assertSent(function (Request $request) {
            return $request['time_expire'] === Carbon::now()->toRfc3339String();
        });
    }

    public function test_payer_may_belong_to_another_app()
    {
        $this->newTransaction()->payerFrom('openid', 'another_app_id')->create();

        $this->http->assertSent(function (Request $request) {
            return $request['payer']['sub_openid'] === 'openid'
                && $request['sub_appid'] === 'another_app_id'
                && ! array_key_exists('sp_openid', $request['payer']);
        });
    }

    public function test_profit_may_be_shared()
    {
        $this->newTransaction()->sharesProfit()->create();

        $this->http->assertSent(fn ($request) => $request['settle_info']['profit_sharing']);
    }

    protected function newTransaction(): TransactionBuilder
    {
        return $this->createApp()
            ->newTransactionVia('jsapi')
            ->forMerchant('merchant_id')
            ->orderNumber('order_number')
            ->description('Custom Payment')
            ->amount(1)
            ->payer('openid')
            ->ping('https://example.com/callback');
    }

    protected function createApp(): App
    {
        return (new App('sp_app_id', 'sp_merchant_id'))
            ->httpUsing($this->http->fake());
    }
}
