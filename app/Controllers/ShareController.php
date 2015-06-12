<?php

namespace Socializr\Controllers;

use Socializr\Models\Share;
use Socializr\Services\Validator;
use Socializr\Repositories\Share\ShareInterface;
use Herbert\Framework\RedirectResponse;
use Herbert\Framework\Http;
use Herbert\Framework\Notifier;
use Herbert\Framework\Exceptions\HttpErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShareController
{
    protected $repository;
    /**
     * Constructs the ShareController.
     *
     * @param \Socializr\Repositories\Share\ShareInterface $repository
     */
    public function __construct(ShareInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Shows the share edit form.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\Response
     */
    public function show(Http $http)
    {
        $share = $this->getShare($http->get('set'));

        return view('@Socializr/shares/create.twig', [
            'fd' => $share,
            'deleteLink' => panel_url('Socializr::shares', [
                'action' => 'delete',
                'set' => $share->id,
            ]),
        ]);
    }

    /**
     * Updates a share.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\RedirectResponse
     */
    public function update(Http $http)
    {
        $share = $this->getShare($http->get('set'));

        $input = [
            'title' => $http->get('title'),
            'slug' => $http->get('slug'),
            'url' => $http->get('url'),
        ];

        $rules = $this->repository->rules();

        $validator = new Validator($input, $rules);
        $validator->validate($redirect = panel_url('Socializr::shares'));

        if ($this->repository->modify($share->id, $input)) {
            Notifier::success('Your <strong>sharing link</strong> has been updated', true);

            return new RedirectResponse(panel_url('Socializr::index'));
        }

        return redirect_response(panel_url('Socializr::shares', [
            'action' => 'edit',
            'share' => $share->id,
        ]));
    }

    /**
     * Shows the share destroy form.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\Response
     */
    public function getDestroy(Http $http)
    {
        return view('@Socializr/share/destroy.twig', [
            'share' => $this->getShare($http->get('set')),
        ]);
    }

    /**
     * Destroys a share.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\RedirectResponse
     */
    public function postDestroy(Http $http)
    {
        $share = $this->getShare($http->get('set'));

        $share->delete();

        return redirect_response(panel_url('Socializr::index'));
    }

    /**
     * Get a share.
     *
     * @param int $id
     *
     * @return \Socializr\Models\Share
     */
    protected function getShare($id)
    {
        try {
            return Share::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpErrorException(404, "Share {$id} doesn't exist!");
        }
    }
}
