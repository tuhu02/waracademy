<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TournamentIndividuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Generate unique kode_room
        do {
            $kode = Str::upper(Str::random(6));
        } while (DB::table('turnamen')->where('kode_room', $kode)->exists());

        // Insert turnamen individu
        $turnamenId = DB::table('turnamen')->insertGetId([
            'nama_turnamen' => 'Turnamen Matematika Individu',
            'kode_room' => $kode,
            'dibuat_oleh' => null, // Atau set ID pengguna jika ada
            'level_minimal' => 1,
            'status' => 'Menunggu',
            'mode' => 'solo',
            'max_team_members' => null,
            'durasi_pengerjaan' => 30, // 30 menit
            'max_peserta' => 50,
            'deskripsi' => 'Turnamen matematika untuk individu. Uji kemampuan matematika Anda dengan berbagai soal menarik!',
            'bonus_exp' => 500,
            'created_at' => $now,
            'updated_at' => $now,
        ], 'id_turnamen');

        // Soal-soal turnamen
        $questions = [
            [
                'teks_pertanyaan' => 'Berapakah hasil dari 15 + 27?',
                'poin_per_soal' => 10,
                'tingkat_kesulitan' => 'mudah',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '40', 'benar' => false],
                    ['teks' => '42', 'benar' => true],
                    ['teks' => '44', 'benar' => false],
                    ['teks' => '46', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Jika sebuah persegi panjang memiliki panjang 8 cm dan lebar 5 cm, berapakah luasnya?',
                'poin_per_soal' => 15,
                'tingkat_kesulitan' => 'mudah',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '35 cm²', 'benar' => false],
                    ['teks' => '40 cm²', 'benar' => true],
                    ['teks' => '45 cm²', 'benar' => false],
                    ['teks' => '50 cm²', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Berapakah hasil dari 7 × 8?',
                'poin_per_soal' => 10,
                'tingkat_kesulitan' => 'mudah',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '54', 'benar' => false],
                    ['teks' => '56', 'benar' => true],
                    ['teks' => '58', 'benar' => false],
                    ['teks' => '60', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Jika x + 5 = 12, berapakah nilai x?',
                'poin_per_soal' => 15,
                'tingkat_kesulitan' => 'sedang',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '5', 'benar' => false],
                    ['teks' => '6', 'benar' => false],
                    ['teks' => '7', 'benar' => true],
                    ['teks' => '8', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Berapakah hasil dari 144 ÷ 12?',
                'poin_per_soal' => 10,
                'tingkat_kesulitan' => 'mudah',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '10', 'benar' => false],
                    ['teks' => '11', 'benar' => false],
                    ['teks' => '12', 'benar' => true],
                    ['teks' => '13', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Sebuah segitiga memiliki alas 10 cm dan tinggi 6 cm. Berapakah luasnya?',
                'poin_per_soal' => 20,
                'tingkat_kesulitan' => 'sedang',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '28 cm²', 'benar' => false],
                    ['teks' => '30 cm²', 'benar' => true],
                    ['teks' => '32 cm²', 'benar' => false],
                    ['teks' => '36 cm²', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Berapakah hasil dari 3² + 4²?',
                'poin_per_soal' => 15,
                'tingkat_kesulitan' => 'sedang',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '20', 'benar' => false],
                    ['teks' => '24', 'benar' => false],
                    ['teks' => '25', 'benar' => true],
                    ['teks' => '27', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Jika sebuah lingkaran memiliki jari-jari 7 cm, berapakah kelilingnya? (gunakan π = 22/7)',
                'poin_per_soal' => 20,
                'tingkat_kesulitan' => 'sedang',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '42 cm', 'benar' => false],
                    ['teks' => '44 cm', 'benar' => true],
                    ['teks' => '46 cm', 'benar' => false],
                    ['teks' => '48 cm', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Berapakah hasil dari 25% dari 80?',
                'poin_per_soal' => 15,
                'tingkat_kesulitan' => 'sedang',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '18', 'benar' => false],
                    ['teks' => '20', 'benar' => true],
                    ['teks' => '22', 'benar' => false],
                    ['teks' => '24', 'benar' => false],
                ]
            ],
            [
                'teks_pertanyaan' => 'Jika 2x - 3 = 11, berapakah nilai x?',
                'poin_per_soal' => 20,
                'tingkat_kesulitan' => 'sulit',
                'mata_pelajaran' => 'Matematika',
                'options' => [
                    ['teks' => '5', 'benar' => false],
                    ['teks' => '6', 'benar' => false],
                    ['teks' => '7', 'benar' => true],
                    ['teks' => '8', 'benar' => false],
                ]
            ],
        ];

        // Insert soal dan pilihan jawaban
        foreach ($questions as $q) {
            $questionId = DB::table('turnamen_pertanyaan')->insertGetId([
                'id_turnamen' => $turnamenId,
                'teks_pertanyaan' => $q['teks_pertanyaan'],
                'poin_per_soal' => $q['poin_per_soal'],
                'waktu_pengerjaan' => 30,
                'tingkat_kesulitan' => $q['tingkat_kesulitan'],
                'mata_pelajaran' => $q['mata_pelajaran'],
                'created_at' => $now,
            ], 'id');

            // Insert pilihan jawaban
            foreach ($q['options'] as $opt) {
                DB::table('turnamen_pilihan_jawaban')->insert([
                    'id_pertanyaan_turnamen' => $questionId,
                    'teks_jawaban' => $opt['teks'],
                    'adalah_benar' => $opt['benar'] ? 1 : 0,
                ]);
            }
        }

        $this->command->info("Turnamen individu berhasil dibuat!");
        $this->command->info("Kode Room: {$kode}");
        $this->command->info("ID Turnamen: {$turnamenId}");
        $this->command->info("Jumlah Soal: " . count($questions));
    }
}

