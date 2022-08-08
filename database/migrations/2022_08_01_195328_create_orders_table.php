<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Decimal;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->decimal("subtotal");
            $table->decimal("discount");
            $table->decimal("tax");
            $table->decimal("total");
            $table->string("firstname");
            $table->string("lastname");
            $table->string("mobile");
            $table->string("email");
            $table->string("address");
            $table->string("city");
            $table->string("province");
            $table->string("country");
            $table->string("zipcode");
            $table->enum("status",["ordered","delivered","canceled"])->default("ordered");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('orders');
    }
}
