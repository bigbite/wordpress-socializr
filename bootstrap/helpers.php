<?php
use Herbert\Framework\Providers\TwigServiceProvider;
use Socializr\Services\Extrapolator;


if ( ! function_exists('socializr'))
{
    /**
     * Gets a set and optionally echos it.
     *
     * @param  string  $slug
     * @param  boolean $echo
     * @return array
     */
    function socializr($slug = null, $echo = false)
    {
        $extrapolator = new Extrapolator($slug, $echo);
        return $extrapolator->fetch();
    }
}


