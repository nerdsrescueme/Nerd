<?php

namespace CMS;

class PageEvents
{
    const HOME = 'home';
    const LOGIN = 'login';
    const PAGE = 'page';

    const BLOG = 'blog';
    const BLOG_HOME = 'blog.home';
    const BLOG_CATEGORY = 'blog.category';
    const BLOG_POST = 'blog.home';

    const STORE = 'store';
    const STORE_HOME = 'store.home';
    const STORE_CATEGORY = 'store.category';
    const STORE_PRODUCT = 'store.product';
    const STORE_CART = 'store.cart';
    const STORE_CHECKOUT = 'store.checkout';

    const ADMIN = 'admin';
    const ADMIN_BLOG = 'admin.blog';
    const ADMIN_STORE = 'admin.store';
    const ADMIN_PAGE = 'admin.page';
    const ADMIN_FILES = 'admin.files';
}