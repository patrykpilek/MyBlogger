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

}