<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('id_fb');
            $table->unsignedBigInteger('category_id');
            $table->decimal('sell')->default(0);
            $table->unsignedBigInteger('id_user_buy')->nullable();
            $table->string('name_user');
            $table->string('data');
            $table->date('date');
            $table->integer('date_sell');
            $table->tinyInteger('status')->default(1)
                ->comment('1 => active, 2 => inactive');
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
        Schema::dropIfExists('products');
    }
}
