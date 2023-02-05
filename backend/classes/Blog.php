<?php

class Blog
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
        if(preg_match('/^([a-zA-Z0-9]+)\.localhost/',$_SERVER['HTTP_HOST'], $match)) {
            $subdomain = $match[1];

            if($blog = $this->user->get('blogs', ['domain' => $subdomain])) {
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
        echo '<meta name="description" content="'.$blog->MetaDescription.'">
              <meta name="robots" content="index, follow">';
    }

    public function getStyles()
    {
        echo '
            <link rel="stylesheet" href="'. BASE_URL .'frontend/assets/template/style/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"/>
            <link href="https://fonts.googleapis.com/css?family=Alatsi&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        ';
    }
}