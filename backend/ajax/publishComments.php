<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['blogID'])) {
        $blogID = (int) $_POST['blogID'];
        $postIDs = json_decode($_POST['postIDs']);
        $commentIDs = json_decode($_POST['commentIDs']);
        $blog = $dashObj->blogAuth($blogID);

        if($blog) {
            if(!empty($postIDs) && !empty($commentIDs)) {
                foreach ($postIDs as $postID) {
                    foreach ($commentIDs as $commentID) {
                        $post = $userObj->get("posts", ['postID' => $postID]);

                        if($post) {
                            if($blog->role === "Admin" OR $blog->userID === $post->authorID) {
                                $comment = $userObj->get("comments", ['postID' => $post->postID, 'commentID' => $commentID]);
                                if($comment) {
                                    $userObj->update("comments", ['status' => 'Published'], ['commentID' => $comment->commentID, 'postID' => $post->postID]);
                                }
                            } else {
                                echo "You don't have rights to preform this action!";
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}
