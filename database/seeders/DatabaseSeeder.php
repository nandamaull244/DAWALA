<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $faker = Faker::create('id_ID');
        // Admin user
        DB::table('users')->insert([
            'nik' => $this->generateNIK(),
            'username' => 'admindawala',
            'password' => Hash::make('dawala2024'),
            'full_name' => 'DAWALA Admin',
            'birth_date' => $faker->date('Y-m-d'),
            'gender' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
            'no_kk' => $faker->numerify('################'),
            'email' => 'admin@example.com',
            'phone_number' => $faker->phoneNumber,
            'district_id' => $faker->randomDigitNotNull,
            'village_id' => $faker->randomDigitNotNull,
            'rt' => $faker->numerify('##'),
            'rw' => $faker->numerify('##'),
            'address' => $faker->address,
            'role' => 'admin',
            'registration_type' => 'Admin',
            'registration_status' => 'Completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Operator user
        DB::table('users')->insert([
            'nik' => $this->generateNIK(),
            'username' => 'operatordawala',
            'password' => Hash::make('dawala2024'),
            'full_name' => 'DAWALA Operator',
            'birth_date' => $faker->date('Y-m-d'),
            'gender' => $faker->randomElement(['Laki-Laki', 'Perempuan']),
            'no_kk' => $faker->numerify('################'),
            'email' => 'operator@example.com',
            'phone_number' => $faker->phoneNumber,
            'district_id' => $faker->randomDigitNotNull,
            'village_id' => $faker->randomDigitNotNull,
            'rt' => $faker->numerify('##'),
            'rw' => $faker->numerify('##'),
            'address' => $faker->address,
            'role' => 'operator',
            'registration_type' => 'Operator',
            'registration_status' => 'Completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function generateNIK()
    {
        $faker = Faker::create('id_ID');

        $yy = $faker->numberBetween(90, 99);
        $MMdd = $faker->date('md'); 
        $dd = $faker->numerify('##'); 
        $ss = $faker->numerify('##'); 
        $nnnnn = $faker->numerify('#####'); 

        return $yy . $MMdd . $dd . $ss . $nnnnn;
    }
}
