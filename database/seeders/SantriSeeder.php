<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('santri')->truncate(); //Truncate / Kosongkan tabel

        // $lastId = DB::table('santri')->max('nis') ?? 0; // Ambil ID terbesar atau 0 jika kosong

        $faker = Faker::create('id_ID');

        foreach (range(1, 50) as $index) {
            DB::table('santri')->insert([
                'nis' => $faker->creditCardNumber,
                'nik' => $faker->creditCardNumber,
                'nama_lengkap' => $faker->name,
                'tempat_lahir' => $faker->city,
                'tgl_lahir' => $faker->date('Y-m-d'),
                'alamat' => $faker->address,
                'gender' => $faker->randomElement(['L', 'P']),
                'email' => $faker->email,
                'no_hp' => $faker->phoneNumber,
                'tgl_masuk' => $faker->date,
                // 'tgl_keluar' => rand(0, 1) ? $faker->date() : null, // 50% null, 50% isi tanggal
                'tgl_keluar' => rand(1, 10) > 3 ? $faker->date() : null, // 70% isi tanggal, 30% null
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
