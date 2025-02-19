<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->integer('total');
            $table->integer('nominal_uang');
            $table->integer('kembalian');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
