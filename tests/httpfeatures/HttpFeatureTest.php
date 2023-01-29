<?php

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;
use CodeIgniter\Test\FilterTestTrait;

class HttpFeatureTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use FilterTestTrait;

    /**
     * test login page as root
     */
    public function testHomeNoAuth(): void
    {
        $result = $this->call('get', '/');
        $this->assertTrue($result->isOK());
        $result->assertRedirectTo('http://aincp-platform.local/index.php/login');
    }

    /**
     * CSFR blocks bot request
     */
    public function testCSFRBlock()
    {
        $this->expectException(\CodeIgniter\Security\Exceptions\SecurityException::class);

        // submit login form
        $this->call('post', 'login', [
            'username'  => 'utente1',
            'password' => 'password1',
        ]);
    }

    /**
     * test auth
     */
    public function testAuth()
    {
        // submit login form
        $result = $this->call('post', 'login', [
            Services::security()->getTokenName() => Services::security()->getHash(),
            'username'  => 'test_user',
            'password' => 'test_password',
        ]);

        $this->assertTrue($result->isOK());
    }

}