<?php

herbert()->bind(
    'Socializr\Repositories\Set\SetInterface',
    'Socializr\Repositories\Set\SetRepository'
);

herbert()->bind(
    'Socializr\Repositories\Share\ShareInterface',
    'Socializr\Repositories\Share\ShareRepository'
);
