<?php

namespace Socializr\Controllers;

use Socializr\Models\Share;
use Socializr\Services\Validator;
use Socializr\Repositories\Share\ShareInterface;
use Herbert\Framework\RedirectResponse;
use Herbert\Framework\Http;
use Herbert\Framework\Notifier;

class SharesController
{
    protected $repository;

    /**
     * Constructs the SharesController.
     *
     * @param \Socializr\Repositories\Share\ShareInterface $repository
     */
    public function __construct(ShareInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Shows the share creation form.
     *
     * @return \Herbert\Framework\Response
     */
    public function create()
    {
        return view('@Socializr/shares/create.twig', [
            'section_title' => 'Add New Share',
        ]);
    }

    /**
     * Stores the share.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\RedirectResponse
     */
    public function store(Http $http)
    {
        $input = [
            'title' => $http->get('title'),
            'slug' => $http->get('slug'),
            'url' => $http->get('url'),
        ];

        $rules = $this->repository->rules();

        $validator = new Validator($input, $rules);
        $validator->validate($redirect = panel_url('Socializr::shares'));

        if ($this->repository->create($input)) {
            Notifier::success('Your <strong>sharing link</strong> has been created', true);

            return new RedirectResponse(panel_url('Socializr::index'));
        }
    }
}
