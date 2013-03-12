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
        $this->addData('posts', $this->app['db.post']->getAllInSite());
        $this->page->setTitle('Browsing Posts');
        $this->page->setLayout('admin/blog/browse');
    }

    public function createAction()
    {
        $post = new Post;

        if ($this->isPost()) {
die(var_dump($_POST));
            $post->setSite($this->app['site']);
            $post->setUser($this->app['user']);
            $post->setTitle($this->post->get('title'));
            $post->setExcerpt($this->post->get('excerpt'));
            $post->setData($this->post->get('data'));

            if (!count($violations = $this->validate($post))) {
                $this->save($post);

                return $this->app->redirect('/admin/blog');
            }

            $this->addData('violations', $violations);
        }

        $this->addData('post', $post);
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