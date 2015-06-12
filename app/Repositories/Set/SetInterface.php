<?php

namespace Socializr\Repositories\Set;

interface SetInterface
{
    public function create($data);
    public function modify($id, $data);
    public function rules($type);
    public function findBySlug($slug);
    public function findById($id);
}
