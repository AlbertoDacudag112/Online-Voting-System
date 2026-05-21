<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Election;
use App\Models\Position;
use App\Models\Candidate;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ──
        User::firstOrCreate(['email' => 'admin@example.com'], [
            'first_name' => 'Admin',
            'middle_name' => null,
            'last_name'  => 'User',
            'name'       => 'Admin User',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password123'),
            'role'       => 'admin',
            'is_active'  => true,
        ]);

        // ── ELECTIONS ──
        $elections = [
            [
                'title'       => 'IT Student Council Election 2026',
                'description' => 'Annual student council election for the IT department.',
                'start_date'  => now()->subDays(1),
                'end_date'    => now()->addDays(7),
                'status'      => 'active',
                'course'      => 'IT',
            ],
            [
                'title'       => 'Computer Science Council Election 2026',
                'description' => 'Student council election for CS students.',
                'start_date'  => now()->addDays(3),
                'end_date'    => now()->addDays(10),
                'status'      => 'upcoming',
                'course'      => 'CS',
            ],
            [
                'title'       => 'Nursing Student Council Election 2026',
                'description' => 'Election for nursing department student council.',
                'start_date'  => now()->subDays(5),
                'end_date'    => now()->addDays(2),
                'status'      => 'active',
                'course'      => 'Nursing',
            ],
            [
                'title'       => 'Business Administration Council Election 2026',
                'description' => 'Student council election for Business Administration.',
                'start_date'  => now()->subDays(10),
                'end_date'    => now()->subDays(3),
                'status'      => 'closed',
                'course'      => 'Business',
            ],
            [
                'title'       => 'University-Wide Supreme Student Council 2026',
                'description' => 'Open to all students across all departments.',
                'start_date'  => now()->subDays(2),
                'end_date'    => now()->addDays(5),
                'status'      => 'active',
                'course'      => null,
            ],
        ];

        $positionTitles = ['President', 'Vice President', 'Secretary', 'Treasurer', 'Auditor', 'P.R.O.'];

        $firstNames = [
            'James', 'Maria', 'John', 'Anna', 'Carlos', 'Sofia', 'Miguel', 'Clara',
            'Luis', 'Elena', 'Marco', 'Diana', 'Rafael', 'Isabel', 'Kevin', 'Hannah',
            'Ryan', 'Patricia', 'Daniel', 'Camille', 'Joshua', 'Andrea', 'Nathan', 'Beatrice',
            'Adrian', 'Theresa', 'Dominic', 'Melissa', 'Francis', 'Lorraine',
        ];

        $middleNames = ['A.', 'B.', 'C.', 'D.', 'E.', 'F.', 'G.', 'H.', 'M.', 'R.', 'S.', 'T.'];

        $lastNames = [
            'Santos', 'Reyes', 'Cruz', 'Garcia', 'Mendoza', 'Torres', 'Flores', 'Rivera',
            'Gomez', 'Diaz', 'Morales', 'Ramirez', 'Lopez', 'Hernandez', 'Aquino',
            'Bautista', 'Castillo', 'Dela Cruz', 'Fernandez', 'Gonzales',
        ];

        $parties = [
            'Unity Party', 'Progressive Alliance', 'Student First', 'New Horizon',
            'Excellence Party', 'Independent', 'Rise Movement', 'Synergy Coalition',
        ];

        $voterFirstNames = [
            'Alex', 'Jamie', 'Jordan', 'Taylor', 'Morgan', 'Casey', 'Riley', 'Drew',
            'Blake', 'Cameron', 'Avery', 'Quinn', 'Peyton', 'Reese', 'Skyler',
            'Bryce', 'Kendall', 'Hayden', 'Logan', 'Parker', 'Emery', 'Finley',
            'Rowan', 'Sage', 'Charlie', 'Dakota', 'Elliot', 'Frankie', 'Gray', 'Harper',
            'Indigo', 'Jules', 'Kit', 'Lane', 'Marlowe', 'Nova', 'Oakley', 'Piper',
            'River', 'Scout', 'Shiloh', 'Sterling', 'Sunny', 'Tatum', 'True', 'Vesper',
            'Wren', 'Zephyr', 'Arlo', 'Beau',
        ];

        $courses     = array_keys(User::COURSES);
        $yearLevels  = array_keys(User::YEAR_LEVELS);
        $voterCount  = 0;

        foreach ($elections as $electionData) {
            $created_by = User::where('role', 'admin')->first()->id;
            $election = Election::create(array_merge($electionData, ['created_by' => $created_by]));

            // Create positions for this election
            foreach ($positionTitles as $order => $title) {
                $position = Position::create([
                    'election_id'   => $election->id,
                    'title'         => $title,
                    'max_votes'     => 1,
                    'display_order' => $order + 1,
                ]);

                // 2-3 candidates per position
                $numCandidates = rand(2, 3);
                for ($c = 0; $c < $numCandidates; $c++) {
                    $firstName  = $firstNames[array_rand($firstNames)];
                    $middleName = $middleNames[array_rand($middleNames)];
                    $lastName   = $lastNames[array_rand($lastNames)];

                    Candidate::create([
                        'election_id' => $election->id,
                        'position_id' => $position->id,
                        'name'        => "$firstName $middleName $lastName",
                        'course'      => $electionData['course'],
                        'party'       => $parties[array_rand($parties)],
                        'bio'         => "Dedicated student leader running for $title.",
                        'photo'       => null,
                    ]);
                }
            }
        }

        // ── VOTERS (50 accounts spread across courses & year levels) ──
        $usedEmails = [];
        for ($i = 0; $i < 50; $i++) {
            $course     = $courses[$i % count($courses)];
            $yearLevel  = $yearLevels[$i % count($yearLevels)];
            $firstName  = $voterFirstNames[$i % count($voterFirstNames)];
            $lastName   = $lastNames[$i % count($lastNames)];
            $middleName = $middleNames[$i % count($middleNames)];
            $fullName   = "$firstName $middleName $lastName";
            $email      = strtolower($firstName) . ($i + 1) . '@student.edu';

            if (in_array($email, $usedEmails)) continue;
            $usedEmails[] = $email;

            User::create([
                'first_name'  => $firstName,
                'middle_name' => $middleName,
                'last_name'   => $lastName,
                'name'        => $fullName,
                'email'       => $email,
                'password'    => Hash::make('123123123'),
                'role'        => 'voter',
                'course'      => $course,
                'year_level'  => $yearLevel,
                'is_active'   => true,
            ]);
        }

        echo "✅ Seeded: 5 elections, 30 positions, ~90 candidates, 50 voters.\n";
    }
}