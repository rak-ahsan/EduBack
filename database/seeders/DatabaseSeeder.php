<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Intake;
use App\Models\Role;
use App\Models\AppliedVia;

class DatabaseSeeder extends Seeder
{
    // private $permissions = [
    //     'User',
    //     'Role',
    //     'Location',
    //     'Academic',
    //     'University',
    //     'AdvanceFilter',
    //     'ToDoList',
    //     'Lead',
    //     'Status',
    //     'Report',
    //     'bulkUpload',
    //     'singleUpload',

    //     'Superadmin',
    //     'Admin',
    //     'Authority',
    //     'Data',
    //     'Finance',
    //     'Marketing',
    //     'BranchManager',
    //     'JuniorConsultant',
    //     'SeniorConsultant',
    //     'AgentManager',
    //     'Agent',
    //     'ApplicationManager',
    //     'Admission',
    //     'Compliance',

    //     'Password',
    // ];

    private $roles = [
        'Superadmin',
        'Admin',
        'Authority',
        'Data',
        'Finance',
        'Marketing',
        'BranchManager',
        'JuniorConsultant',
        'SeniorConsultant',
        'AgentManager',
        'Agent',
        'ApplicationManager',
        'Admission',
        'Compliance',
    ];


    private $appliedvias = [
        "Direct",
        "SI-UK",
        "KC",
        "SAMS",
        "Kaplan",
        "Wrexham Portal",
        "Edvoy",
        "Adventus",
        "ATMC",
        "GSP",
        "QUEENS GROUP",
        "Applyboard",
        "Study Group",
        "TCL",
        "USW",
        "UAP",
        "Infinite",
    ];

    private $intakes = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];


    public function run(): void
    {
        foreach ($this->intakes as $intake) {
            Intake::create(['name' => $intake]);
        };
        foreach ($this->roles as $role) {
            Role::create(['name' => $role]);
        };
        foreach ($this->appliedvias as $appliedvia) {
            AppliedVia::create(['name' => $appliedvia]);
        };

        $this->call([
            UserSeeder::class,
            ProgramSeeder::class,
            LanguageSeeder::class,
            LeadSeeder::class,
            TodoListSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            BranchSeeder::class,
            AgentAssignSeeder::class,
            BranchAssignSeeder::class,
            ConsultantAssignSeeder::class,
            RightSeeder::class,
            StatusGroupSeeder::class,
            StatusNameSeeder::class,
            UniversitySeeder::class,
        ]);
    }
}
