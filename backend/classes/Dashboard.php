<?php

class Dashboard
{
    protected $db;

    protected $user;

    public function __construct()
    {
        $this->db = Database::instance();
        $this->user = new Users();
    }

    public function blogAuth($blogID)
    {
        $user_id = $this->user->ID();
        $stmt = $this->db->prepare("SELECT * FROM `blogs` `B`, `blogsAuth` `A` 
                                        LEFT JOIN `users` `U` ON `A` . `userID` = `U` . `userID` 
                                        WHERE `B` . `blogID` = `A` .`blogID` AND `B` . `blogID` = :blogID AND `U` . `userID` = :userID");
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        $stmt->bindParam(":userID", $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function searchPosts($search, $blogID) {
        $stmt = $this->db->prepare("SELECT * FROM `posts`, `users` WHERE `authorID` = `userID` AND `title` LIKE ? AND `blogID` = ?");
        $stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
        $stmt->bindValue(2, $blogID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllPosts($offset, $limit, $type, $status = '', $blogID)
    {
        if($status === '') {
            $sql = "SELECT * FROM `posts` LEFT JOIN `users` ON `userID` = `authorID` 
                    WHERE `postType` = :type AND `blogID` = :blogID ORDER BY `postID` 
                    DESC LIMIT :offset, :postLimit";
        } else {
            $sql = "SELECT * FROM `posts` LEFT JOIN `users` ON `userID` = `authorID` 
                    WHERE `postType` = :type AND  `postStatus` = :status AND `blogID` = :blogID ORDER BY `postID` 
                    DESC LIMIT :offset, :postLimit";
        }

        if(!empty($offset)) {
            $offset = ($offset-1)*$limit;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        ($status !== '') ? $stmt->bindParam(":status", $status, PDO::PARAM_STR) : '';
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":postLimit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($posts) {
            foreach ($posts as $post) {
                $date = new DateTime($post->createdDate);
                echo '
                    <div class="m-r-c-inner">
                        <div class="posts-wrap">
                            <div class="posts-wrap-inner">
                                <div class="post-link flex fl-row">
                                    <div class="post-in-left fl-1 fl-row flex">
                                        <div class="p-in-check">
                                            <input type="checkbox" class="postCheckBox" value="'.$post->postID.'" data-blog="'.$post->blogID.'"/>
                                        </div>
                                        <div class="fl-1">
                                            <div class="p-l-head flex fl-row">
                                                <div class="pl-head-left fl-1">
                                                    <div class="pl-h-lr-link">
                                                        <a href="{POST-LINK}">' . $post->title . '</a>
                                                    </div>
                                                    <div class="pl-h-lf-link">
                                                        <ul>
                                                            '. $this->getPostLabels($post->postID, $post->blogID) .'
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="pl-head-right">
                                                    <span>' . (($post->postStatus === 'draft') ? 'Draft' : '') . '</span>
                                                </div>
                                            </div>
                                            <div class="p-l-footer">
                                                <ul>
                                                    <li><a href="{EDIT-LINK}">Edit</a></li>
                                                    |
                                                    <li><a href="javascript:;" id="deletePost" data-post="'. $post->postID.'" data-blog="'. $post->blogID.'">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-in-right">
                                        <div class="p-in-right flex fl-1">
                                            <div class="pl-auth-name"><span>
                                                <a href="javascript:;">' . $post->fullName . '</a></span>
                                            </div>
                                            <div class="pl-cm-count">
                                                <span>0</span>
                                                <span><i class="fas fa-comment"></i></span>
                                            </div>
                                            <div class="pl-views-count">
                                                <span>0</span>
                                                <span><i class="fas fa-eye"></i></span>
                                            </div>
                                            <div class="pl-post-date">
                                                <span>' . $date->format('d/m/y') . '</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '
                <div class="posts-wrap">
                    <div class="posts-wrap-inner">
                        <div class="nopost flex">
                            <div>
                                <p>There are no '. $type .'s. </p><a href="{CREATE-POST-LINK}">Create a new ' . $type .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            ';
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
            $return .= '<li><a href="#">'.$label->labelName.'</a></li>' . (($i < count($labels)) ? ', ' : '');
            $i++;
        }
        return $return;
    }

    public function getLabelsMenu($blogID)
    {
        $stmt = $this->db->prepare("SELECT * FROM `labels` WHERE `blogID` = :blogID GROUP BY `labelName`");
        $stmt->bindParam(':blogID', $blogID, PDO::PARAM_INT);
        $stmt->execute();

        $labels = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($labels as $label) {
            echo '<li class="label" data-id="'.$label->ID.'"><a href="javascript:;">'.$label->labelName.'</a></li>';
        }
    }

    public function getPostsCount($type, $status, $blogID)
    {
        if($status === '') {
            $sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `blogID` = :blogID";
        } else {
            $sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `postStatus` = :status AND `blogID` = :blogID";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        ($status !== '') ? $stmt->bindParam(":status", $status, PDO::PARAM_STR) : '';
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        if($data) {
            echo"({$stmt->rowCount()})";
        }
    }

    public function getPaginationPages($postLimit, $type, $status, $blogID) {
        if($status === '') {
            $sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `blogID` = :blogID";
        } else {
            $sql = "SELECT * FROM `posts` WHERE `postType` = :type AND `postStatus` = :status AND `blogID` = :blogID";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        ($status !== '') ? $stmt->bindParam(":status", $status, PDO::PARAM_STR) : '';
        $stmt->bindParam(":blogID", $blogID, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        $total = $stmt->rowCount();

        $pages = ceil($total/$postLimit);

        for($i=1; $i < $pages+1; $i++) {
            echo '<li class="pageNum">' . $i . '</li>';
        }
    }
}