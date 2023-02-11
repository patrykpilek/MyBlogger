<?php

class Blog
{
    protected $db;
    protected $user;
    protected $layout;

    public function __construct()
    {
        $this->db = Database::instance();
        $this->user = new Users();
        $this->layout = new Layout();
    }

    public function getBlog()
    {
        if (preg_match('/^([a-zA-Z0-9]+)\.localhost/', $_SERVER['HTTP_HOST'], $match)) {
            $subdomain = $match[1];

            if ($blog = $this->user->get('blogs', ['domain' => $subdomain])) {
                return $blog;
            } else {
                $this->user->redirect('404');
            }
        }
    }

    public function getTitle()
    {
        $post = $this->getPost();
        $blog = $this->getBlog();
        echo ((isset($post->title)) ? $post->title : $blog->Title);
    }

    public function getMeta()
    {
        $blog = $this->getBlog();
        echo '<meta name="description" content="' . $blog->MetaDescription . '">
              <meta name="robots" content="index, follow">';
    }

    public function getStyles()
    {
        echo '
            <link rel="stylesheet" href="' . BASE_URL . 'frontend/assets/template/style/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
            <link href="https://fonts.googleapis.com/css?family=Alatsi&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        ';
    }

    public function getBlogPosts()
    {
        $blog = $this->getBlog();
        $stmt = $this->db->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `userID` = `authorID` WHERE `blogID` = :blogID AND `postStatus` = 'published' AND `postType` = 'Post' ORDER BY `postID` DESC LIMIT :postLimit");
        $stmt->bindParam(":blogID", $blog->blogID, PDO::PARAM_INT);
        $stmt->bindParam(":postLimit", $blog->PostLimit, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $date = new DateTime($post->createdDate);
                $content = substr(strip_tags($post->content), 0, 500);

                echo '
                    <div class="post-out">
                        <div class="post-out-show">
                            <div class="post-title">
                                <a href="' . BASE_URL . $post->slug . '">
                                    <h1>' . $post->title . '</h1>
                                </a>
                            </div>
                            <div class="post-author">
                                <div class="pa-inner">
                                    <div>
                                        <span class="author-span">
                                            <span class="auth-img">
                                                <img src="' . BASE_URL . $post->profileImage . '"/>
                                            </span>
                                            <span class="auth-name">
                                                <a href="#">' . $post->fullName . '</a>
                                            </span>
                                        </span>
                                        <span class="auth-time">
                                            <span class="auth-c">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                            <span class="auth-date">
                                                ' . $date->format('M d, Y') . '
                                            </span>
                                        </span>
                                        <span class="auth-labels"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="post-body">
                                <div class="postout-show">
                                    <div class="postout-img">
                                        <img src="' . $this->getFirstImage($post->content) . '"/>
                                    </div>
                                    <div class="postout-text">
                                        <p>'.$content.'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="read-more">
                                <div class="read-btn"><a href="' . BASE_URL . $post->slug . '">Readmore</a></div>
                            </div>
                            <div class="post-footer"></div>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '
                <div class="post-out">
                    <div class="post-out-show">
                        <H3>NO BLOG POSTS!</h3>
                    </div>
                </div>
            ';
        }
    }

    public function getSearchResult($search) {
        return $this->getBlogSearch($search);
    }

    public function getFirstImage($content)
    {
        if (preg_match('/<img.*?src="(.*?)"[^\>]?+>/', $content, $matches)) {
            $image = BASE_URL.$matches[1];
        } else {
            $image = BASE_URL . 'frontend/assets/images/404.jpg';
        }

        return $image;
    }

