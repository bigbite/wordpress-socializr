<?php

namespace Socializr\Repositories\Share;

interface ShareInterface
{
    public function create($data);
    public function modify($id, $data);
    public function rules();
}
