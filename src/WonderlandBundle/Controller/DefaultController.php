<?php

namespace WonderlandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WonderlandBundle\Entity\Comment;
use WonderlandBundle\Service\Comments\CommentService;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $commentService = new CommentService();
        $posts = $this->getDoctrine()->getRepository('WonderlandBundle:Post')->findBy(['deleted' => false], ['id' => 'DESC']);
        $commentsRepository = $this->getDoctrine()->getRepository(Comment::class)->findBy(['deleted' => false]);
        $allComments = $commentService->getComments($posts, $commentsRepository);
        if (TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $myPosts = $this->getDoctrine()
                ->getRepository('WonderlandBundle:Post')
                ->findBy(['authorId' => $this->getUser()->getId(), 'deleted' => false], ['id' => 'DESC']);
            $myComments = $commentService->getComments($myPosts, $commentsRepository);
            return $this->render('homepage/index.html.twig', [
                'posts' => $posts,
                'myPosts' => $myPosts,
                'comments' => $allComments,
                'myComments' => $myComments
            ]);
        }
        return $this->render('homepage/index.html.twig', [
            'posts' => $posts,
            'comments' => $allComments
        ]);
    }
}
