<?php

namespace WonderlandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WonderlandBundle\Entity\Comment;
use WonderlandBundle\Entity\User;
use WonderlandBundle\Service\Comments\CommentService;
use WonderlandBundle\Service\Comments\CommentServiceInterface;

class AdminController extends Controller
{
    private $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @Route("/users/all", name="all_users")
     */
    public function viewAllUsers()
    {
        if (!$this->getUser()->isAdmin())
        {
            return $this->redirectToRoute("homepage");
        }
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/allUsers.html.twig', [
            "users" => $users
        ]);
    }

    /**
     * @Route("/user/ban/{id}", name="ban_user")
     * @param $id
     * @return RedirectResponse
     */
    public function ban($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setBan(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("all_users");
    }

    /**
     * @Route("/user/unban/{id}", name="unban_user")
     * @param $id
     * @return RedirectResponse
     */
    public function unban($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setBan(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("all_users");
    }
}
