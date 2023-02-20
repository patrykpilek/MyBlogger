<?php
include '../backend/init.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['blogID']) && !empty($_GET['blogID'])) {
        $blogID = (int)$_GET['blogID'];
        $blog = $dashObj->blogAuth($blogID);

        if(isset($_GET['area']) && isset($_GET['pos'])) {
            $area = Validate::escape($_GET['area']);
            $pos = (int) $_GET['pos'];
        }

        if (!$blog) {
            header('Location: 404');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gadgets List - MyBlogger</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>frontend/assets/css/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
<!--WRAPPER-->
<div class="wrapper">
    <div class="inner-wrapper flex fl-c">
        <!--HEADER-WRAPPER-->
        <div class="header-wrapper flex fl-c">
            <header class="header">
                <div class="header-popup flex f-c">
                    <div class="header-in flex fl-row">
                        <div class="logo flex fl-row fl-1">
                            <div><i class="fab fa-blogger"></i></div>
                            <div class="fl-1">
                                <h3>Gadgets</h3>
                            </div>
                        </div>
                    </div><!--HEADER-IN-ENDS-HERE-->
                </div>
            </header>
            <div class="header-bottom flex fl-row">
                <div class="lay-header">
                    <h3>
                        Add a Gadget
                    </h3>
                </div>
            </div>
        </div>
        <!--HEADER-WRAPPER-ENDS-HERE-->

        <!--layout-popup-wrapper-->
        <div class="layout-pop-wrap">
            <!--layout-popup-inner-->
            <div class="layout-pop-inner">

                <div class="laypopup-box">
                    <div class="l-popup flex fl-c">
                        {EDIT-GADGETS}
                    </div>
                    <!--l-popup-body-->
                    <div class="l-popup-body">
                        <div class="lp-box flex fl-row">
                            <div>
                                <span>
                                    <i class="fas fa-newspaper"></i>
                                </span>
                            </div>
                            <div class="lpopup-title fl-4">
                                <div class="lpopup-head">
                                    <a href="javaScript;:" class="add-color">Popular Posts</a>
                                </div>
                                <div class="lpopup-body">
                                    Highlight posts on your blog.
                                </div>
                            </div>
                            <div class="lpopup-add">
                                <span>
                                    <a href="javascript:;" id="addGadget" data-type="topPosts" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" data-blog="<?php echo $blogID; ?>">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--l-popup-body-ends-->

                    <!--l-popup-body-->
                    <div class="l-popup-body">
                        <div class="lp-box flex fl-row">
                            <div>
                                <span><i class="fas fa-search"></i></span>
                            </div>
                            <div class="lpopup-title fl-4">
                                <div class="lpopup-head">
                                    <a href="#">Blog Search</a>
                                </div>
                                <div class="lpopup-body">
                                    Let visitors search your blog.
                                </div>
                            </div>
                            <div class="lpopup-add">
                                <span>
                                    <a href="javascript:;" id="addGadget" data-type="search" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" data-blog="<?php echo $blogID; ?>">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>

                    </div>
                    <!--l-popup-body-ends-->

                    <!--l-popup-body-->
                    <div class="l-popup-body">
                        <div class="lp-box flex fl-row">
                            <div>
                                <span><i class="fas fa-code"></i></span>
                            </div>
                            <div class="lpopup-title fl-4">
                                <div class="lpopup-head">
                                    <a href="#">HTML/JavaScript</a>
                                </div>
                                <div class="lpopup-body">
                                    Add third-party functionality or other code to your blog.
                                </div>
                            </div>
                            <div class="lpopup-add">
                                <span>
                                    <a href="javascript:;" id="addGadget" data-type="html" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" data-blog="<?php echo $blogID; ?>">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--l-popup-body-ends-->

                    <!--l-popup-body-->
                    <div class="l-popup-body">
                        <div class="lp-box flex fl-row">
                            <div>
                                <span><i class="fas fa-user"></i></span>
                            </div>
                            <div class="lpopup-title fl-4">
                                <div class="lpopup-head">
                                    <a href="#">Profile</a>
                                </div>
                                <div class="lpopup-body">
                                    Display information about yourself to your visitors.
                                </div>
                            </div>
                            <div class="lpopup-add">
                                <span>
                                    <a href="javascript:;" id="addGadget" data-type="profile" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" data-blog="<?php echo $blogID; ?>">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--l-popup-body-ends-->

                    <!--l-popup-body-->
                    <div class="l-popup-body">
                        <div class="lp-box flex fl-row">
                            <div>
                                <span><i class="fas fa-tags"></i></span>
                            </div>
                            <div class="lpopup-title fl-4">
                                <div class="lpopup-head">
                                    <a href="#">Labels</a>
                                </div>
                                <div class="lpopup-body">
                                    Show all the labels of posts in your blog.
                                </div>
                            </div>
                            <div class="lpopup-add">
                                <span>
                                    <a href="javascript:;" id="addGadget" data-type="labels" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" data-blog="<?php echo $blogID; ?>">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--l-popup-body-ends-->

                    <!--l-popup-body-->
                    <div class="l-popup-body">
                        <div class="lp-box flex fl-row">
                            <div>
                                <span><i class="fas fa-list-ul"></i></span>
                            </div>
                            <div class="lpopup-title fl-4">
                                <div class="lpopup-head">
                                    <a href="#">Link List</a>
                                </div>
                                <div class="lpopup-body">Display a collection of your favorite sites, blogs, or web pages for your visitors.
                                </div>
                            </div>
                            <div class="lpopup-add">
                                <span>
                                    <a href="javascript:;" id="addGadget" data-type="list" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" data-blog="<?php echo $blogID; ?>">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--l-popup-body-ends-->
                </div>
            </div>
            <!-- JS FILES -->
            <script type="text/javascript" src="<?php echo BASE_URL; ?>frontend/assets/js/addGadget.js"></script>
        </div><!--layout-popup-inner-->
    </div><!--layout-popup-wrapper-->

</div>
</body>
</html>
