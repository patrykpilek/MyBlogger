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

        if(isset($_GET['type'])) {
            $type = Validate::escape($_GET['type']);
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
                    <?php if(!empty($type) && $type === "topPosts"): ?>
                        <div class="l-popup flex fl-c">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="td-title">
                                        <span>Title</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title"  style="display: block;">
                                            <div class="bn-input">
                                                <input type="text" name="gadgetTitle" id="gadgetTitle">
                                                <div id="error" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>Show</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title"  style="display: block;">
                                            <div class="bn-input">
                                                <div class="papular-inputs">
                                                    <span>
                                                        Display up to
                                                    <select id="postLimit" name="postLimit">
                                                        <option value="10" selected>10</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                    </select>
                                                        post(s)
                                                    </span>
                                                    <br>
                                                </div>
                                                <div class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="lt-foo">
                                <div class="bn-button">
                                    <button id="topPostsBtn" data-blog="<?php echo $blogID; ?>" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" class="btn-newp">Save changes</button>
                                    <button class="cancel-btn" onclick="window.close();">Cancel</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    <?php elseif(!empty($type) && $type === "search"): ?>
                        <div class="l-popup flex fl-c">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="td-title">
                                        <span>Title</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="text" name="searchInput" id="gadgetTitle">
                                                <div id="error" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="lt-foo">
                                <div class="bn-button">
                                    <button id="searchSaveBtn" data-blog="<?php echo $blogID; ?>" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" class="btn-newp">Save changes</button>
                                    <button class="cancel-btn" onclick="window.close();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif(!empty($type) && $type === "html"): ?>
                        <div class="l-popup flex fl-c">
                            <div class="popup-html-widget">
                                <div class="popup-html-sec">
                                    <div class="bn-title"  style="display: block;">
                                        <div class="pop-html-title">
                                            Title
                                        </div>
                                        <div class="bn-input">
                                            <input type="text" name="gadgetTitle" id="gadgetTitle">
                                            <div id="error" class="bt-error" style="display:block;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--popup-html-sec-->
                                <div class="popup-html-sec">
                                    <div class="bn-title" style="display: block;">
                                        <div class="pop-html-title">
                                            Content
                                        </div>
                                        <div class="bn-input">
                                            <textarea class="text-area" id="gadgetContent"></textarea>
                                            <div id="contentError"class="bt-error">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--popup-html-sec ends-->
                            </div>
                            <div class="lt-foo">
                                <div class="bn-button">
                                    <button id="htmlSaveBtn" data-blog="<?php echo $blogID; ?>" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" class="btn-newp">Save changes</button>
                                    <button class="cancel-btn" onclick="window.close();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif(!empty($type) && $type === "profile"): ?>
                        <div class="l-popup flex fl-c">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="td-title">
                                        <span>Title</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title"  style="display: block;">
                                            <div class="bn-input">
                                                <input type="text" name="title" id="gadgetTitle">
                                                <div id="titleError" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>Description</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <textarea class="text-area" id="gadgetContent"></textarea>
                                                <div id="contentError" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>Facebook URL</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="url" name="fbUrl" id="fbUrl">
                                                <div class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>Twiiter URL</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="url" name="twitterUrl" id="twitterUrl">
                                                <div class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>Instagram URL</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="url" name="igUrl" id="igUrl">
                                                <div class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>Youtube URL</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="url" name="ytUrl" id="ytUrl">
                                                <div class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="lt-foo">
                                <div class="bn-button">
                                    <button id="profileBtn" data-blog="<?php echo $blogID; ?>" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" class="btn-newp">Save changes</button>
                                    <button class="cancel-btn" onclick="window.close();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif(!empty($type) && $type === "labels"): ?>
                        <div class="l-popup flex fl-c">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="td-title">
                                        <span>Title</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="text" name="labelsTitle" id="gadgetTitle">
                                                <div id="error" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="lt-foo">
                                <div class="bn-button">
                                    <button id="labelBtn" data-blog="<?php echo $blogID; ?>" data-area="<?php echo $area; ?>" data-pos="<?php echo $pos; ?>" class="btn-newp">Save changes</button>
                                    <button class="cancel-btn" onclick="window.close();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif(!empty($type) && $type === "list"): ?>
                        <div class="l-popup flex fl-c">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="td-title">
                                        <span>Title</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="text" name="gadgetTitle" id="gadgetTitle" value="{GADGET-TITLE}">
                                                <div id="titleError" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>New Site Name</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title" style="display: block;">
                                            <div class="bn-input">
                                                <input type="text" name="siteName" id="siteName">
                                                <div id="nameError" class="bt-error">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-title">
                                        <span>New Site URL</span>
                                    </td>
                                    <td class="td-des">
                                        <div class="bn-title">
                                            <div class="bn-input">
                                                <input type="url" name="siteUrl" id="siteUrl">
                                                <div id="urlError" class="bt-error">
                                                </div>
                                                <div class="add-link-box">
                                                    <div class="add-btn-div">
                                                        <button id="addLink" class="cancel-btn">Add Link</button>
                                                    </div>
                                                    <div class="add-link-body">
                                                        <ul id="linkArea">
                                                            <li>
                                                                <span>
                                                                    <a href="javascript:;" id="deleteLink">Delete</a>
                                                                </span>
                                                                <span>
                                                                    <a id="link" href="{LINK}" target="_blink">{LINK}</a>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="lt-foo">
                                <div class="bn-button">
                                    <button id="listSaveBtn" class="btn-newp">Save changes</button>
                                    <button class="cancel-btn" onclick="window.close();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>
            </div>
            <!-- JS FILES -->
            <script type="text/javascript" src="<?php echo BASE_URL; ?>frontend/assets/js/addGadget.js"></script>
        </div><!--layout-popup-inner-->
    </div><!--layout-popup-wrapper-->

</div>
</body>
</html>
