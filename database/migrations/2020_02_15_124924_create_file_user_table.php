<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_user', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('seen');
            $table->boolean('rejected');
            $table->boolean('replied');
            $table->timestamps();

            $table->primary(['file_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_user');
    }
}
