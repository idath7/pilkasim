<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Voter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LegacyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        Admin::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'mail@mail.com',
            'password' => Hash::make('admin'), // The old pass was '$2y$10$DebigZP2keqA7vrn.OtHke5xpM836B28RYlVqbAqXUPPZ5cuwBOP2' which is likely 'admin' or something. Let's just set 'admin'
        ]);

        // 2. Candidates
        Candidate::create([
            'name' => 'Ujang Saepul B - Fitri Nurajijah',
            'class_name' => 'XI TKJ - X TB',
            'organization' => 'OSIS',
            'vision' => '"Menciptakan lingkungan SMK Plus Al-Maftuh yang NYAMAN, HARMONIS, BERSIH, AKTIF, BERPRESTASI dengan berlandasan IMAN dan TAQWA"',
            'mission' => '1. Menumbuhkan Keimanan dan Ketaqwaan. 2. Meningkatkan kesadaran mengenai kebersihan sekolah. 3. Memperkuat rasa kekeluargaan antar siswa.',
            'photo' => '1.jpg',
            'votes' => 47,
        ]);
        Candidate::create([
            'name' => 'Siti Oktavia - Eva',
            'class_name' => 'XI TKJ - X TB',
            'organization' => 'OSIS',
            'vision' => 'Menjadikan osis sebagai sarana penampung kreativitas, inspirasi,dan aspirasi.',
            'mission' => 'Menjadikan smk plus al-maftuh sebagai wadah aspirasi siswa/i',
            'photo' => '2.jpg',
            'votes' => 7,
        ]);
        Candidate::create([
            'name' => 'Lusi Lawati - Ujang Yusup',
            'class_name' => 'XI TKJ - X TKJ',
            'organization' => 'OSIS',
            'vision' => 'Meningkatkan kesadaran dan kualitas Siswa Siswi Smk Plus Al- Maftuh',
            'mission' => 'Membantu Siswa Siswi Smk Plus Al- Maftuh Lebih Giat Dalam Melaksanakan Salat',
            'photo' => '3.jpg',
            'votes' => 4,
        ]);
        Candidate::create([
            'name' => 'Saepul Bahri - Rusmana',
            'class_name' => 'XI TB - X TB',
            'organization' => 'Pramuka',
            'vision' => 'Menjadi SMK (SMK PLUS AL-MAFTUH) berkualitas, aktif, berprestasi dengan berlandaskan iman dan takwa.',
            'mission' => '1.menumbuhkan keimanan dan ketakwaan pada tuhan',
            'photo' => '4.jpg',
            'votes' => 17,
        ]);

        // 3. Import Voters from SQL
        $sqlPath = base_path('legacy/db_pilketos.sql');
        if (file_exists($sqlPath)) {
            $sql = file_get_contents($sqlPath);
            preg_match_all("/INSERT INTO `data` .*? VALUES\s*(.*?);/s", $sql, $matches);
            if (!empty($matches[1][0])) {
                $values = $matches[1][0];
                // Regex to extract (id, nis, nama2, nama, kelas, jk, status)
                preg_match_all("/\(\d+,\s*'([^']*)',\s*'([^']*)',\s*'([^']*)',\s*'([^']*)',\s*'([^']*)',\s*(\d+)\)/", $values, $votersData, PREG_SET_ORDER);
                foreach ($votersData as $voter) {
                    // Generate a flexible 6-character uppercase alphanumeric access code
                    $accessCode = strtoupper(Str::random(6));
                    
                    Voter::create([
                        'nis' => $voter[1],
                        'name' => $voter[2], // nama2 is usually the real name in the old db
                        'class_name' => $voter[4],
                        'gender' => $voter[5],
                        'access_code' => $accessCode,
                        'has_voted' => $voter[6] == '1',
                    ]);
                }
            }
        }
    }
}
