<?php

namespace Socializr\Controllers;

use Socializr\Models\Set;
use Socializr\Models\Share;
use Socializr\Services\Validator;
use Socializr\Repositories\Set\SetInterface;
use Herbert\Framework\RedirectResponse;
use Herbert\Framework\Http;
use Herbert\Framework\Notifier;

class SetsController
{
    protected $repository;

    /**
     * Constructs the SetsController.
     *
     * @param \Socializr\Repositories\Set\SetInterface $repository
     */
    public function __construct(SetInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Shows the set creation form.
     *
     * @return \Herbert\Framework\Response
     */
    public function create()
    {
        return view('@Socializr/sets/create.twig', [
            'section_title' => 'Add New Set',
            'shares' => $this->getShares(),
        ]);
    }

    /**
     * Stores the set.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\RedirectResponse
     */
    public function store(Http $http)
    {
        /*
         * 1. Collect all http data
         * 2. Validate
         * 3. Pass off to Repo
         */

        $input = [
            'title' => $http->get('title'),
            'type' => $http->get('type'),
            'slug' => $http->get('slug'),
        ];

        if ($http->get('type') === 'SHARE') {
            $input['shares'] = $http->get('shares');
        } else {
            $input['profile'] = $http->get('profile');
        }

        $rules = $this->repository->rules($input['type']);

        $validator = new Validator($input, $rules);
        $validator->validate($redirect = panel_url('Socializr::sets'));

        if ($this->repository->create($input)) {
            Notifier::success('Your Set has been created', true);

            return new RedirectResponse(panel_url('Socializr::index'));
        }

        Notifier::error('Something went wrong there, please try again', true);

        return (new RedirectResponse(panel_url('Socializr::sets')))->with('__form_data', $input);
    }

    /**
     * Gets the shares.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getShares()
    {
        return Share::all();
    }
}
