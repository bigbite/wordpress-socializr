<?php namespace Socializr;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->admin([
    'as'     => 'stylesCSS',
    'src'    => Helper::assetUrl('/styles.css'),
]);
