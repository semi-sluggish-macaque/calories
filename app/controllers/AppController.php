<?php

namespace app\controllers;

use app\models\AppModel;
use app\models\Wishlist;
use app\widgets\language\Language;
use cal\Controller;
use cal\app;
use RedBeanPHP\R;

class AppController extends Controller
{

    public function __construct($route = [])
    {

        parent::__construct($route);

        new AppModel();

        //получение всех языков с бд и внесесние их в пропертис
        app::$app->setProperty('languages', Language::getLanguages());
        //внесение в пропертис текущего языка
        app::$app->setProperty('language', Language::getLanguage(app::$app->getProperty('languages')));

        $lang = app::$app->getProperty('language');

        \cal\language::load($lang['code'], $this->route);

//        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c
//                        JOIN category_description cd
//                        ON c.id = cd.category_id
//                        WHERE cd.language_id = ?", [$lang['id']]);

//        app::$app->setProperty();

//        app::$app->setProperty("wishlist", Wishlist::get_wishlist_ids());
    }

}