<?php

namespace CMS\Controller;

use CMS\IllegalSaveRequestException;

class AdminController extends BaseController
{
    public function indexAction()
    {
        $this->page->setTitle('Admin Dashboard');
        $this->page->setSubtitle('Administer your site!');
        $this->page->setLayout('admin/blog/index');
    }

    public function saveAction()
    {
        $count = 0;
        $this->page = false;
        $data = json_decode($this->app['post']->get('content'), true);

        // Todo, return an error?
        if (!count($data)) {
            $this->app->finish('Content was not changed, no data has been saved');
            exit;
        }

        foreach ($data as $var => $val) {
            if (!isset($page)) {
                list($type, $pageId) = explode(':', $var);
                if (!$page = $this->app['db.page']->getOneInSite((int) $pageId)) {
                    throw new IllegalSaveRequestException;
                }
            }

            list($type, $pageId, $key) = explode(':', $var);
            $value = $val;

            if(!$region = $page->getRegion($key)) {
                $region = new \CMS\Entity\Region;
                $region->setPage($page);
                $region->setKey($key);
            }

            $region->setData($value);
            $this->app['db']->persist($region);
            $count++;
        }

        $this->app['db']->flush();
        $this->app->finish("Successfully saved $count content blocks");
        exit;
    }
}