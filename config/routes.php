<?php
return array(

    'admin'=>'admin/index',
    'addNews'=>'admin/addNews',
    'addCategoryWait'=>'admin/categoryWait',
    'addCategory'=>'admin/addCategory',

    'delete/([0-9]+)/comments/([0-9]+)/user/([0-9]+)'=>'comments/deleteCommentNews/$1/$2/$3',

    'Goodbye'=>'site/404',
    'search'=>'search/search',

    'forum/delete/([0-9]+)'=>'forum/deleteCategoryId/$1',
    'forum/edit/([0-9]+)'=>'forum/editIndex/$1',
    'forum/page-([0-9])+'=>'forum/index/$1',
    'forum'=>'forum/index',

    'item/([0-9]+)/delete/([0-9]+)/user/([0-9]+)'=>'forum/deleteCommentForum/$1/$2/$3',//удаление комментариев из темы форума

    'news/delete/([0-9]+)'=>'news/deleteNews/$1',
    'news/edit/([0-9]+)'=>'news/editNews/$1',
    'news/([0-9]+)/page-([0-9]+)'=>'news/showItem/$1/$2',
    'news/page-([0-9]+)'=>'news/index/$1',
    'news/([0-9]+)'=>'news/showItem/$1',
    'news'=>'news/index',

    'user/online/([0-9]+)/page-([0-9]+)'=>'admin/online/$1/$2',
    'user/online/([0-9]+)'=>'admin/online/$1',
    'user/register'=>'user/register',
    'user/login'=>'user/login',
    'user/logout'=>'user/logout',
    'user/block/([0-9]+)/page-([0-9]+)'=>'admin/blockUsers/$1/$2',
    'user/block/([0-9]+)'=>'admin/blockUsers/$1',
    'user/delete/page-([0-9]+)'=>'admin/deleteUser/$1',
    'user/delete'=>'admin/deleteUser',


    'users/allFunctions'=>"admin/AllFunction",

    'cabinet/edit'=>'cabinet/edit',
    'cabinet/([0-9]+)'=>'cabinet/index/$1',

    'category/([0-9]+)/item/([0-9]+)/page-([0-9]+)'=>'forum/item/$2/$1/$3',
    'category/([0-9]+)/item/([0-9]+)'=>'forum/item/$2/$1',
    'category/([0-9]+)/addTheme'=>'forum/addTheme/$1',
    'category/delete/([0-9]+)'=>'forum/deleteView/$1',
    'category/edit/([0-9]+)'=>'forum/editView/$1',
    'category/([0-9])+/page-([0-9])+'=>'forum/views/$1/$2',
    'category/([0-9]+)'=>'forum/views/$1',
    'category/add'=>'forum/addCategoryIndex',

    'comments/add/([0-9]+)'=>'comments/add/$1',


    'contact'=>'site/contact',
    ''=>'site/index',

);