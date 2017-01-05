<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
