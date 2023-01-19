<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_recurrences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->references('id')->on('expenses');
            $table->float('value');
            $table->string('barcode_slip', 50)->nullable();
            $table->date('expiration');
            $table->boolean('paid')->default(0);
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
        Schema::dropIfExists('expense_recurrences');
    }
};
