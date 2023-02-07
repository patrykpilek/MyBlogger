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
        $blog = $this->getBlog();
        echo $blog->Title;
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
                                        <p>' . $content . '</p>
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

    public function getFirstImage($content)
    {
        if (preg_match('/<img.*?src="(.*?)"[^\>]?+>/', $content, $matches)) {
            $image = $matches[1];
        } else {
            $image = BASE_URL . 'frontend/assets/images/404.jpg';
        }

        return $image;
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
                                <span class="auth-labels">'.$this->getPostLabels($post->postID, $post->blogID).'</span>
                            </div>
                        </div>
                    </div><!--POST AUTHOR ENDS--->	
            
                    <!--BLOG POST HERE-->
                    <div class="blog-post">
                    <div class="blog-post-inner">
                        <div class="post">
                            '.$post->content.'
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
            $return .= '<span class="post-label"><a href="'.BASE_URL.'search/label/'.$label->labelName.'">' . $label->labelName . '</a></span>' . (($i < count($labels)) ? ', ' : '');
            $i++;
        }
        return $return;
    }

    public function getHeader()
    {
        return $this->layout->getHeaderGadget();
    }
}