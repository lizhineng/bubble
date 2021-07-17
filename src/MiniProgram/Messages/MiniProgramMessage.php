<?php

namespace Zhineng\Bubble\MiniProgram\Messages;

use Illuminate\Contracts\Support\Arrayable;

class MiniProgramMessage implements Arrayable
{
    public string $miniProgram = 'default';

    public string $templateId;

    public array $data = [];

    public ?string $page = null;

    public function on(string $miniProgram): self
    {
        $this->miniProgram = $miniProgram;

        return $this;
    }

    public function using(string $templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function with(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function redirectTo(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function toArray()
    {
        return [
            'template_id' => $this->templateId,
            'page' => $this->page,
            'data' => $this->data,
        ];
    }
}
