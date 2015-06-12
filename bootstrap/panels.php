<?php namespace Socializr;

/** @var \Herbert\Framework\Panel $panel */

/**
 * Plugin home
 * That shows Sets and custom social shares
 */
$panel->add([
    'type'   => 'panel',
    'as'     => 'index',
    'title'  => 'Socializr',
    'slug'   => 'socializr-index',
    'icon'   => Helper::assetUrl('socializr-logo.png'),
    'uses'   => __NAMESPACE__ . '\\Controllers\\AdminController@index'
]);

/**
 * The panel that controls a sets creation, modification and deletion
 */
$panel->add([
    'type'   => 'sub-panel',
    'parent' => 'index',
    'as'     => 'sets',
    'title'  => 'Sets',
    'slug'   => 'socializr-sets',
    'uses'   => __NAMESPACE__ . '\\Controllers\\SetsController@create',
    'get'    => [
        'edit' => __NAMESPACE__ . '\\Controllers\\SetController@show',
        'delete' => __NAMESPACE__ . '\\Controllers\\SetController@getDestroy',
    ],
    'post' => [
        'uses' => __NAMESPACE__ . '\\Controllers\\SetsController@store',
        'edit' => __NAMESPACE__ . '\\Controllers\\SetController@update',
        'delete' => __NAMESPACE__ . '\\Controllers\\SetController@postDestroy',
    ]
]);

/**
 * The panel that controls a shares creation, modification and deletion
 */
$panel->add([
    'type'   => 'sub-panel',
    'parent' => 'index',
    'as'     => 'shares',
    'title'  => 'Shares',
    'slug'   => 'socializr-shares',
    'uses'   => __NAMESPACE__ . '\\Controllers\\SharesController@create',
    'get'    => [
        'edit' => __NAMESPACE__ . '\\Controllers\\ShareController@show',
        'delete' => __NAMESPACE__ . '\\Controllers\\ShareController@getDestroy',
    ],
    'post' => [
        'uses' => __NAMESPACE__ . '\\Controllers\\SharesController@store',
        'edit' => __NAMESPACE__ . '\\Controllers\\ShareController@update',
        'delete' => __NAMESPACE__ . '\\Controllers\\ShareController@postDestroy',
    ]
]);

/**
 * Documentation Panel... To be finished.
 */

// $panel->add([
//     'type'   => 'sub-panel',
//     'parent' => 'index',
//     'as'     => 'docs',
//     'title'  => 'Documentation',
//     'slug'   => 'socializr-docs',
//     'uses'   => __NAMESPACE__ . '\\Controllers\\DocumentationController@get',
// ]);
