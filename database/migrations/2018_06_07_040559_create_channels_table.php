<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->timestamps();
        });

        Schema::table('threads', function (Blueprint $table) {
            $channel = create('App\Models\Channel', ['name' => 'Other', 'slug' => 'Other']);
            $table->unsignedInteger('channel_id')->nullable()->default($channel->id);
            $table->foreign('channel_id')->references('id')->on('channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropForeign('threads_channel_id_foreign');
        });
        
        Schema::dropIfExists('channels');
    }
}
