<?php

namespace Socializr\Services;

use Socializr\Repositories\Set\SetRepository;
use Socializr\Model\Share;
use Socializr\Model\Set;

class Extrapolator
{
    /**
     * Gets a set and optionally echos it.
     *
     * @param string $slug
     * @param bool   $writeout
     *
     * @return array
     */
    public function __construct($slug = null, $writeout = false)
    {
        $this->data = [];
        $this->setRepo = new SetRepository();
        $this->echo = $writeout;

        $set = $this->setRepo->findBySlug($slug);

        if (!$set) {
            echo 'Social Set does not exist';

            return false;
        }

        ($set->type === 'SHARE') ? $this->getShares($set) : $this->getProfiles($set);

        return true;
    }

    /**
     * Gets current sets shares and formats.
     *
     * @param Socializr\Model\Set $set Current Set
     *
     * @return array
     */
    protected function getShares($set)
    {
        $set->shares()->get()->each(function ($share) {
            $this->data[$share->slug] = (Object) [
                'title' => $share->title,
                'url' => $this->processUrl($share->url),
            ];
        });

        return $this->data;
    }

    /**
     * Gets current sets profiles and formats.
     *
     * @param Socializr\Model\Set $set Current Set
     *
     * @return array
     */
    protected function getProfiles($set)
    {
        $set->profile()->get()->each(function ($share) {
            $this->data[$share->handle] = (Object) [
                'title' => $share->title,
                'url' => $this->processUrl($share->url),
            ];
        });

        return $this->data;
    }

    /**
     * Writes out `$this->data` using a list items.
     *
     * @return bool
     */
    protected function writeOut()
    {
        $content = '<ul>';
        foreach ($this->data as $key => $link) {
            $content .= '<li><a href="'.$link->url.'" title="'.$link->title.'">'.$link->title.'</a></li>';
        }
        $content .= '</ul>';

        return $content;
    }

    /**
     * Processes a url replacing `tags` with a data value.
     *
     * @param string $url Unprocessed URL
     *
     * @return string Processed URL
     */
    protected function processUrl($url)
    {
        $post_id = get_the_id();

        $attrs = [
            'current_title' => get_the_title($post_id),
            'current_url' => get_permalink($post_id),
            'blog_title' => get_bloginfo('name'),
            'blog_url' => get_bloginfo('url'),
        ];

        foreach ($attrs as $key => $value) {
            $url = preg_replace('/\{\{\s*'.preg_quote($key).'\s*\}\}/', $value, $url);
        }

        return $url;
    }

    /**
     * Echoes out or returns data.
     *
     * @return Array/Bool
     */
    public function fetch()
    {
        if ($this->echo) {
            return $this->writeOut();
        }

        return $this->data;
    }
}
