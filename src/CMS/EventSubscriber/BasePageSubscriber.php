<?php

namespace CMS\EventSubscriber;

use CMS\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class BasePageSubscriber implements EventSubscriberInterface
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getApp()
    {
        return $this->app;
    }
}