<?php

class Template
{
    protected $pdo;
    protected $user;
    protected $blog;
    protected $layout;

    public function __construct()
    {
        $this->pdo = Database::instance();
        $this->user = new Users();
        $this->blog = new Blog();
        $this->layout = new Layout();
    }

    public function addTemplateTags($html)
    {
        $html = str_replace('<?php $blogObj->getTitle(); ?>', '{{TITLE}}', $html);
        $html = str_replace('<?php $blogObj->getStyles(); ?>', '{{STYLES}}', $html);
        $html = str_replace('<?php $blogObj->getMeta(); ?>', '{{META}}', $html);
        $html = str_replace('<?php $blogObj->getHeader(); ?>', '{{HEADER}}', $html);
        $html = str_replace('<?php $blogObj->getNav(); ?>', '{{NAV}}', $html);
        $html = str_replace('<?php $blogObj->getBlogPosts(); ?>', '{{POSTS}}', $html);
        $html = str_replace('<?php $blogObj->getSideBar(); ?>', '{{SIDEBAR}}', $html);
        $html = str_replace('<?php $blogObj->getFooter(); ?>', '{{FOOTER}}', $html);
        return $html;
    }

}