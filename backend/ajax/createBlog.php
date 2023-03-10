<?php
include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['blogID'])) {
        $blogID = (int) $_POST['blogID'];
        $title = Validate::escape($_POST['title']);
        $domain = Validate::escape($_POST['url']);
        $blog = $dashObj->blogAuth($blogID);

        if($blog) {
            if(!empty($title) && !empty($domain)) {
                if(strlen($title) > 150 OR strlen($title) < 1) {
                    echo "Title must be between 1 and 150 characters long.";
                } elseif (strlen($domain) < 1 OR strlen($domain) > 50) {
                    echo "This blog address is invalid or not supported.";
                } elseif (!preg_match('/^([a-z]+)$/', $domain)) {
                    echo "This blog address is invalid or not supported.";
                } elseif($blog->blogExist($domain)) {
                    echo "This blog is not available.";
                } else {
                    $html = file_get_contents('../../index.php', FALSE, NULL, 231);
                    $html = htmlentities($templateObj->addTemplateTags($html));

                    $blogID = $userObj->create('blogs', ['Title' => $title, 'Description' => 'Blog Description', 'Domain' => $domain, 'Comments' => 'always', 'PostLimit' => 10, 'CreatedBy' => $blog->userID, 'Template' => $html, 'DefaultDemplate' => true]);

                    $userObj->create("blogsAuth", ['blogID' => $blogID, 'userID' => $blog->userID, 'role' => 'Admin']);

                    $blogObj->createDefaultGadgets($blogID);
                    echo $blogID;
                }
            }
        }
    }
}