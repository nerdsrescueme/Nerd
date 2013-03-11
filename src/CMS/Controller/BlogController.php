<?php

namespace CMS\Controller;

use CMS\IllegalSaveRequestException;
use CMS\Entity\Post;

class BlogController extends BaseController
{
    public function browseAction()
    {
        $post = new Post;
        $post->setTitle('a');

$violations = $this->getValidator()->validate($post);
foreach ($violations as $violation) {
    echo (string) $violation->getMessage().'<br>'.PHP_EOL;
}
die('');

        $this->addData('posts', $this->app['db.post']->getAllInSite());

        $this->page->setTitle('Browsing Posts');
        $this->page->setLayout('admin/blog/browse');
    }

    public function createAction()
    {
        $this->addData('post', new Post);

        $this->page->setTitle('Add new post');
        $this->page->setLayout('admin/blog/create');
    }

    public function readAction()
    {
        $id = (int) $this->route->values['id'];
        $post = $this->app['db.post']->getOneInSite($id);
        $this->addData('post', $post);

        $this->page->setTitle($post->getTitle());
        $this->page->setLayout('admin/blog/read');
    }

    public function updateAction()
    {
        $id = (int) $this->route->values['id'];
        $post = $this->app['db.post']->getOneInSite($id);
        $this->addData('post', $post);

        $this->page->setTitle('Updating post');
        $this->page->setLayout('admin/blog/update');
    }

    public function deleteAction()
    {
        $id = (int) $this->route->values['id'];
        $post = $this->app['db.post']->getOneInSite($id);
        $this->app['db']->remove($post);
        $this->app->redirect('/admin/blog');
    }
}