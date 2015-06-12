<?php

namespace Socializr\Controllers;

use Socializr\Models\Set;
use Socializr\Models\Share;

class AdminController
{
    /**
     * Shows an index of the sets and links.
     *
     * @return \Herbert\Framework\Response
     */
    public function index()
    {
        return view('@Socializr/index.twig', [
            'sets' => $this->getSets(),
            'shares' => $this->getShares(),
        ]);
    }

    /**
     * Gets the sets.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getSets()
    {
        return Set::all();
    }

    /**
     * Gets the shares.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getShares()
    {
        return Share::query()
            ->where('default_set', false)
            ->get();
    }
}
