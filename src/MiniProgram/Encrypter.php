<?php

namespace Zhineng\Bubble\MiniProgram;

use RuntimeException;
use stdClass;
use Zhineng\Bubble\MiniProgram\Exceptions\DecryptException;

class Encrypter
{
    protected string $cipher = 'AES-128-CBC';

    protected ?App $app = null;

    public function __construct(
        protected string $key
    ) {
        $key = base64_decode($key);

        if (static::supported($key, $this->cipher)) {
            $this->key = $key;
        } else {
            throw new RuntimeException('The only supported cipher is AES-128-CBC with the correct key lengths.');
        }
    }

    public static function supported(string $key, string $cipher): bool
    {
        $length = mb_strlen($key, '8bit');

        return $cipher === 'AES-128-CBC' && $length === 16;
    }

    public function withApp(App $app): self
    {
        $this->app = $app;

        return $this;
    }

    public function decrypt(array $payload, bool $decode = true)
    {
        $payload = $this->parsePayload($payload);

        $value = base64_decode($payload['value']);
        $iv = base64_decode($payload['iv']);

        $decrypted = openssl_decrypt(
            $value, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv
        );

        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        $decrypted = $decode ? json_decode($decrypted) : $decrypted;

        if ($this->shouldVerifyResult($decrypted) && ! $this->validResult($decrypted)) {
            throw new DecryptException('The payload watermark is invalid.');
        }

        return $decrypted;
    }

    protected function parsePayload(array $payload): array
    {
        if (! $this->validPayload($payload)) {
            throw new DecryptException('The payload is invalid.');
        }

        return $payload;
    }

    protected function validPayload(array $payload): bool
    {
        return is_array($payload) && isset($payload['iv'], $payload['value']) &&
            strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length($this->cipher);
    }

    protected function shouldVerifyResult(stdClass $data): bool
    {
        return $this->hasApp() && isset($data->watermark->appid);
    }

    protected function validResult(stdClass $data): bool
    {
        return $data->watermark->appid === $this->app->appId();
    }

    protected function hasApp(): bool
    {
        return (bool) $this->app;
    }
}
