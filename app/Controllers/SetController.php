<?php

namespace Socializr\Controllers;

use Herbert\Framework\Http;
use Socializr\Models\Set;
use Socializr\Repositories\Set\SetInterface;
use Socializr\Services\Validator;
use Socializr\Models\Share;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Herbert\Framework\Exceptions\HttpErrorException;

class SetController
{
    protected $repository;

    /**
     * Constructs the SetController.
     *
     * @param \Socializr\Repositories\Set\SetInterface $repository
     */
    public function __construct(SetInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Shows the set edit form.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\Response
     */
    public function show(Http $http)
    {
        $this->shares = [];
        $set = $this->getSet($http->get('set'));

        $set->shares->each(function ($share) {
            $this->shares[] = $share->id;
        });

        $set->shares = $this->shares;

        return view('@Socializr/sets/create.twig', [
            'fd' => $set,
            'section_title' => 'Edit Set',
            'shares' => $this->getShares(),
            'deleteLink' => panel_url('Socializr::sets', [
                'action' => 'delete',
                'set' => $set->id,
            ]),
        ]);
    }

    /**
     * Updates a set.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\RedirectResponse
     */
    public function update(Http $http)
    {
        $set = $this->getSet($http->get('set'));

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

        $rules = $this->repository->rules($http->get('type'));

        $validator = new Validator($input, $rules);

        $validator->validate($redirect = panel_url('Socializr::sets', [
            'data' => $input,
            'action' => 'edit',
            'set' => $set->id,
        ]));

        $input['slug'] =

        $this->repository->modify($set->id, $input);

        return redirect_response(panel_url('Socializr::sets', [
            'action' => 'edit',
            'set' => $set->id,
        ]));
    }

    /**
     * Shows the set destroy form.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\Response
     */
    public function getDestroy(Http $http)
    {
        return view('@Socializr/set/destroy.twig', [
            'set' => $this->getSet($http->get('set')),
        ]);
    }

    /**
     * Destroys a set.
     *
     * @param \Herbert\Framework\Http $http
     *
     * @return \Herbert\Framework\RedirectResponse
     */
    public function postDestroy(Http $http)
    {
        $set = $this->getSet($http->get('set'));

        $set->delete();

        return redirect_response(panel_url('Socializr::index'));
    }

    /**
     * Get a set.
     *
     * @param int $id
     *
     * @return \Socializr\Models\Set
     */
    protected function getSet($id)
    {
        try {
            return Set::with('shares', 'profile')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpErrorException(404, "Set {$id} doesn't exist!");
        }
    }

    protected function getShares()
    {
        return Share::all();
    }
}