    public function getBlogSearch($search) {
        $keyword = '%'.$search.'%';
        $blog = $this->getBlog();
        $stmt = $this->db->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `userID` = `authorID` WHERE `blogID` = :blogID AND `postStatus` = 'published' AND `title` LIKE :search ORDER BY `postID` DESC");
        $stmt->bindParam(":blogID", $blog->blogID, PDO::PARAM_INT);
        $stmt->bindParam(":search", $keyword, PDO::PARAM_STR);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($posts) {
            foreach ($posts as $post) {
                $date = new DateTime($post->createdDate);
                $content = substr(strip_tags($post->content), 0, 500);
                echo '
                <div class="post-out">
                    <div class="post-out-show">
                        <div class="post-title">
                            <a href="'.BASE_URL.$post->slug.'">
                                <h1>'.$post->title.'</h1>
                            </a>
                        </div>
                        <div class="post-author">
                            <div class="pa-inner">
                                <div>
                                    <span class="author-span">
                                        <span class="auth-img">
                                            <img src="'.BASE_URL.$post->profileImage.'"/>
                                        </span>
                                        <span class="auth-name">
                                            <a href="#">'.$post->fullName.'</a>
                                        </span>
                                    </span>
                                    <span class="auth-time">
                                        <span class="auth-c">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        <span class="auth-date">
                                            '.$date->format('M d, Y').'
                                        </span>
                                    </span>
                                    <span class="auth-labels"></span>
                                </div>
                            </div>
                        </div>
                        <div class="post-body">
                            <div class="postout-show">
                                <div class="postout-img">
                                    <img src="'.$this->getFirstImage($post->content).'"/>
                                </div>
                                <div class="postout-text">
                                    <p>'.$content.'</p>
                                </div>
                            </div>
                        </div>
                        <div class="read-more">
                            <div class="read-btn"><a href="'.BASE_URL.$post->slug.'">Readmore</a></div>
                        </div>
                        <div class="post-footer"></div>
                    </div>
                </div>
            ';
            }
        } else {
            if($blog->CustomError != '') {
                echo html_entity_decode($blog->CustomError);
            } else {
                echo '<p align="center"><font size="5">PAGE NOT FOUND!</font></p><br/><br/><p><font style="font-size: 150px; font-weight: bold; color: red;">404</font></p>';
            }
        }
    }

