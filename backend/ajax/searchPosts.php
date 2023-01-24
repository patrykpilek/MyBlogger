<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['search'])) {
        $search = Validate::escape($_POST['search']);
        $blogID = (int) $_POST['blogID'];
        $blog = $dashObj->blogAuth($blogID);

        if($blog) {
            echo "result";
        }
    }
}