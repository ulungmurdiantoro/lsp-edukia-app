<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lspedukia.com'],
            [
                'name'     => 'Admin LSP Edukia',
                'email'    => 'admin@lspedukia.com',
                'password' => Hash::make('Admin@LSP2024!'),
            ]
        );

        $this->command->info('Admin user siap:');
        $this->command->info('  Email   : admin@lspedukia.com');
        $this->command->info('  Password: Admin@LSP2024!');
        $this->command->warn('  Segera ganti password setelah login!');
    }
}
