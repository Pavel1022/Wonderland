<?php


namespace WonderlandBundle\Service\Comments;


use Doctrine\ORM\EntityManagerInterface;
use WonderlandBundle\Entity\Comment;

class CommentService implements CommentServiceInterface
{

    private $commentRepository;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->commentRepository = $entityManager->getRepository(Comment::class);
    }

    public function getComments($repository, $comments)
    {
        $com = [];
        foreach ($repository as $post)
        {
            $count = 0;
            foreach ($comments as $comment)
            {
                if ($post->getId() === $comment->getPostId())
                {
                    $count++;
                }
            }
            $com[] = $count;

        }
        return $com;
    }

    public function add($comment, $post, $user)
    {
        $comment->setAuthor($user);
        $comment->setPost($post);
        $comment->setDeleted(0);
        $comment->setAddedOn($comment->getAddedOn()->format('d-m-Y'));
        $em = $this->entityManager;
        $em->persist($comment);
        $em->flush();
    }
}