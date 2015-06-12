<?php namespace Socializr;
/** @var \Herbert\Framework\API $api */
use Socializr\Services\Extrapolator;

/**
 * Allows the use of {{ Socializr.helper() }} to use any public method from the Helper Class
 */
$api->add('helper', function ()
{
    $args = func_get_args();
    $method = array_shift($args);

    return forward_static_call_array(__NAMESPACE__ . '\\Helper::' . $method, $args);
});

/**
 * Allows usage of {{ Socializr.edit() }} to return the edit link for a set or share
 */
$api->add('edit', function ($type, $id) {
    return panel_url('Socializr::' . $type, [
        'action' => 'edit',
        'set' => $id
    ]);
});

/**
 * returns panel url
 */
$api->add('panel', function ($type) {
    return panel_url('Socializr::' . $type);
});

/**
 * returns extrapolated data. (used for shortcode)
 */
$api->add('showSet', function ($slug) {
    $extrapolator = new Extrapolator($slug, true);
    return $extrapolator->fetch();
});
