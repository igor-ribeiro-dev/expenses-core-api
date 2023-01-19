<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::table('billing_providers')
            ->insert([
                [
                    'description' => 'Turboline',
                    'tag' => 'turboline',
                    'params' => json_encode([
                        'user' => 'Usuário do para login em turboline',
                        'password' => 'Senha para login em turboline.',
                    ])
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::table('billing_providers')->truncate();
    }
};
