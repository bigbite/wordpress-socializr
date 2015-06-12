<?php

use Socializr\Models\Share;

$shares = [
    [ 'Facebook', 'facebook', '//www.facebook.com/sharer/sharer.php?u={{ current_url }}' ],
    [ 'Twitter', 'twitter', '//twitter.com/intent/tweet?text={{ current_title }}&url={{ current_url }}&via=@socializr' ],
    [ 'Google+', 'google-plus', '//plus.google.com/share?url={{ current_url }}' ],
    [ 'LinkedIn', 'linkedin', 'https://www.linkedin.com/shareArticle?mini=true&url={{ current_url }}&title={{ current_title }}&summary=Shared By Socializr&source={{ blog_url }}' ],
    [ 'Reddit', 'reddit', '//www.reddit.com/submit?url={{ current_url }}&title={{ current_title }}' ],
];

foreach ($shares as $share)
{
    list($title, $slug, $url) = $share;

    Share::create(compact('title', 'slug', 'url') + ['default_set' => true]);
}
