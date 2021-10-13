<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipns', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('event_id')->nullable();
            $table->string('paypal_id')->nullable();
            $table->decimal('amount', 12,2)->nullable();
            $table->decimal('amount_fee', 12,2)->nullable();
            $table->string('event_type')->nullable();
            $table->string('summary')->nullable();
            $table->string('log')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('ipns');
    }
}
