<?php


namespace WonderlandBundle\Service\Post;


interface PostServiceInterface
{
    public function post($form, $post,  $author, $fileName = null);

    public function edit($post, $form, $fileName = null);

    public function checkPost($post, $user);

    public function delete($post, $title, $description);
}