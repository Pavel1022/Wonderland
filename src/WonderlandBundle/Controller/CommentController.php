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
            $comment->setDeleted(0);
            $comment->setAddedOn($comment->getAddedOn()->format('d-m-Y'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }
        return $this->redirect('http://127.0.0.1:8000/post/' . $id);
    }

    /**
     * @Route("/delete/comment/{id}",name="delete_comment")
     * @param $id
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($id);
        if ($comment->getDeleted() === true)
        {
            return $this->redirectToRoute('homepage');
        }

        $postId = $comment->getPostId();
        $comment->setDeleted(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('post_view', [
            'id' => $postId
        ]);
    }
}
