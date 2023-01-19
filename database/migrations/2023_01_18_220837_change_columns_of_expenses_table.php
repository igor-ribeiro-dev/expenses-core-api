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
        Schema::table('expenses', function(Blueprint $table) {
            $table->dropColumn('value');
            $table->dropColumn('barcode_slip');
            $table->dropColumn('expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function(Blueprint $table) {
            $table->float('value')->after('description');
            $table->string('barcode_slip', 50)
                ->after('value')
                ->nullable();
            $table->date('expiration')
                ->after('barcode_slip')
                ->nullable();
        });
    }
};
