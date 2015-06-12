<?php

namespace Socializr\Tables;

use Illuminate\Database\Schema\Blueprint;

class ProfilesTable
{
    /**
     * Activates the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public function activate(Blueprint $table)
    {
        $table->increments('id');

        $table->string('title');
        $table->string('handle');
        $table->string('url');

        $table->integer('set_id');
    }

    /**
     * Deactivates the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public function deactivate(Blueprint $table)
    {
        //
    }

    /**
     * Deletes the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public function delete(Blueprint $table)
    {
        $table->dropIfExists();
    }
}
