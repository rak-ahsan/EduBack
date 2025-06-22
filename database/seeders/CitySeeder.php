<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('cities')->insert([
            
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Dhaka', 'zip' => 1200],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Faridpur', 'zip' => 7800],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Gazipur', 'zip' => 1700],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Gopalganj', 'zip' => 8100],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Kishoreganj', 'zip' => 2300],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Madaripur', 'zip' => 7900],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Manikganj', 'zip' => 1800],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Munshiganj', 'zip' => 1500],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Narayanganj', 'zip' => 1400],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Narsingdi', 'zip' => 1600],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Rajbari', 'zip' => 7700],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Shariatpur', 'zip' => 8000],
            ['country_id' => 1, 'state_id' => 1, 'name' => 'Tangail', 'zip' => 1900],

            ['country_id' => 1, 'state_id' => 2, 'name' => 'Chattogram', 'zip' => 4000],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Cox\'s Bazar', 'zip' => 4700],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Cumilla', 'zip' => 3500],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Feni', 'zip' => 3900],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Brahmanbaria', 'zip' => 3400],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Khagrachhari', 'zip' => 4400],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Lakshmipur', 'zip' => 3700],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Noakhali', 'zip' => 3800],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Rangamati', 'zip' => 4500],
            ['country_id' => 1, 'state_id' => 2, 'name' => 'Bandarban', 'zip' => 4600],

            ['country_id' => 1, 'state_id' => 3, 'name' => 'Rajshahi', 'zip' => 6000],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Bogra', 'zip' => 5800],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Joypurhat', 'zip' => 5900],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Naogaon', 'zip' => 6500],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Natore', 'zip' => 6400],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Chapainawabganj', 'zip' => 6300],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Pabna', 'zip' => 6600],
            ['country_id' => 1, 'state_id' => 3, 'name' => 'Sirajganj', 'zip' => 6700],

            ['country_id' => 1, 'state_id' => 4, 'name' => 'Khulna', 'zip' => 9000],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Bagerhat', 'zip' => 9300],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Chuadanga', 'zip' => 7200],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Jashore', 'zip' => 7400],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Jhenaidah', 'zip' => 7500],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Kushtia', 'zip' => 7000],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Magura', 'zip' => 7600],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Meherpur', 'zip' => 7100],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Narail', 'zip' => 7501],
            ['country_id' => 1, 'state_id' => 4, 'name' => 'Satkhira', 'zip' => 9400],

            ['country_id' => 1, 'state_id' => 5, 'name' => 'Barishal', 'zip' => 8200],
            ['country_id' => 1, 'state_id' => 5, 'name' => 'Bhola', 'zip' => 8300],
            ['country_id' => 1, 'state_id' => 5, 'name' => 'Jhalokati', 'zip' => 8400],
            ['country_id' => 1, 'state_id' => 5, 'name' => 'Patuakhali', 'zip' => 8600],
            ['country_id' => 1, 'state_id' => 5, 'name' => 'Pirojpur', 'zip' => 8500],
            ['country_id' => 1, 'state_id' => 5, 'name' => 'Barguna', 'zip' => 8700],

            ['country_id' => 1, 'state_id' => 6, 'name' => 'Sylhet', 'zip' => 3100],
            ['country_id' => 1, 'state_id' => 6, 'name' => 'Habiganj', 'zip' => 3300],
            ['country_id' => 1, 'state_id' => 6, 'name' => 'Moulvibazar', 'zip' => 3200],
            ['country_id' => 1, 'state_id' => 6, 'name' => 'Sunamganj', 'zip' => 3000],

            ['country_id' => 1, 'state_id' => 7, 'name' => 'Rangpur', 'zip' => 5400],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Dinajpur', 'zip' => 5200],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Gaibandha', 'zip' => 5700],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Kurigram', 'zip' => 5600],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Lalmonirhat', 'zip' => 5500],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Nilphamari', 'zip' => 5300],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Panchagarh', 'zip' => 5000],
            ['country_id' => 1, 'state_id' => 7, 'name' => 'Thakurgaon', 'zip' => 5100],

            ['country_id' => 1, 'state_id' => 8, 'name' => 'Mymensingh', 'zip' => 2200],
            ['country_id' => 1, 'state_id' => 8, 'name' => 'Netrokona', 'zip' => 2400],
            ['country_id' => 1, 'state_id' => 8, 'name' => 'Sherpur', 'zip' => 2100],
            ['country_id' => 1, 'state_id' => 8, 'name' => 'Jamalpur', 'zip' => 2000],


        ]);
    }
}