    public function getPostData($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM `posts` LEFT JOIN `users` ON `userID` = `authorID` WHERE `slug` = :slug");
        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            if (isset($_GET['slug']) && !empty($_GET['slug'])) {
                $slug = Validate::escape($_GET['slug']);
                $post = $this->getPostData($slug);
                return $post;
            }
        }
    }

    public function displayPostData()
    {
        $post = $this->getPost();
        $date = new DateTime($post->createdDate);

        echo '
            <div class="post-out-wrap">
                <div class="post-out-inner">
                    <div class="post-title">
                        <a href="' . BASE_URL . $post->slug . '">
                            <h1>' . $post->title . '</h1>
                        </a>
                    </div>
                    <div class="post-author">
                        <div class="pa-inner">
                            <div>
                                <span class="author-span">
                                    <span class="auth-img">
                                        <img src="' . BASE_URL . $post->profileImage . '"/>
                                    </span>
                                    <span class="auth-name">
                                        <a href="#">' . $post->fullName . '</a>
                                    </span>
                                </span>
                                <span class="auth-time">
                                    <span class="auth-c">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                    <span class="auth-date">
                                        ' . $date->format('M d, Y') . '
                                    </span>
                                </span>
                                <span class="auth-labels">' . $this->getPostLabels($post->postID, $post->blogID) . '</span>
                            </div>
                        </div>
                    </div><!--POST AUTHOR ENDS--->	
            
                    <!--BLOG POST HERE-->
                    <div class="blog-post">
                    <div class="blog-post-inner">
                        <div class="post">
                            ' . $post->content . '
                        </div>
                        <!--POST ENDS HERE-->
                    </div>	
                    </div>
                    <!--BLOG POST ENDS HERE-->
            
                </div>
                <!--post-out-inner-->
            </div>
            <!--post-out-wrap-->
        ';
        $this->getComments();
    }

    public function getCommentsReplies($blogID, $commentID)
    {
        $stmt = $this->db->prepare("SELECT * FROM `comments` WHERE `blogID` = :blogID AND `replied` = :commentID AND `status` = 'published' ORDER BY `commentID` DESC");
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        $stmt->bindParam(":commentID", $commentID, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($comments) {
            foreach ($comments as $comment) {
                echo '
                <div class="cb-inner">
                    <div class="comment flex fl-row">
                        <div class="comment-img">
                            <div class="c-img-body">
                                <img src="https://www.gravatar.com/avatar/'. md5(strtolower(trim($comment->email))) .'">
                            </div>
                        </div>
                        <div class="comment-text fl-6">
                        <div class="comment-text-inner flex fl-c">
                            <div class="comment-text fl-6">
                                <small><span>'.$comment->name.'</span></small>
                            <div class="comment-text-inner">
                                '.$comment->comment.'
                            </div>	
                            </div>
                            <div class="comment-footer">
                                <span><a href="javascript;:">Delete</a></span>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }
    }

    public function getComments()
    {
        $blog = $this->getBlog();
        $post = $this->getPost();
        $stmt = $this->db->prepare("SELECT * FROM `comments` WHERE `postID`= :postID AND `blogID` = :blogID AND `status` = 'published' OR `replied` = `commentID` ORDER BY `commentID` DESC");
        $stmt->bindParam(":postID", $post->postID, PDO::PARAM_INT);
        $stmt->bindParam(":blogID", $blog->blogID, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($comments) {
            ?>
            <div class="comment-show-wrapper">
                <div class="comment-show-inner">
                    <div class="comment-count">
                        <div>
                            <span>Comment: <span><?php echo count($comments) ?></span></span>
                        </div>
                    </div>
                    <div class="comment-body">
                        <!--cb-inner-->
                        <?php foreach ($comments as $comment):
                            if($comment->replied === 0):
                        ?>
                        <div class="cb-inner">
                            <div class="comment flex fl-row">
                                <div class="comment-img">
                                    <div class="c-img-body">
                                        <img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($user->email))); ?>">
                                    </div>
                                </div>
                                <div class="comment-text fl-6">
                                    <div class="comment-text-inner flex fl-c">
                                        <div class="comment-text fl-6">
                                            <small><span><?php echo $comment->name; ?></span></small>
                                            <div class="comment-text-inner">
                                                <?php echo $comment->comment; ?>
                                            </div>
                                        </div>
                                        <div class="comment-footer">
                                            <span><a href="javascript:;" id="replyBtn" data-reply="<?php echo $comment->commentID; ?>">Reply</a></span>
                                            <span><a href="javascript:;">Delete</a></span>
                                        </div>
                                    </div>
                                    <?php $this->getCommentsReplies($post->blogID, $comment->commentID); ?>
                                </div>
                            </div>
                        </div>
                        <!--cb-inner ends-->
                        <?php
                        endif;
                        endforeach;
                        echo '</div>';
        }
        $this->getCommentForm($post->blogID, $post->postID);
        echo '<script type="text/javascript" src="'.BASE_URL.'frontend/assets/js/comments.js"></script>';
    }

    public function getCommentForm($blogID, $postID)
    {
        echo '
            <div class="comment-wrapper">
                <div class="comment-inner">
                    <div class="comment-input">
                        <input type="text"  name="name"   id="name"  placeholder="Name">
                        <input type="email" name="email"  id="email" placeholder="Email">
                    </div>
                    <div class="comment-textarea">
                        <textarea rows="10" name="comment" id="comment" placeholder="Your Comment"></textarea>
                    </div>
                    <div class="comment-submit">
                        <button id="commentBtn" data-blog="'.$blogID.'" data-post="'.$postID.'" data-reply="0">Submit</button>
                        <button id="cancelBtn">Cancel</button>
                    </div>
                </div>
            </div>
        ';
    }

    public function displayLabelPosts($label)
    {
        $blog = $this->getBlog();
        $posts = $this->getLabelPosts($label, $blog->blogID);

        if ($posts) {
            foreach ($posts as $post) {
                $date = new DateTime($post->createdDate);
                $content = substr(strip_tags($post->content), 0, 500);
                echo '
                   <div class="post-out">
                        <div class="post-out-show">
                            <div class="post-title">
                                <a href="' . BASE_URL . $post->slug . '">
                                    <h1>' . $post->title . '</h1>
                                </a>
                            </div>
                            <div class="post-author">
                                <div class="pa-inner">
                                    <div>
                                        <span class="author-span">
                                            <span class="auth-img">
                                                <img src="' . BASE_URL . $post->profileImage . '"/>
                                            </span>
                                            <span class="auth-name">
                                                <a href="#">' . $post->fullName . '</a>
                                            </span>
                                        </span>
                                        <span class="auth-time">
                                            <span class="auth-c">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                            <span class="auth-date">
                                                ' . $date->format('M d, Y') . '
                                            </span>
                                        </span>
                                        <span class="auth-labels"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="post-body">
                                <div class="postout-show">
                                    <div class="postout-img">
                                        <img src="' . $this->getFirstImage($post->content) . '"/>
                                    </div>
                                    <div class="postout-text">
                                        <p>'.$content.'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="read-more">
                                <div class="read-btn"><a href="' . BASE_URL . $post->slug . '">Readmore</a></div>
                            </div>
                            <div class="post-footer"></div>
                        </div>
                    </div>

                ';
            }
        }
    }

    public function getPostPage()
    {
        $blog = $this->getBlog();

        if($_SERVER['REQUEST_METHOD'] === "GET") {
            if(isset($_GET['label']) && !empty($_GET['label'])) {
                $label = Validate::escape($_GET['label']);
                $this->displayPostData($label);
            } else if(isset($_GET['search']) && !empty($_GET['search'])) {
                $search = Validate::escape($_GET['search']);
                $this->getSearchResult($search);
            }else {
                if(!$this->getPost()) {
                    if($blog->CustomError != '') {
                        echo html_entity_decode($blog->CustomError);
                    } else {
                        echo '<p align="center"><font size="5">PAGE NOT FOUND!</font></p><br/><br/><p><font style="font-size: 150px; font-weight: bold; color: red;">404</font></p>';
                    }
                } else {
                    $this->displayPostData();
                }
            }
        }
    }

    public function getPostLabels($postID, $blogID)
    {
        $stmt = $this->db->prepare("SELECT *FROM `labels` WHERE `postID` = :postID AND `blogID` = :blogID");
        $stmt->bindParam(":postID", $postID, PDO::PARAM_INT);
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        $stmt->execute();
        $labels = $stmt->fetchAll(PDO::FETCH_OBJ);

        $i = 1;
        $return = '';

        foreach ($labels as $label) {
            $return .= '<span class="post-label"><a href="' . BASE_URL . 'search/label/' . $label->labelName . '">' . $label->labelName . '</a></span>' . (($i < count($labels)) ? ', ' : '');
            $i++;
        }
        return $return;
    }

    public function getLabelPosts($label, $blogID)
    {
        $stmt = $this->db->prepare("SELECT * FROM `posts` `p` 
                                    LEFT JOIN `users` `u` ON `p`.`authorID` = `u`.`userID` 
                                    LEFT JOIN `labels` `l` ON `p`.`postID` = `l`.`postID` 
                                    AND `p`.`blogID` = 'l'.`blogID` 
                                    WHERE `p`.`postStatus` = `published` 
                                    AND `l`.`labelName` = :label 
                                    AND `l`.`blogID` = :blogID");
        $stmt->bindParam(":label", $label, PDO::PARAM_STR);
        $stmt->bindParam(":blogID", $label, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getHeader()
    {
        return $this->layout->getHeaderGadget();
    }

    public function getNav()
    {
        return $this->layout->getNavGadget();
    }

    public function getSideBar()
    {
        return $this->layout->getSideBar();
    }

    public function getFooter()
    {
        return $this->layout->getFooter();
    }
}