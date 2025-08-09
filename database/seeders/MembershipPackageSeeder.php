<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MembershipPackage;

class MembershipPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MembershipPackage::create([
            'name' => 'Member Reguler 1 Bulan',
            'price' => 150000,
            'duration_days' => 30,
            'description' => 'Akses penuh ke semua fasilitas gym selama 1 bulan.',
            'type' => 'regular',
        ]);

        MembershipPackage::create([
            'name' => 'Member Reguler 3 Bulan',
            'price' => 400000,
            'duration_days' => 90,
            'description' => 'Akses penuh ke semua fasilitas gym selama 3 bulan.',
            'type' => 'regular',
        ]);

        MembershipPackage::create([
            'name' => 'Member Mahasiswa 1 Bulan',
            'price' => 100000,
            'duration_days' => 30,
            'description' => 'Akses penuh ke semua fasilitas gym selama 1 bulan untuk mahasiswa.',
            'type' => 'student',
        ]);

        MembershipPackage::create([
            'name' => 'Member Mahasiswa 3 Bulan',
            'price' => 250000,
            'duration_days' => 90,
            'description' => 'Akses penuh ke semua fasilitas gym selama 3 bulan untuk mahasiswa.',
            'type' => 'student',
        ]);
    }
}
