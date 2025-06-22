<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\University;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            [
                'country_id' => 1,
                'uni_name' => 'Harvard University',
                'application_fees' => 75,
                'ranking' => 1,
                'initial_deposit' => 5000,
                'usp' => 'Top Ivy League institution',
                'uni_academic_req' => 'GPA 3.8+, TOEFL 100+',
                'uni_link' => 'https://www.harvard.edu',
                'scholarship' => 'Yes',
                'image' => 'harvard.png',
                'status' => 'active',
            ],
            [
                'country_id' => 1,
                'uni_name' => 'University of Oxford',
                'application_fees' => 100,
                'ranking' => 2,
                'initial_deposit' => 4000,
                'usp' => 'Oldest English-speaking university',
                'uni_academic_req' => 'A*AA, IELTS 7.0+',
                'uni_link' => 'https://www.ox.ac.uk',
                'scholarship' => 'Yes',
                'image' => 'oxford.png',
                'status' => 'active',
            ],
            [
                'country_id' => 1,
                'uni_name' => 'University of Toronto',
                'application_fees' => 90,
                'ranking' => 18,
                'initial_deposit' => 3000,
                'usp' => 'Top Canadian university',
                'uni_academic_req' => 'GPA 3.6+, IELTS 6.5+',
                'uni_link' => 'https://www.utoronto.ca',
                'scholarship' => 'Limited',
                'image' => 'toronto.png',
                'status' => 'active',
            ],
            [
                'country_id' => 1,
                'uni_name' => 'University of Melbourne',
                'application_fees' => 100,
                'ranking' => 33,
                'initial_deposit' => 3500,
                'usp' => 'Strong research focus',
                'uni_academic_req' => 'ATAR 90+, IELTS 6.5+',
                'uni_link' => 'https://www.unimelb.edu.au',
                'scholarship' => 'Yes',
                'image' => 'melbourne.png',
                'status' => 'active',
            ],
            [
                'country_id' => 1,
                'uni_name' => 'National University of Singapore',
                'application_fees' => 50,
                'ranking' => 8,
                'initial_deposit' => 4000,
                'usp' => 'Top Asian university',
                'uni_academic_req' => 'GPA 3.5+, TOEFL 92+',
                'uni_link' => 'https://www.nus.edu.sg',
                'scholarship' => 'Yes',
                'image' => 'nus.png',
                'status' => 'active',
            ],
        ];

        foreach ($universities as $uni) {
            University::create($uni);
        }
    }
}
