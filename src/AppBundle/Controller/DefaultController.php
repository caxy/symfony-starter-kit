<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index_action")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        if ($this->isGranted(User::ROLE_DEFAULT)) {
            return $this->redirectToRoute('sonata_admin_dashboard');
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    /**
     * @param Request $request
     *
     * @Route("/auth/signup", name="auth_signup")
     *
     * @return Response
     */
    public function authSignUpAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $this->get('serializer')->deserialize($request->getContent(), User::class, 'json');

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if(count($errors) > 0) {
            return new JsonResponse($errors);
        }

        $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');

        $user->setSalt($salt);

        $userManager->updateUser($user, true);

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $response = new Response();

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }
}
