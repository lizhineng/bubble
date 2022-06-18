<?php

namespace Zhineng\Bubble\MiniProgram;

class SubscribeMessageSender
{
    protected array $payload = [];

    protected ?string $redirect = null;

    protected ?string $lang = null;

    protected ?string $version = null;

    public function __construct(
        protected SubscribeMessageAbility $ability,
        protected string $templateId
    ) {
        //
    }

    public function withPayload(array $payload = [])
    {
        $this->payload = $payload;

        return $this;
    }

    public function sendTo(string $openId)
    {
        return $this->ability->send(array_filter([
            'touser' => $openId,
            'template_id' => $this->templateId,
            'data' => $this->buildPayload($this->payload),
            'page' => $this->redirect,
            'miniprogram_state' => $this->version,
            'lang' => $this->lang,
        ]));
    }

    public function redirectTo(string $page)
    {
        $this->redirect = $page;

        return $this;
    }

    public function lang(string $lang)
    {
        $this->lang = $lang;

        return $this;
    }

    public function version(string $state)
    {
        $this->version = $state;

        return $this;
    }

    public function production()
    {
        return $this->version(MiniProgramState::Formal);
    }

    public function prod()
    {
        return $this->production();
    }

    public function statging()
    {
        return $this->version(MiniProgramState::Trial);
    }

    public function develop()
    {
        return $this->version(MiniProgramState::Developer);
    }

    protected function buildPayload(array $payload)
    {
        return collect($payload)
            ->flatMap(fn ($value, $key) => [$key => compact('value')])
            ->toArray();
    }
}
