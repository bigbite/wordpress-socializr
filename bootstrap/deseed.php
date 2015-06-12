<?php

use Socializr\Models\Share;

Share::where('default_set', true)->delete();
