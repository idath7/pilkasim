<?php

namespace App\Imports;

use App\Models\Voter;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class VoterImport implements ToModel
{
    public function model(array $row)
    {
        // Skip header row or empty names
        if ($row[1] == 'Nama' || empty($row[1])) {
            return null;
        }

        return new Voter([
            'nis'         => $row[0] ?? null,
            'name'        => $row[1],
            'class_name'  => $row[2] ?? '-',
            'gender'      => strtoupper($row[3] ?? 'L'),
            'access_code' => strtoupper(\Illuminate\Support\Str::random(6)),
            'has_voted'   => false,
        ]);
    }
}
