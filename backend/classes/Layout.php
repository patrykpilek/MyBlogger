<?php

class Layout
{
    protected $db;
    protected $user;

    public function __construct()
    {
        $this->db = Database::instance();
        $this->user = new Users();
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

    public function getHeaderGadget()
    {
        $blog = $this->getBlog();
        $gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'header', 'position' => '1']);
        $content = json_decode($gadget->content);

        if($gadget) {
            echo '
                <header>
                    <div class="bg-des-title-wrap">
                        <a href="'.BASE_URL.'">
                            <h1 class="blogtitle">'.$content->{'title'}.'</h1>
                        </a>
                        <p>
                            '.$content->{'description'}.'
                        </p>
                    </div>
                </header>
            ';
        }
    }

    public function getNavGadget()
    {
        $blog = $this->getBlog();
        $gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'nav', 'displayOn' => 'nav', 'position' => '2']);
        $content = json_decode($gadget->content);

        if($gadget) {
            ?>
            <nav>
                <?php
                    for($i=1; $i <= $content->{'total'}; $i++) {
                        echo '<a href= "'.$content->{'link'.$i}.'">'.$content->{'name'.$i}.'</a>';
                    }
                ?>
            </nav>
            <?php
        }
    }

    public function getSearchGadget($area)
    {
        $blog = $this->getBlog();
        $gadget = $this->user->get("gadgets", ['blogID' => $blog->blogID, 'type' => 'search', 'displayOn' => $area]);

        if($gadget) {
            echo '
                <div class="search-wrap">
                    <div class="search-inner">
                        <div class="search-box">
                            <div class="aside-heading">
                                <h3>Search</h3>	
                            </div>
                            <div class="search-input">
                                <span>
                                    <input type="text" name="search" id="search" >
                                </span>
                                <span>
                                    <button id="searchBtn" id="searchBtn">Search</button>
                                </span>
                            </div>
                        </div>
                    </div>	
                </div>
            ';
        }
    }

    public function getLabelsGadget($area) {
        $blog = $this->getBlog();
        $gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'labels', 'displayOn' => $area]);

        if($gadget) {
            $stmt = $this->db->prepare("SELECT * FROM `labels` WHERE `blogID` = :blogID GROUP BY `labelName`");
            $stmt->bindParam(":blogID", $blog->blogID, PDO::PARAM_INT);
            $stmt->execute();
            $labels = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
                <div class="label-wrap">
                    <div class="label-inner">
                        <div class="label">
                            <div class="aside-heading">
                                <h3>Labels</h3>
                            </div>
                            <div class="label-lists">
                                <ul>
                                    <?php
                                        foreach ($labels as $label) {
                                            echo '<li><a href="'.BASE_URL.'search/label/'.$label->labelName.'">'.$label->labelName.'</a></li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }

    public function getHtmlGadget($area) {
        $blog = $this->getBlog();
        $gadget = $this->user->get('gadgets', ['blogID' => $blog->blogID, 'type' => 'html', 'displayOn' => $area]);

        if($gadget) {
            $content = json_decode($gadget->content);
            ?>
            <div class="label-wrap">
                <div class="label-inner">
                    <div class="label">
                        <div class="aside-heading">
                            <h3><?php echo $content->{'title'}; ?></h3>
                        </div>
                        <div class="label-lists">
                            <?php echo $gadget->html; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function getListGadget($area)
    {
        $blog = $this->getBlog();
        $gadget = $this->user->get("gadgets", ['blogID' => $blog->blogID, 'type' => 'list', 'displayOn' => $area]);

        if($gadget) {
            $list = json_decode($gadget->content);
            ?>
            <div class="list-widget-wrap">
                <div class="list-widget-inner">
                    <div class="aside-heading">
                        <h3>Lists</h3>
                    </div>
                    <div class="list-body">
                        <ul>
                            <?php
                                for($i=1; $i <= $list->{'total'}; $i++) {
                                    echo '<li><a href= "'.$list->{'link'.$i}.'">'.$list->{'name'.$i}.'</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function getAuthorGadget($area)
    {
        $blog = $this->getBlog();
        $gadget = $this->user->get("gadgets", ['blogID' => $blog->blogID, 'type' => 'profile', 'displayOn' => $area]);
        $author = $this->user->userData($blog->CreatedBy);

        if($gadget) {
            $content = json_decode($gadget->content);
            echo '
                <div class="aboutme-wrap">
                    <div class="aboutme-inner">
                        <div class="about-me">
                            <div class="aside-heading">
                                <h3>About</h3>	
                            </div>
                            <div class="aboutme-img">
                                <img src="'.BASE_URL.$author->profileImage.'"/>
                            </div>
                            <div class="aboutme-body">
                                <p>'.$content->{'description'}.'</p>
                            </div>
                            <div class="aboutme-footer">
                            <div class="aboutme-social">
                                <ul>
                                '.(($content->{'Facebook'} !== '') ? '<li><a href="'.$content->{'Facebook'}.'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>' : '').'
                                '.(($content->{'Twitter'} !== '') ? '<li><a href="'.$content->{'Twitter'}.'" target="_blank"><i class="fab fa-twitter"></i></a></li>' : '').'
                                '.(($content->{'Instagram'} !== '') ? '<li><a href="'.$content->{'Instagram'}.'" target="_blank"><i class="fab fa-instagram"></i></a></li>' : '').'
                                '.(($content->{'Youtube'} !== '') ? '<li><a href="'.$content->{'Youtube'}.'" target="_blank"><i class="fab fa-youtube"></i></a></li> ' : '').'  
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    }

    public function getAllGadgets($blogID = '')
    {
        if($blogID != '') {
            $blog = $this->user->get("blogs", ['blogID' => $blogID]);
        } else {
            $blog = $this->getBlog();
        }

        $stmt = $this->db->prepare("SELECT * FROM `gadgets` WHERE `blogID` = :blogID ORDER BY `position`");
        $stmt->bindParam("blogID", $blog->blogID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getSideBar()
    {
        $gadgets = $this->getAllGadgets();
        $i = 1;

        foreach ($gadgets as $gadget) {
            if($gadget->displayOn === "sideBar") {
                do {
                    if($gadget->type === "search") {
                        $this->getSearchGadget($gadget->displayOn);
                    } else if($gadget->type === "labels") {
                        $this->getLabelsGadget($gadget->displayOn);
                    } else if($gadget->type === "html") {
                        $this->getHtmlGadget($gadget->displayOn);
                    } else if($gadget->type === "list") {
                        $this->getListGadget($gadget->displayOn);
                    } else if($gadget->type === "profile") {
                        $this->getAuthorGadget($gadget->displayOn);
                    }
                    $i++;
                } while($gadget->position === $i);
            }
        }
    }
}