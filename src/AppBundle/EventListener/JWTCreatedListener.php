<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, UserManagerInterface $userManager)
    {
        $this->requestStack = $requestStack;
        $this->userManager = $userManager;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        $user = $this->userManager->findUserByUsernameOrEmail($payload['username']);
        $payload['user_id'] = '/users/'.$user->getId();

        $event->setData($payload);
    }
}