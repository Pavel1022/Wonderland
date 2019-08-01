<?php

namespace WonderlandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use WonderlandBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository('WonderlandBundle:Post')->findBy([], ['id' => 'DESC']);
        if (TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $myPosts = $this->getDoctrine()
                ->getRepository('WonderlandBundle:Post')
                ->findBy(['authorId' => $this->getUser()->getId()], ['id' => 'DESC']);
            return $this->render('homepage/index.html.twig', [
                'posts' => $posts,
                'myPosts' => $myPosts
            ]);
        }
        return $this->render('homepage/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
