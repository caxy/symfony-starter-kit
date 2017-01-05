<?php

namespace tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AuthenticatedClientWebTestCase extends WebTestCase
{
    /**
     * @param string $username
     * @param string $password
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(
                '_username' => $username,
                '_password' => $password,
            )
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}