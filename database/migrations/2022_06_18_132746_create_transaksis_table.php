<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('adress')->nullable();
            $table->string('phone')->nullable();
            
            $table->string('courier')->nullable();

            $table->string('payment')->default('MIDTRANS');
            $table->string('payment_url')->nullable();

            $table->bigInteger('total_price')->default(0);
            $table->string('status')->default('PENDING');
            
            $table->softDeletes();
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
        Schema::dropIfExists('transaksis');
    }
}
