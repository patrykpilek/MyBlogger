<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['blogID'])) {
        $blogID = (int) $_POST['blogID'];
        $postID = (int) $_POST['postID'];
        $name = Validate::escape($_POST['name']);
        $email = Validate::escape($_POST['email']);
        $comment = Validate::escape($_POST['comment']);

        $post = $userObj->get('posts', ['blogID' => $blogID, 'postID' => $postID]);
        $date = date('Y-m-d H:i:s');
        if($post) {
            if(!empty($name) && !empty($email) && !empty($email)) {
                $userObj->create("comments", ['postID' => $post->postID, 'blogID' => $post->blogID, 'replied' => '0', 'name' => $name, 'email' => $email, 'comment' => $comment, 'status' => 'Pending', 'date' => $date]);
            } else {
                echo 'something went wrong!';
            }
        }
    }
}
