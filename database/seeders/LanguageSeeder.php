<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    private $languages = [
        "IELTS UKVI"           => "International English Language Testing System UKVI",
        "IELTS Academic"       => "International English Language Testing System Academic",
        "PTE"                  => "Pearson Test of English",
        "TOEFL"                => "Test of English as a Foreign Language",
        "Duolingo"             => "Duolingo English Test",
        "OXFORD ELLT"          => "Oxford English Language Testing",
        "IELTS"                => "International English Language Testing System",
        "DELE"                 => "Diplomas of Spanish as a Foreign Language",
        "DALF"                 => "Diploma in Advanced French",
        "JLPT"                 => "Japanese Language Proficiency Test",
        "Goethe-Zertifikat"    => "Goethe-Zertifikat (German Language Certification)"
    ];
    public function run(): void
    {
        foreach ($this->languages as $short => $full) {
            Language::updateOrCreate(
                ['short_name' => $short],
                ['full_name' => $full]
            );
        }
    }
}
