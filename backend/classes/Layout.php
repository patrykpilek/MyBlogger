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
                    }
                    $i++;
                } while($gadget->position === $i);
            }
        }
    }
}