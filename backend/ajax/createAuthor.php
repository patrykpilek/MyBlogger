<?php

include '../init.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['email'])) {
        $blogID = (int) $_POST['blogID'];
        $email = Validate::escape($_POST['email']);
        $name = Validate::escape($_POST['name']);
        $pass = $_POST['pass'];
        $passRe = $_POST['passRe'];
        $blog = $dashObj->blogAuth($blogID);

        if(!empty($email) && !empty($name) && !empty($pass) && !empty($passRe)) {
            if(Validate::filterEmail($email)) {
                if(!$userObj->emailExist($email)) {
                    if($pass === $passRe) {
                        $password = $userObj->hash($pass);

                        if(!empty($_FILES['file']['name'][0])) {
                            //upload image
                            $image = $userObj->uploadImage($_FILES['file']);
                            if(!$image) {
                                echo $userObj->imageError();
                                exit;
                            }
                        } else {
                            $image = "frontend/assets/images/avatar.png";
                        }

                        if($blog->role === "Admin") {
                            $userID = $userObj->create("users", ['email' => $email, 'fullName' => $name, 'password' => $password, 'profileImage' => $image]);
                            $userObj->create('blogsAuth', ['blogID' => $blog->blogID, 'userID' => $userID, 'role' => 'Author']);
                        } else {
                            echo "Yo don't have rights this preform this actions";
                        }
                    } else {
                        echo "password does not match!";
                    }
                } else {
                    echo "Email is already in use!";
                }
            } else {
                echo "Invalid Email Format!";
            }
        }
    }
}