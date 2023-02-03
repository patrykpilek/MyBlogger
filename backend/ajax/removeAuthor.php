<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['blogID'])) {
        $blogID = (int) $_POST['blogID'];
        $authorID = (int) $_POST['authorID'];
        $blog = $dashObj->blogAuth($blogID);
        $author = $userObj->userData($authorID);

        if($blog) {
          if($blog->role === 'Admin') {
              if ($blog->CreatedBy === $author->userID) {
                  echo "Blog creator can't be removed!";
                  exit();
              } else {
                  if($blog->userID !== $author->userID) {
                      $userObj->delete('users', ['userID' => $author->userID]);
                      $userObj->delete('blogsAuth', ['userID' => $author->userID]);
                  } else {
                      echo "You can't remove your self from author list";
                  }
              }
          } else {
              echo "You don't have rights to preform this action!";
          }
        }
    }
}