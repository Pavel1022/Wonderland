<?php


namespace WonderlandBundle\Service\Comments;


interface CommentServiceInterface
{
    public function getComments($repository, $comments);

    public function add($comment, $post, $user);
}