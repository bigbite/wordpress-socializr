<?php

/**
 * Allows usage of [socializr handle=""] as a shortcode
 */
$shortcode->add(
    'socializr',
    'Socializr::showSet',
    [
        'slug' => 'handle'
    ]
);
