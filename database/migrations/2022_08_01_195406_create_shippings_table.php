<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("order_id");
            $table->string("firstname");
            $table->string("lastname");
            $table->string("mobile");
            $table->string("email");
            $table->string("line1");
            $table->string("line2")->nullable();
            $table->string("city");
            $table->string("province");
            $table->string("country");
            $table->string("zipcode");
            $table->foreign("order_id")->references("id")->on("orders")->onDelete("cascade");
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
        Schema::dropIfExists('shippings');
    }
}
