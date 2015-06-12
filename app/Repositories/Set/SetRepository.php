<?php

namespace Socializr\Repositories\Set;

use Socializr\Helper;
use Socializr\Models\Set;
use Socializr\Models\Share;
use Socializr\Models\Profile;

class SetRepository implements SetInterface
{
    /**
     * Create a new Set.
     *
     * @param Array $data Data To be implemented
     *
     * @return Bool Return true or false if model creation passes or fails, respectively.
     */
    public function create($data)
    {
        $shares_input = array_get($data, 'shares', []);
        $profile_input = array_get($data, 'profile', []);

        $data['slug'] = ($data['slug']) ? $this->slugify($data['slug']) : $this->slugify($data['title']);
        $set = Set::create($data);

        $stream = $data['type'] === 'SHARE' ? $data['shares'] : $data['profile'];
        $set = $this->attachRelationships($set, $data['type'], $stream);

        return $set->save();
    }

    /**
     * Modifies an already existing set.
     *
     * @param Integer $id   ID of the Model
     * @param Array   $data The Submitted/new Data for the model
     *
     * @return Bool Return true or false if model modification passes or fails, respectively.
     */
    public function modify($id, $data)
    {
        $set = $this->findById($id);

        if (!$set) {
            return false;
        }

        $this->clearRelationshipData($id);
        $set->title = $data['title'];
        $set->slug = !empty($data['slug']) ? $this->slugify($data['slug'], $set->id) : $this->slugify($data['title'], $set->id);
        $set->type = $data['type'];

        $stream = $data['type'] === 'SHARE' ? $data['shares'] : $data['profile'];

        $set = $this->attachRelationships($set, $data['type'], $stream);

        return $set->save();
    }

    /**
     * Returns validation rules for a Set.
     *
     * @param String $type Type of set
     *
     * @return Array The validation rules for a set.
     */
    public function rules($type)
    {
        $rules = [
            'title' => ['required'],
        ];

        if ($type === 'SHARE') {
            $rules['shares'] = ['required'];
        } else {
            $rules['profile.*.title'] = ['required'];
            $rules['profile.*.url'] = ['required'];
        }

        return $rules;
    }

    /**
     * Get a Set.
     *
     * @param string $slug
     *
     * @return \Socializr\Models\Set
     */
    public function findBySlug($slug)
    {
        return Set::where('slug', $slug)->first();
    }

    /**
     * Get a set.
     *
     * @param int $id
     *
     * @return \Socializr\Models\Set
     */
    public function findById($id)
    {
        return Set::find($id);
    }

    /**
     * Clears all relationship data between a set and Shares & Profiles.
     *
     * @param int $id
     */
    public function clearRelationshipData($id)
    {
        $this->set = $this->findById($id);

        if (!$this->set) {
            return false;
        }

        $this->set->shares->each(function ($share) {
            $this->set->shares()->detach($share->id);
        });

        $this->set->profile->each(function ($profile) {
            Profile::find($profile->id)->delete();
        });

        $this->set->save();
    }

    /**
     * Finds a set with specific rules.
     *
     * @param Array $query A multi dimentional array of numerous conditions to find a specific Set
     *
     * @return \Socializr\Models\Set
     */
    public function findWhere($query)
    {
        foreach ($query as $key => $sql) {
            $set = !isset($set) ? Set::where($sql[0], $sql[1], $sql[2]) : $set->where($sql[0], $sql[1], $sql[2]);
        }

        return $set->first();
    }

    /**
     * Returns a url safe `slug` that is unique.
     *
     * @param string  $text   unsage/nonunique slug
     * @param Integer $exists
     *
     * @return string Safe, unique slug String.
     */
    private function slugify($text, $exists = null)
    {
        $text = Helper::formatSlug($text);
        $set = $this->findBySlug($text);
        $unique = false;

        if (!$set || $set->id === $exists) {
            $unique = true;

            return $text;
        }

        $i = 0;

        while (!$unique) {
            $i++;
            $set = $this->findBySlug($text.'-'.$i);

            if (!$set || $set->id === $exists) {
                $unique = true;
            }
        }

        return $text.'-'.$i;
    }

    /**
     * Attaches all relational post data to the specified set.
     *
     * @param \Socializr\Models\Set $set  Specified Set
     * @param string                $type specifies the type of data to be attached
     * @param Array                 $data Data to be attached
     *
     * @return \Socializr\Models\Set Returns the set with all relational data attached
     */
    protected function attachRelationships($set, $type, $data)
    {
        if ($type === 'SHARE') {
            $set->shares()->attach($data);
        } else {
            $profiles = [];

            foreach ($data as $key => $profile) {
                $profile['handle'] = !empty($profile['handle']) ? Helper::formatSlug($profile['handle']) : Helper::formatSlug($profile['title']);
                $profiles[] = new Profile($profile);
            }

            $set->profile()->saveMany($profiles);
        }

        return $set;
    }
}
