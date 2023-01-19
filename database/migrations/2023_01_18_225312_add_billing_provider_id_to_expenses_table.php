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
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('billing_provider_id')
                ->after('budget_id')
                ->nullable()
                ->references('id')
                ->on('billing_providers');
            $table->json('params_value')
                ->nullable()
                ->after('billing_provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['billing_provider_id']);
            $table->dropColumn('billing_provider_id');
            $table->dropColumn('params_value');
        });
    }
};
