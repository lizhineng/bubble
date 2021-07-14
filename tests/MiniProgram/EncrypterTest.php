<?php

namespace Zhineng\Bubble\Tests\MiniProgram;

use stdClass;
use Zhineng\Bubble\MiniProgram\Encrypter;

class EncrypterTest extends UnitTest
{
    public function test_decrypts()
    {
        $decrypted = $this->encrypter($this->key())->decrypt($this->encryptedPayload());
        $this->assertInstanceOf(stdClass::class, $decrypted);
        $this->assertSame('oGZUI0egBJY1zhBYw2KhdUfwVJJE', $decrypted->openId);
    }

    public function test_verifies_watermark()
    {
        $app = $this->makeMiniProgram('wx4f4bc4dec97d474b');
        $this->encrypter($this->key())->withApp($app)->decrypt($this->encryptedPayload());
    }

    /**
     * Sample encrypted payload from docs.
     *
     * @return string[]
     * @link https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/signature.html
     */
    protected function encryptedPayload(): array
    {
        return [
            'value' => 'CiyLU1Aw2KjvrjMdj8YKliAjtP4gsMZMQmRzooG2xrDcvSnxIMXFufNstNGTyaGS9uT5geRa0W4oTOb1WT7fJlAC+oNPdbB+3hVbJSRgv+4lGOETKUQz6OYStslQ142dNCuabNPGBzlooOmB231qMM85d2/fV6ChevvXvQP8Hkue1poOFtnEtpyxVLW1zAo6/1Xx1COxFvrc2d7UL/lmHInNlxuacJXwu0fjpXfz/YqYzBIBzD6WUfTIF9GRHpOn/Hz7saL8xz+W//FRAUid1OksQaQx4CMs8LOddcQhULW4ucetDf96JcR3g0gfRK4PC7E/r7Z6xNrXd2UIeorGj5Ef7b1pJAYB6Y5anaHqZ9J6nKEBvB4DnNLIVWSgARns/8wR2SiRS7MNACwTyrGvt9ts8p12PKFdlqYTopNHR1Vf7XjfhQlVsAJdNiKdYmYVoKlaRv85IfVunYzO0IKXsyl7JCUjCpoG20f0a04COwfneQAGGwd5oa+T8yO5hzuyDb/XcxxmK01EpqOyuxINew==',
            'iv' => 'r7BXXKkLb8qrSNn05n0qiA==',
        ];
    }

    /**
     * Sample session key from docs.
     *
     * @return string
     * @link https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/signature.html
     */
    protected function key(): string
    {
        return 'tiihtNczf5v6AKRyjwEUhQ==';
    }

    protected function encrypter(string $sessionKey): Encrypter
    {
        return new Encrypter($sessionKey);
    }
}
