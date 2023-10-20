<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'id' => 1,
            'email' => 'admin@admin.com.br',
        ], [
            'nome' => 'Administrador',
            'password' => Hash::make('12345678'),
        ]);

    }
}
