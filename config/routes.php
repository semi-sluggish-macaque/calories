<?php
//при работе с регулярными правилами, более конкретные правила должны быть выше чем менее конкретные
//импрот
use cal\router;

//сработает, если вначале будет admin и затем любай, удовлетворяящяя правила строка

router::add('^admin/?$', ['controller' => 'Main', 'action' => 'index', 'admin_prefix' => 'admin']);

//сработает, если вначале будет admin и затем любай, удовлетворяящяя правила строка
//                                         этот ? значит что + / при отсутствия action необизательный
router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['admin_prefix' => 'admin']);


// ^(?P<lang>[a-z]+)?/?   эта часть не являеться обязательной

router::add('^(?P<lang>[a-z]+)?/?category/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Category', 'action' => 'view']);


router::add('^(?P<lang>[a-z]+)?/?search/?$', ['controller' => 'Search', 'action' => 'index']);

router::add('^(?P<lang>[a-z]+)?/?face/?$', ['controller' => 'Face', 'action' => 'index']);


router::add('^(?P<lang>[a-z]+)?/?wishlist/?$', ['controller' => 'Wishlist', 'action' => 'index']);


router::add('^(?P<lang>[a-z]+)?/?page/(?P<slug>[a-z0-9-]+)/?$', ['controller' => 'Page', 'action' => 'view']);


//регулярные выражения. ^-начало строки, $-конец строки. получается что описывается пустая строка(между символами ничего нет)
//по скольку тут невозможно назначить контреллер и action, его надо передать
router::add('^(?P<lang>[a-z]+)?/?$', ['controller' => 'Main', 'action' => 'index']);

//сдесь будет присутствовать какой-то набор символов с ключём controller(с action соотвестсвенно)
//записывается в массив два значения, одно с индексом controller и значенмием, которое может быть любым
//с символами от a до z и возможен дефис, второе для action аналогично
router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');

router::add('^(?P<lang>[a-z]+)/(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');
