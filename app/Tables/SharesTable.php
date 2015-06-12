<?php

namespace Socializr\Tables;

use Illuminate\Database\Schema\Blueprint;

class SharesTable
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
        $table->string('slug');
        $table->string('url');

        $table->boolean('default_set');
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
