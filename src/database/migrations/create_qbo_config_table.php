<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQboConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qbo_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('auth_code');
            $table->text('realm_id');
            $table->text('access_token');
            $table->text('refresh_token');
            $table->dateTime('x_refresh_token_expires_in');
            $table->dateTime('expires_in');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qbo_config');
    }
}