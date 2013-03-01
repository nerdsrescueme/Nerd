<?php

namespace CMS;

class Pages
{
    const HOME = 'home';
    const LOGIN = 'login';
    const LOGOUT = 'logout';
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

    public static function get($constant)
    {
        try {
            return constant('\\CMS\\Pages::'.$constant);
        } catch (\Exception $e) {
            return false;
        }
    }
}