<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbltodolist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbltodolist', function (Blueprint $table) {
            $table->id('cid');
            $table->string('taskname');
            $table->integer('assignto')->length(2);
            $table->integer('taskstatus')->length(2);
            $table->datetime('createddatetime');
            $table->integer('statusflag')->length(2);
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
        Schema::dropIfExists('tbltodolist');
    }
}
