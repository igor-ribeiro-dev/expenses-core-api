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
        Schema::create('billing_providers_configs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->references('id')
                ->on('users');

            $table->foreignId('billing_provider_id')
                ->references('id')
                ->on('expense_recurrences');

            $table->json('config');

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
        Schema::dropIfExists('billing_providers_configs');
    }
};
