<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('like.likes_table', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(config('like.user_foreign_key'))->index()->comment('user_id');
            $table->morphs('likeable'); // This will create likeable_id and
            $table->timestamps();
        });
    }
};
