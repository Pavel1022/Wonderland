<?php

namespace WonderlandBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WonderlandBundle\Entity\Comment;
use WonderlandBundle\Entity\Post;
use WonderlandBundle\Entity\User;
use WonderlandBundle\Form\PostType;
use WonderlandBundle\Service\Comments\CommentService;

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
            $post->setDeleted(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        return $this->render('posts/add.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/post/edit/{id}", name="post_edit")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function editAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);

        if($post === null)
        {
            return $this->redirectToRoute('homepage');
        }

        if($post->getDeleted() === true)
        {
            return $this->redirectToRoute('homepage');
        }

        $image = $post->getPostImage();
        $path = $this->getParameter('postImage_directory').'/'.$image;
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            /**
             * @var UploadedFile $file
             */
            $file = $form['postImage']->getData();
            if($file)
            {
                $fs = new Filesystem();
                $fs->remove([$path]);
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('postImage_directory'), $fileName);
                $post->setPostImage($fileName);
            }
            else {
                $post->setPostImage($image);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_view', [
                'id' => $post->getId()
            ]);
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/delete/{id}", name="post_delete")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);
        $title = $post->getTitle();
        $description = $post->getDescription();
        if($post === null)
        {
            return $this->redirectToRoute('homepage');
        }
        if($post->getDeleted() === true)
        {
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $post->setDeleted(1);
            $post->setTitle($title);
            $post->setDescription($description);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('posts/delete.html.twig', array(
            'post' => $post,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/post/{id}", name="post_view")
     * @param $id
     * @return Response
     */
    public function viewAction($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $commentService = new CommentService();
        $commentsRepository = $this->getDoctrine()->getRepository(Comment::class)->findBy(['deleted' => false]);
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['id' => $id, 'deleted' => false]);
        $user = $this->getDoctrine()->getRepository(User::class)->find($post->getAuthorId());
        $myPosts = $this->getDoctrine()
            ->getRepository('WonderlandBundle:Post')
            ->findBy(['authorId' => $this->getUser()->getId(), 'deleted' => false], ['id' => 'DESC']);
        $myComments = $commentService->getComments($myPosts, $commentsRepository);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['postId' => $id, 'deleted' => false], ['id' => 'DESC']);
        return $this->render('posts/post.html.twig', ['post' => $post,
            'user' => $user,
            'myPosts' => $myPosts,
            'comments' => $comments,
            'myComments' => $myComments]);
    }

    /**
     * @Route("/myPosts", name="my_posts")
     */
    public function myPosts()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $myPosts = $this->getDoctrine()
            ->getRepository('WonderlandBundle:Post')
            ->findBy(['authorId' => $this->getUser()->getId(), 'deleted' => false], ['id' => 'DESC']);
        return $this->render('posts/myPosts.html.twig', ['posts' => $myPosts]);
    }
}
