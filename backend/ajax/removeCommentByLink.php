<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['postID'])) {
        $postID = (int) $_POST['postID'];
        $blogID = (int) $_POST['blogID'];
        $commentID = (int) $_POST['commentID'];

        $post = $userObj->get("posts", ['postID' => $postID, 'blogID' => $blogID] );

        $blog = $dashObj->blogAuth($blogID);

        if($post) {
            if($blog->role === "Admin" OR $blog->userID === $post->authorID) {
                if($post) {
                    $comment = $userObj->get("comments", ['commentID' => $commentID, 'postID' => $postID, 'blogID' => $blogID]);

                    if($comment) {
                        $userObj->delete("comments", ['commentID' => $comment->commentID, 'postID' => $post->postID, 'blogID' => $post->blogID]);
                    }
                }
            }else {
                echo "You don't have rights to preform this action !";
            }
        }
    } else {
        echo "Something went wrong!";
    }
}