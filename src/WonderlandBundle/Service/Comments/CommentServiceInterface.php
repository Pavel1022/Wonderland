<?php


namespace WonderlandBundle\Service\Comments;


interface CommentServiceInterface
{
    public function getComments($repository, $comments);
}