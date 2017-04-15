<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')
                ->references('id')->on('actions')
                ->onDelete('cascade');
            $table->integer('asset_id')->unsigned();
            $table->foreign('asset_id')
                ->references('id')->on('assets')
                ->onDelete('cascade');
            $table->enum('action_type', ['assign', 'return']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_actions');
    }
}
