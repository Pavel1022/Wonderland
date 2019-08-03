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
use WonderlandBundle\Service\Comments\CommentServiceInterface;
use WonderlandBundle\Service\Post\PostServiceInterface;

class PostController extends Controller
{

    /**
     * @var PostServiceInterface
     */
    private $postService;

    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    /**
     * PostController constructor.
     * @param PostServiceInterface $postService
     * @param CommentServiceInterface $commentService
     */
    public function __construct(PostServiceInterface $postService,
                                CommentServiceInterface $commentService)
    {
        $this->postService = $postService;
        $this->commentService = $commentService;
    }

    /**
     * @param Request $request
     *
     * @Route("/post/new/create", name="post_create_action")
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
        /**
         * @var UploadedFile $file
         */
        $file = $form['postImage']->getData();
        if ($this->getUser()->getBan())
        {
            return $this->redirectToRoute('post_create');
        }
        if ($file)
        {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('postImage_directory'), $fileName
            );
            $postAction = $this->postService->post($form, $post, $this->getUser(), $fileName);
        }
        else {
            $postAction = $this->postService->post($form, $post, $this->getUser());
        }

        if (gettype($postAction) === 'array')
        {
            $errors = $postAction;
            return $this->render("posts/add.html.twig",
                ["form" => $form->createView(),
                    "errors" => $errors]
            );
        }
        if ($postAction === true)
        {
            return $this->redirectToRoute('homepage');
        }
        return $this->redirectToRoute('post_create');
    }

    /**
     * @return Response
     * @Route("/post/create", name="post_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     */
    public function viewCreateAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        return $this->render('posts/add.html.twig', [
            'form' => $form->createView(),
            'errors' => false
        ]);
    }

    /**
     * @Route("/edit/post/{id}", name="post_edit_action")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function editAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->getUser()->getBan())
        {
            return $this->redirectToRoute('homepage');
        }
        $post = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);
        $isValid = $this->postService->checkPost($post, $this->getUser());
        if (!$isValid)
        {
            return $this->redirectToRoute('homepage');
        }
        $image = $post->getPostImage();
        $path = $this->getParameter('postImage_directory').'/'.$image;
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
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
                $editAction = $this->postService->edit($post, $form, $fileName);
            }
            else {
                $editAction = $this->postService->edit($post, $form, $image);
            }

            if (gettype($editAction) === 'array')
            {
                $errors = $editAction;
                return $this->render("posts/add.html.twig",
                    ["form" => $form->createView(),
                        'post' => $post,
                        "errors" => $errors]
                );
            }
            if ($editAction === true)
            {
                return $this->redirectToRoute('homepage');
            }
            return $this->redirectToRoute('post_view', [
                'id' => $post->getId()
            ]);
    }

    /**
     * @Route("/post/edit/{id}", name="post_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function viewEditAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);
        $isValid = $this->postService->checkPost($post, $this->getUser());
        if (!$isValid)
        {
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'errors' => false
        ]);
    }

    /**
     * @Route("/delete/post/{id}", name="post_delete_action")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
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
        $isValid = $this->postService->checkPost($post, $this->getUser());
        if (!$isValid)
        {
            return $this->redirectToRoute('homepage');
        }
        $title = $post->getTitle();
        $description =  $post->getDescription();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $this->postService->delete($post, $title, $description);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/post/delete/{id}", name="post_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param $id
     * @param Request $request
     *
     * @return Response
     */
    public function viewDeleteAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $post = $this->getDoctrine()
            ->getRepository(Post::class)->find($id);
        $isValid = $this->postService->checkPost($post, $this->getUser());
        if (!$isValid)
        {
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(PostType::class, $post);
        return $this->render('posts/delete.html.twig', array(
            'post' => $post,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/post/{id}", name="post_view")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param $id
     * @return Response
     */
    public function viewAction($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $commentsRepository = $this->getDoctrine()->getRepository(Comment::class)->findBy(['deleted' => false]);
        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(['id' => $id, 'deleted' => false]);
        $user = $this->getDoctrine()->getRepository(User::class)->find($post->getAuthorId());
        $myPosts = $this->getDoctrine()
            ->getRepository('WonderlandBundle:Post')
            ->findBy(['authorId' => $this->getUser()->getId(), 'deleted' => false], ['id' => 'DESC']);
        $myComments = $this->commentService->getComments($myPosts, $commentsRepository);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['postId' => $id, 'deleted' => false], ['id' => 'DESC']);
        return $this->render('posts/post.html.twig', ['post' => $post,
            'user' => $user,
            'myPosts' => $myPosts,
            'comments' => $comments,
            'myComments' => $myComments]);
    }

    /**
     * @Route("/myPosts", name="my_posts")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
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
