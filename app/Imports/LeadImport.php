<?php
namespace App\Imports;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadImport implements OnEachRow, WithHeadingRow
{
    public $duplicates = [];

    public function onRow(Row $row)
    {
        $data = $row->toArray();
        $phone = $data['phone'];
        $existingLead = Lead::where('phone', $phone)->first();

        if ($existingLead) {
            $existingLead->update(['duplicate' => 'Yes']);
            $this->duplicates[] = $phone;
            return;
        }
        Lead::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $phone,
            'email'      => $data['email'],
            'duplicate'  => 'No',
            'resource'  => $data['resource'],
            'marketer_id'  => Auth::user()->id,
        ]);
    }
}
