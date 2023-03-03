<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJsonDatasTable extends Migration
{
    public function up()
    {
        Schema::create('json_datas', function (Blueprint $table) {
            $table->id();

            $table->string('path');
            $table->json('content');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('json_datas');
    }
}
