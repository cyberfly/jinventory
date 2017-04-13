<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset_name');
            $table->string('barcode_no')->unique()->nullable();
            $table->string('imei_no')->unique()->nullable();
            $table->string('serial_no')->unique()->nullable();
            $table->string('asset_description',150)->nullable();
            $table->integer('category_id')->nullable()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('brand_id')->nullable()->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->softDeletes();
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
        Schema::dropIfExists('assets');
    }
}
