<?php


namespace WonderlandBundle\Service\Post;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use WonderlandBundle\Entity\Post;
use WonderlandBundle\Service\Validator\Post\PostValidatorServiceInterface;

class PostService implements PostServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $postRepository;

    /**
     * @var PostValidatorServiceInterface
     */
    private $postValidatorService;

    /**
     * PostService constructor.
     * @param EntityManagerInterface $entityManager
     * @param PostValidatorServiceInterface $postValidatorService
     */
    public function __construct(EntityManagerInterface $entityManager,
                                PostValidatorServiceInterface $postValidatorService)
    {
        $this->entityManager = $entityManager;
        $this->postValidatorService = $postValidatorService;
        $this->postRepository = $entityManager->getRepository(Post::class);
    }

    /**
     * @param $form
     * @param $post
     * @param $author
     * @param null $fileName
     * @return bool
     */
    public function post($form, $post, $author, $fileName = null)
    {
        $post->setPostImage($fileName);
        $post->setAuthor($author);
        $post->setAddedOn($post->getAddedOn()->format('d-m-Y'));
        $post->setDeleted(0);
        $this->postValidatorService->validateAddPost(
            $post->getTitle(),
            $post->getDescription(),
            $post->getPostImage());
        $errors = $this->postValidatorService->getErrors();
        if($errors) {
            return $errors;
        }
        $em = $this->entityManager;
        $em->persist($post);
        $em->flush();
        return true;
    }

    /**
     * @param $post
     * @param $user
     * @return bool
     */
    public function checkPost($post, $user)
    {
        if ($post === null)
        {
            return false;
        }
        if($post->getDeleted() === true)
        {
            return false;
        }
        if(!$user->isAuthor($post) && !$user->isAdmin())
        {
            return false;
        }
        return true;
    }

    public function edit($post, $form, $fileName = null)
    {
        if ($fileName)
        {
            $post->setPostImage($fileName);
        }
        $this->postValidatorService->validateEditPost(
            $post->getTitle(),
            $post->getDescription());
        $errors = $this->postValidatorService->getErrors();
        if($errors) {
            return $errors;
        }
        $em = $this->entityManager;
        $em->persist($post);
        $em->flush();
        return true;
    }

    public function delete($post, $title, $description)
    {
        $post->setDeleted(1);
        $post->setTitle($title);
        $post->setDescription($description);
        $em = $this->entityManager;
        $em->persist($post);
        $em->flush();
    }
}