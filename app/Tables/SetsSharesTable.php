<?php

namespace Socializr\Tables;

use Illuminate\Database\Schema\Blueprint;

class SetsSharesTable
{
    /**
     * Activates the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public function activate(Blueprint $table)
    {
        $table->increments('id');

        $table->integer('set_id');
        $table->integer('share_id');
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
