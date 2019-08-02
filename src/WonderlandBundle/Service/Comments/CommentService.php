<?php


namespace WonderlandBundle\Service\Comments;


class CommentService implements CommentServiceInterface
{

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
}