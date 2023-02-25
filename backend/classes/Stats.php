<?php

class Stats
{
    protected $pdo;
    protected $user;
    protected $blog;

    public function __construct()
    {
        $this->pdo = Database::instance();
        $this->user = new Users();
        $this->blog = new Blog();
    }

    public function getStats($blogID, $type)
    {
        if($type === 'alltime') {
            $sql = "SELECT *, COUNT(`statsID`) as 'pageviews' FROM `stats` WHERE `blogID` = :blogID ORDER BY `statsID` DESC";
        } else {
            $sql = "SELECT *, COUNT(`statsID`) as 'pageviews' FROM `stats` WHERE date(`date`) = :offset AND `blogID` = :blogID ORDER BY `date` DESC";
        }

        if($type === 'today') {
            $offset = date('Y-m-d');
        } elseif ($type === 'yesterday') {
            $offset = date('Y-m-d', strtotime('-1 day'));
        } elseif ($type === 'week') {
            $offset = date('Y-m-d', strtotime('-7 week'));
        }  elseif ($type === 'month') {
            $offset = date('Y-m-d', strtotime('-1 month'));
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        ($type !== 'alltime') ? $stmt->bindParam("offset", $offset, PDO::PARAM_STR) : null;
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        if($data) {
            echo '
                <div class="st-body-list">
                    <div class="flex fl-row">
                        <div class="fl-4">                
                        </div>
                        <div class="fl-1">
                            '.$data->pageviews.'
                        </div>
                    </div>
                </div>
            ';
        }
    }

    public function getAudience($blogID, $type)
    {
        $offset = '';

        if($type === 'alltime') {
            $sql = "SELECT *, COUNT(`statsID`) as 'pageviews' FROM `stats` WHERE `blogID` = :blogID GROUP BY `country`";
        } else {
            $sql = "SELECT *, COUNT(`statsID`) as 'pageviews' FROM `stats` WHERE date(`date`) = :offset AND `blogID` = :blogID GROUP BY `country`";
        }

        if($type === 'today') {
            $offset = date('Y-m-d');
        } elseif ($type === 'yesterday') {
            $offset = date('Y-m-d', strtotime('-1 day'));
        } elseif ($type === 'week') {
            $offset = date('Y-m-d', strtotime('-7 week'));
        }  elseif ($type === 'month') {
            $offset = date('Y-m-d', strtotime('-30 day'));
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        ($type !== 'alltime') ? $stmt->bindParam("offset", $offset, PDO::PARAM_STR) : null;
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($data)) {
            echo '<p>No stats yet, check back later.</p>';
        } else {
            foreach ($data as $key => $country) {
                echo '
                <div class="st-body-list">
                    <div class="flex fl-row">
                        <div class="fl-4">
                            <p>'.$country->country.'</p>                
                        </div>
                        <div class="fl-1">
                            '.$country->pageviews.'
                        </div>
                    </div>
                </div>
            ';
            }
        }
    }

    public function getPosts($blogID, $type)
    {
        $offset = '';

        if($type === 'alltime') {
            $sql = "SELECT *, `S`.`postID`, COUNT(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Post' GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";
        } else {
            $sql = "SELECT *, `S`.`postID`, COUNT(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Post' AND date(`S`.`date`) = :offset GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";
        }

        if($type === 'today') {
            $offset = date('Y-m-d');
        } elseif ($type === 'yesterday') {
            $offset = date('Y-m-d', strtotime('-1 day'));
        } elseif ($type === 'week') {
            $offset = date('Y-m-d', strtotime('-7 week'));
        }  elseif ($type === 'month') {
            $offset = date('Y-m-d', strtotime('-30 day'));
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        ($type !== 'alltime') ? $stmt->bindParam("offset", $offset, PDO::PARAM_STR) : null;
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($data)) {
            echo '<p>No stats yet, check back later.</p>';
        } else {
            foreach ($data as $data) {
                $date = new DateTime($data->date);
                echo '
                <div class="st-body-list">
                    <div class="flex fl-row">
                        <div class="fl-4">
                            <p><a href="#">'.$data->title.'</a></p>                
                            <p>'.$date->format("M d, Y").'</p>                
                        </div>
                        <div class="fl-1">
                            '.$data->pageviews.'
                        </div>
                    </div>
                </div>
            ';
            }
        }
    }

    public function getPages($blogID, $type)
    {
        $offset = '';

        if($type === 'alltime') {
            $sql = "SELECT *, `S`.`postID`, COUNT(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Page' GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";
        } else {
            $sql = "SELECT *, `S`.`postID`, COUNT(`statsID`) as 'pageviews' FROM `stats` `S` LEFT JOIN `posts` `P` ON `P`.`postID` = `S`.`postID` WHERE `S`.`blogID` = :blogID AND `P`.`postType` = 'Page' AND date(`S`.`date`) = :offset GROUP BY `S`.`postID` ORDER BY `pageviews` DESC";
        }

        if($type === 'today') {
            $offset = date('Y-m-d');
        } elseif ($type === 'yesterday') {
            $offset = date('Y-m-d', strtotime('-1 day'));
        } elseif ($type === 'week') {
            $offset = date('Y-m-d', strtotime('-7 week'));
        }  elseif ($type === 'month') {
            $offset = date('Y-m-d', strtotime('-30 day'));
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        ($type !== 'alltime') ? $stmt->bindParam("offset", $offset, PDO::PARAM_STR) : null;
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($data)) {
            echo '<p>No stats yet, check back later.</p>';
        } else {
            foreach ($data as $data) {
                $date = new DateTime($data->date);
                echo '
                <div class="st-body-list">
                    <div class="flex fl-row">
                        <div class="fl-4">
                            <p><a href="#">'.$data->title.'</a></p>                
                            <p>'.$date->format("M d, Y").'</p>                
                        </div>
                        <div class="fl-1">
                            '.$data->pageviews.'
                        </div>
                    </div>
                </div>
            ';
            }
        }
    }

    public function getReferringSites($blogID, $type)
    {
        $offset = '';

        if($type === 'alltime') {
            $sql = "SELECT `referLink`, COUNT(`statsID`) as 'pageviews' FROM `stats` WHERE `blogID` = :blogID AND `referLink` IS NOT NULL GROUP BY `referLink` ORDER BY `pageviews` DESC";
        } else {
            $sql = "SELECT `referLink`, COUNT(`statsID`) as 'pageviews' FROM `stats` WHERE date(`date`) = :offset AND `blogID` = :blogID AND `referLink` IS NOT NULL GROUP BY `referLink` ORDER BY `pageviews` DESC";
        }

        if($type === 'today') {
            $offset = date('Y-m-d');
        } elseif ($type === 'yesterday') {
            $offset = date('Y-m-d', strtotime('-1 day'));
        } elseif ($type === 'week') {
            $offset = date('Y-m-d', strtotime('-7 week'));
        }  elseif ($type === 'month') {
            $offset = date('Y-m-d', strtotime('-30 day'));
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        ($type !== 'alltime') ? $stmt->bindParam("offset", $offset, PDO::PARAM_STR) : null;
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if(empty($data)) {
            echo '<p>No stats yet, check back later.</p>';
        } else {
            foreach ($data as $data) {
                echo '
                <div class="st-body-list">
                    <div class="flex fl-row">
                        <div class="fl-4">
                            <p><a href="#">'.$data->referLink.'</a></p>                                
                        </div>
                        <div class="fl-1">
                            '.$data->pageviews.'
                        </div>
                    </div>
                </div>
            ';
            }
        }
    }
}