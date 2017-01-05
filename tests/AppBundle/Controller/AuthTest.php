<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthTest extends WebTestCase
{
    public function testAuth()
    {
        $client = static::createClient();

        $client->request('POST', '/api/login_check', array('_username' => 'dwnek',  '_password' => '1234'));
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

        $this->assertTrue(key_exists('token', $data) && $data['token']);
    }
}
