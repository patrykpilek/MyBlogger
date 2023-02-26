<?php

include "backend/init.php";

if($blog = $blogObj->getUserBlog()) {
    $userObj->redirect("admin/blogID/{$blog->bligID}/dashboard/");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create a New Blog - MyBlogger</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>frontend/assets/css/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<!--WRAPPER-->
<div class="wrapper">
    <div class="inner-wrapper flex fl-c">

        <div class="sign-up-wrapper fl-row flex fl-1">
            <div class="signup-logo flex fl-1">
                <div class="">
                    <span><i class="fab fa-blogger"></i></span>
                    <h2>Publish your passions, your way</h2>
                    <p>Create a unique and beautiful blog. It’s easy and free.</p>
                </div>
            </div>
            <div class="sign-up-box-wrap flex fl-c fl-1">
                <div class="sign-up-box flex fl-c fl-1">
                    <div class="sign-up-h flex fl-row">
                        <form method="post" enctype="multipart/form-data">
                            <div class="sign-up-avatar fl-4">
                                <div style="width: 200px;">
                                    <div class="avatar-div">
                                        <img id="previewImage" src="<?php echo BASE_URL; ?>frontend/assets/images/avatar.png"/>
                                    </div>
                                    <div>
                                        <input id="file" style="padding-top: 10px;" type="file" name="profileImage">
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="sign-up-body">
                        <div class="blog-t">
                            <div>
                                Blog Title
                            </div>
                            <div>
                                <input type="text" name="title" placeholder="e.g This is blog is about PHP" autocomplete="off">
                                <div>{TITLE-ERROR}</div>
                            </div>
                        </div>
                        <div class="blog-t">
                            <div>
                                Blog Address
                            </div>
                            <div>
                                <input type="text" name="blogUrl" placeholder="e.g mynewblogdomain.localhost/" autocomplete="off">
                                <div class="b-add-error">{URL-ERROR}</div>
                            </div>
                        </div>
                        <div class="sup-div">
                            <div class="sup-div">
                                <input type="text" name="name" placeholder="Name here" autocomplete="off">
                                <div>{NAME-ERROR}</div>
                            </div>
                            <div class="sup-div">
                                <input type="email" name="email" placeholder="Email here" autocomplete="off">
                                <div>{EMAIL-ERROR}</div>
                            </div>
                            <div class="sup-div">
                                <input type="password" name="password" placeholder="Password" autocomplete="off">
                                <div>{Password-ERROR}</div>
                            </div>
                            <div>{All-FIELDS-ERROR}</div>

                        </div>
                    </div>
                    <div class="sign-footer">
                        <button type="submit" name="signup" class="l-btn">Sign-Up</button>
                    </div>
                    </form>
                    <script type="text/javascript">
                        document.querySelector('#file').addEventListener("change", function(event) {
                            let regex = /(\.jpg|\.jpeg|\.png)$/i;

                            if(!regex.exec(this.value)) {
                                alert("Only '.jpeg', '.jpg', '.png', formats are allowed");
                                this.value = '';
                                return false;
                            } else {
                                if(this.files && this.files[0]) {
                                    let reader = new FileReader();
                                    reader.onload = function(event) {
                                        document.querySelector("#previewImage").src = event.target.result;
                                    }
                                    reader.readAsDataURL(this.files[0]);
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
