<?php

namespace WonderlandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     * @return Response
     */
    public function login()
    {
        if ($this->getUser() !== null)
        {
            return $this->redirectToRoute('homepage');
        }
        return $this->render('security/login.html.twig');
    }
}
