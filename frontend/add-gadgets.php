<?php
include '../backend/init.php';

if (isset($_GET['blogID']) && !empty($_GET['blogID'])) {
    $blogID = (int)$_GET['blogID'];
    $blog = $dashObj->blogAuth($blogID);

    if (!$blog) {
        header('Location: 404');
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
                    {TOP-POSTS NEW GADGET}

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
                                    <a href="javascript:;" id="addGadget">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </span>
                            </div>
                        </div>

                    </div>
                    <!--l-popup-body-ends-->

                    {HTML NEW GADGET}

                    {AUTHOR NEW GADGET}

                    {LABEL NEW GADGET}

                    {LIST NEW GADGET}
                </div>
            </div>
            <!-- JS FILES -->
        </div><!--layout-popup-inner-->
    </div><!--layout-popup-wrapper-->

</div>
</body>
</html>
