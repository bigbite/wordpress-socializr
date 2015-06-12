<?php

namespace Socializr\Repositories\Share;

use Socializr\Helper;
use Socializr\Models\Share;

class ShareRepository implements ShareInterface
{
    /**
     * Create a new Share.
     *
     * @param Array $data Data To be implemented
     *
     * @return Bool Return true or false if model creation passes or fails, respectively.
     */
    public function create($data)
    {
        $data['slug'] = !empty($data['slug']) ? $this->slugify($data['slug']) : $this->slugify($data['title']);

        return Share::create($data);
    }

    /**
     * Modifies an already existing share.
     *
     * @param Integer $id   ID of the Model
     * @param Array   $data The Submitted/new Data for the model
     *
     * @return Bool Return true or false if model modification passes or fails, respectively.
     */
    public function modify($id, $data)
    {
        $share = $this->findById($id);

        $data['slug'] = !empty($data['slug']) ? $this->slugify($data['slug'], $share->id) : $this->slugify($data['title'], $share->id);

        foreach ($data as $key => $value) {
            $share->{$key} = $value;
        }

        return $share->save();
    }

    /**
     * Returns validation rules for a share.
     *
     * @return Array The validation rules for a share.
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'url' => ['required'],
        ];
    }

    /**
     * Get a Share.
     *
     * @param string $slug
     *
     * @return \Socializr\Models\Share
     */
    public function findBySlug($slug)
    {
        return Share::where('slug', $slug)->first();
    }

    /**
     * Get a Share.
     *
     * @param int $id
     *
     * @return \Socializr\Models\Share
     */
    public function findById($id)
    {
        return Share::find($id);
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
}
