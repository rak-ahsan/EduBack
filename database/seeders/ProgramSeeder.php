<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $programs = [
        // Primary and Secondary Education
        "PSC"  => "Primary School Certificate",
        "JSC"  => "Junior School Certificate",
        "SSC"  => "Secondary School Certificate",
        "HSC"  => "Higher Secondary Certificate",
        "O Level" => "Ordinary Level",
        "A Level" => "Advanced Level",
        "GED"  => "General Educational Development",
        "IB"   => "International Baccalaureate",
        "IGCSE"=> "International General Certificate of Secondary Education",
        
        // Vocational and Technical
        "Diploma" => "Diploma",
        "Cert"    => "Certificate",
        "HNC"     => "Higher National Certificate",
        "HND"     => "Higher National Diploma",
        "NVQ"     => "National Vocational Qualification",
        "BTEC"    => "Business and Technology Education Council",
        "Top-Up"  => "Top-Up Degree",

        // Undergraduate Degrees
        "BA"   => "Bachelor of Arts",
        "BSc"  => "Bachelor of Science",
        "BBA"  => "Bachelor of Business Administration",
        "BEng" => "Bachelor of Engineering",
        "LLB"  => "Bachelor of Laws",
        "BFA"  => "Bachelor of Fine Arts",
        "BEd"  => "Bachelor of Education",
        "BArch"=> "Bachelor of Architecture",
        "MBBS" => "Bachelor of Medicine, Bachelor of Surgery",
        "BDS"  => "Bachelor of Dental Surgery",
        "BPharm"=> "Bachelor of Pharmacy",
        "BSN"  => "Bachelor of Science in Nursing",
        "BCom" => "Bachelor of Commerce",
        "BTech"=> "Bachelor of Technology",
        "BMus" => "Bachelor of Music",
        "BCA"  => "Bachelor of Computer Applications",
        "BIS"  => "Bachelor of Information Systems",
        
        // Graduate/Postgraduate Degrees
        "MA"   => "Master of Arts",
        "MSc"  => "Master of Science",
        "MBA"  => "Master of Business Administration",
        "MEng" => "Master of Engineering",
        "MFA"  => "Master of Fine Arts",
        "LLM"  => "Master of Laws",
        "MEd"  => "Master of Education",
        "MArch"=> "Master of Architecture",
        "MPhil"=> "Master of Philosophy",
        "MPA"  => "Master of Public Administration",
        "MSN"  => "Master of Science in Nursing",
        "MCom" => "Master of Commerce",
        "MTech"=> "Master of Technology",
        "MCA"  => "Master of Computer Applications",
        
        // Doctoral Degrees
        "PhD"  => "Doctor of Philosophy",
        "DBA"  => "Doctor of Business Administration",
        "EdD"  => "Doctor of Education",
        "MD"   => "Doctor of Medicine",
        "JD"   => "Juris Doctor",
        "DPhil"=> "Doctor of Philosophy (UK)",
        "DSocSci"=> "Doctor of Social Science",
        "DSc"  => "Doctor of Science",
        "EngD" => "Doctor of Engineering",
        "PsyD" => "Doctor of Psychology",
        "DMus" => "Doctor of Music",
        
        // Professional Certifications
        "CA"   => "Chartered Accountant",
        "CPA"  => "Certified Public Accountant",
        "CFA"  => "Chartered Financial Analyst",
        "CISSP"=> "Certified Information Systems Security Professional",
        "PMP"  => "Project Management Professional",
        "CMA"  => "Certified Management Accountant",
        "CIMA" => "Chartered Institute of Management Accountants",
        "ACCA" => "Association of Chartered Certified Accountants",
        "CEng" => "Chartered Engineer",
        "CNA"  => "Certified Nursing Assistant",
        "AWS"  => "AWS Certifications",
        "MCSE" => "Microsoft Certified Systems Engineer",
        "CCNA" => "Cisco Certified Network Associate",
        
        // Specialized and Professional Courses
        "PGCE" => "Postgraduate Certificate in Education",
        "PGDip"=> "Postgraduate Diploma",
        "MRes" => "Master of Research",
        "GradDip"=> "Graduate Diploma",
        "Exec MBA"=> "Executive Master of Business Administration",
        
        // Trade and Skill-Based Certifications
        "WeldCert"=> "Welding Certification",
        "CulArts" => "Culinary Arts",
        "AutoEng" => "Automotive Engineering",
        "ConstrMgt"=> "Construction Management",
        "ElecCert"=> "Electrician Certification",
        "PlumbCert"=> "Plumbing Certification",
        "HVAC"   => "Heating, Ventilation, and Air Conditioning Technician",
    ];

    public function run(): void
    {
        foreach ($this->programs as $short => $full) {
            Program::updateOrCreate(
                ['short_name' => $short],
                ['full_name' => $full]
            );
        }
    }
}
