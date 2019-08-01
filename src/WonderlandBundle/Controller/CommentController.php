<?php

namespace WonderlandBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WonderlandBundle\Entity\Comment;
use WonderlandBundle\Form\CommentType;

class CommentController extends Controller
{
    /**
     * @Route("/comment/{id}", name="comment")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function commentAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $post = $this->getDoctrine()->getRepository('WonderlandBundle:Post')->find($id);
            $comment->setAuthor($this->getUser());
            $comment->setPost($post);
            $comment->setAddedOn($comment->getAddedOn()->format('d-m-Y'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }
        return $this->redirect('http://127.0.0.1:8000/post/' . $id);
    }
}
