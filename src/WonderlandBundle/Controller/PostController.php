<?php

namespace WonderlandBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WonderlandBundle\Entity\Comment;
use WonderlandBundle\Entity\Post;
use WonderlandBundle\Entity\User;
use WonderlandBundle\Form\PostType;

class PostController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/post/create", name="post_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form['postImage']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('postImage_directory'), $fileName
            );
            $post->setPostImage($fileName);
            $post->setAuthor($this->getUser());
            $post->setAddedOn($post->getAddedOn()->format('d-m-Y'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('posts/add.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/post/{id}", name="post_view")
     * @param $id
     * @return Response
     */
    public function viewAction($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $user = $this->getDoctrine()->getRepository(User::class)->find($post->getAuthorId());
        $myPosts = $this->getDoctrine()
            ->getRepository('WonderlandBundle:Post')
            ->findBy(['authorId' => $this->getUser()->getId()], ['id' => 'DESC']);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['postId' => $id], ['id' => 'DESC']);
        return $this->render('posts/post.html.twig', ['post' => $post,
            'user' => $user,
            'myPosts' => $myPosts,
            'comments' => $comments]);
    }

    /**
     * @Route("/myPosts", name="my_posts")
     */
    public function myPosts()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $myPosts = $this->getDoctrine()
            ->getRepository('WonderlandBundle:Post')
            ->findBy(['authorId' => $this->getUser()->getId()], ['id' => 'DESC']);
        return $this->render('posts/myPosts.html.twig', ['posts' => $myPosts]);
    }
}
