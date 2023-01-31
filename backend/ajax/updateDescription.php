<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['description'])) {

        $description = Validate::escape($_POST['description']);
        $blogID = (int) $_POST['blogID'];
        $blog = $dashObj->blogAuth($blogID);

        if($blog) {
            if($blog->role === "Admin") {
                if(!empty($description)) {
                    $userObj->update('blogs', ['Description' => $description], ['blogID' => $blog->blogID]);
                }
            } else {
                echo "OwnerError";
            }
        }
    }
}
