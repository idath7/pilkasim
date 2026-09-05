<?php

namespace App\Imports;

use App\Models\Voter;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VoterImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $type;

    public function __construct($type = 'student')
    {
        $this->type = $type;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function model(array $row): Model|array|null
    {
        // Skip header row or empty names
        if ($row[1] === 'Nama Lengkap' || $row[1] === 'Nama' || empty($row[1])) {
            return null;
        }

        $username = isset($row[4]) && trim($row[4]) !== '' ? trim($row[4]) : null;
        $rawPassword = isset($row[5]) && trim($row[5]) !== '' ? trim($row[5]) : null;
        $password = $rawPassword ? \Illuminate\Support\Facades\Hash::make($rawPassword, ['rounds' => 4]) : null;

        $accessCode = isset($row[6]) && trim($row[6]) !== '' ? strtoupper(trim($row[6])) : strtoupper(\Illuminate\Support\Str::random(8));

        return new Voter([
            'type'           => $this->type,
            'nis'            => $row[0] ?? null,
            'name'           => $row[1],
            'class_name'     => $row[2] ?? '-',
            'gender'         => strtoupper($row[3] ?? 'L'),
            'access_code'    => $accessCode,
            'username'       => $username,
            'password'       => $password,
            'plain_password' => $rawPassword,
            'has_voted'      => false,
        ]);
    }
}
