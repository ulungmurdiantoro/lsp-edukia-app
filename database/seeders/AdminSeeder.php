<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Kredensial diambil dari .env (ADMIN_EMAIL / ADMIN_PASSWORD), bukan ditulis di kode —
        // repo ini bisa dibaca orang lain. Tanpa ADMIN_PASSWORD, dibuat password acak.
        $email = env('ADMIN_EMAIL', 'admin@lspedukia.com');
        $password = env('ADMIN_PASSWORD') ?: Str::password(20);

        $admin = User::firstOrNew(['email' => $email]);

        // Jangan timpa password admin yang sudah ada — seeder bisa dijalankan ulang kapan saja.
        if ($admin->exists) {
            $admin->forceFill(['is_admin' => true])->save();
            $this->command->info("Admin {$email} sudah ada — password tidak diubah.");

            return;
        }

        $admin->forceFill([
            'name' => 'Admin LSP Edukia',
            'password' => Hash::make($password),
            'is_admin' => true,
        ])->save();

        $this->command->info('Admin user dibuat:');
        $this->command->info("  Email   : {$email}");
        if (! env('ADMIN_PASSWORD')) {
            $this->command->info("  Password: {$password}");
            $this->command->warn('  Simpan password ini sekarang — tidak akan ditampilkan lagi.');
        }
    }
}
