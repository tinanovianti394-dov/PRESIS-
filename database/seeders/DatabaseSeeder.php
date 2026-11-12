<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database khusus sampel penelitian kelas XI TKJ 1.
     * Meliputi:
     * - 1 Akun Admin (Administrator PRESIS)
     * - 15 Guru Pengampu Unik kelas XI TJKT 1 (dari file jadwal)
     * - 35 Siswa kelas XI TKJ 1 (dari file siswa_XI_TKJ_1.xlsx)
     */
    public function run(): void
    {
        // ============================================================
        // 1. Akun Admin (login pakai email)
        // ============================================================
        User::updateOrCreate(
            ['email' => 'admin@smkn3bengkalis.sch.id'],
            [
                'name' => 'Administrator PRESIS',
                'nip' => null,
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // ============================================================
        // 2. Data 15 Guru Pengampu Unik (Jadwal Pelajaran XI TJKT 1)
        // Login menggunakan NIP (18-digit) atau Email
        // Password default: password123
        // ============================================================
        $guruPengampu = [
            [
                'kode'  => 2,
                'name'  => 'AHMAD DAROINI, S.Ag',
                'nip'   => '198501012010011002',
                'email' => 'ahmad.daroini@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 4,
                'name'  => 'YOSI AFRIANI, ST',
                'nip'   => '198501012010011004',
                'email' => 'yosi.afriani@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 7,
                'name'  => 'OSMELI, S.Kom',
                'nip'   => '198501012010011007',
                'email' => 'osmeli@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 10,
                'name'  => 'WIRAHYUNI, S.Pd.I',
                'nip'   => '198501012010011010',
                'email' => 'wirahyuni@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 11,
                'name'  => 'M JULIANDA ALHAFIS, S.Pd',
                'nip'   => '198501012010011011',
                'email' => 'm.julianda@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 15,
                'name'  => 'AMRI AKBAR, S.Kom',
                'nip'   => '198501012010011015',
                'email' => 'amri.akbar@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 16,
                'name'  => 'DIAN NOZA, S.Pd',
                'nip'   => '198501012010011016',
                'email' => 'dian.noza@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 17,
                'name'  => 'NOVIA AYU LESTARI, S.Pd',
                'nip'   => '198501012010011017',
                'email' => 'novia.ayu@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 19,
                'name'  => 'RUSTANTO, S.Kom',
                'nip'   => '198501012010011019',
                'email' => 'rustanto@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 20,
                'name'  => 'KHAIRIYAH, S.Pd',
                'nip'   => '198501012010011020',
                'email' => 'khairiyah@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 22,
                'name'  => 'SASVIANA MURSAHA NOSA, S.Pd',
                'nip'   => '198501012010011022',
                'email' => 'sasviana.mursaha@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 24,
                'name'  => 'MUSLIMIN, SHI',
                'nip'   => '198501012010011024',
                'email' => 'muslimin@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 26,
                'name'  => 'RAHMATINA AULIA, S.Pd',
                'nip'   => '198501012010011026',
                'email' => 'rahmatina.aulia@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 28,
                'name'  => 'AIDIL FEBRYANTO, S.Kom',
                'nip'   => '198501012010011028',
                'email' => 'aidil.febryanto@smkn3bengkalis.sch.id',
            ],
            [
                'kode'  => 29,
                'name'  => 'SOBIRIN, SH',
                'nip'   => '198501012010011029',
                'email' => 'sobirin@smkn3bengkalis.sch.id',
            ],
        ];

        foreach ($guruPengampu as $guru) {
            User::updateOrCreate(
                ['nip' => $guru['nip']],
                [
                    'name'     => $guru['name'],
                    'email'    => $guru['email'],
                    'password' => Hash::make('password123'),
                    'role'     => 'guru',
                ]
            );
        }

        // ============================================================
        // 3. Data 35 Siswa Sampel Kelas XI TKJ 1 (siswa_XI_TKJ_1.xlsx)
        // Login menggunakan NISN (10-digit)
        // Nomor HP orangtua dummy berurutan: 081234567801 s/d 081234567835
        // Password default: siswa123
        // ============================================================
        $siswaXITKJ1 = [
            ['no' => 1, 'nisn' => '0109401780', 'nama' => 'AHMAD REZKY', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567801'],
            ['no' => 2, 'nisn' => '0109766525', 'nama' => 'AINUL WAFA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567802'],
            ['no' => 3, 'nisn' => '0104092062', 'nama' => 'ALDIANA MARSA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567803'],
            ['no' => 4, 'nisn' => '0108594993', 'nama' => 'ANGGY RARAWANDANIA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567804'],
            ['no' => 5, 'nisn' => '0093109768', 'nama' => 'ARINI OKTAVIANI', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567805'],
            ['no' => 6, 'nisn' => '0104100578', 'nama' => 'AZALI ZUHRI HAFIDZAH', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567806'],
            ['no' => 7, 'nisn' => '0093880996', 'nama' => 'AZUMARDI AZRA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567807'],
            ['no' => 8, 'nisn' => '0105370031', 'nama' => 'BEBRY SYAH IRAWAN', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567808'],
            ['no' => 9, 'nisn' => '0105393670', 'nama' => 'DEFIN SYAHPUTRA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567809'],
            ['no' => 10, 'nisn' => '0098814248', 'nama' => 'DESTIKA SALSABILA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567810'],
            ['no' => 11, 'nisn' => '0099007724', 'nama' => 'Faza Iskandar', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567811'],
            ['no' => 12, 'nisn' => '0106240866', 'nama' => 'IKA SAFITRI', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567812'],
            ['no' => 13, 'nisn' => '0115605650', 'nama' => 'JUPITA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567813'],
            ['no' => 14, 'nisn' => '0105529627', 'nama' => 'KEVIN DWI FIZRIN', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567814'],
            ['no' => 15, 'nisn' => '0096914112', 'nama' => 'M. FAHRI SAPUTRA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567815'],
            ['no' => 16, 'nisn' => '0107195936', 'nama' => 'MANDA FRISKA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567816'],
            ['no' => 17, 'nisn' => '0108910177', 'nama' => 'MOHD RIDHO SYA BANI', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567817'],
            ['no' => 18, 'nisn' => '0106603904', 'nama' => 'MRafa Al Syaputra', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567818'],
            ['no' => 19, 'nisn' => '0099763644', 'nama' => 'Muhamad Nuqman Faris', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567819'],
            ['no' => 20, 'nisn' => '0106600726', 'nama' => 'MUHAMMAD ARRIZKY', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567820'],
            ['no' => 21, 'nisn' => '0101003467', 'nama' => 'MUTIA KURATUL AIN', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567821'],
            ['no' => 22, 'nisn' => '0106170507', 'nama' => 'NAFIS KHAIRUL MUAFA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567822'],
            ['no' => 23, 'nisn' => '0097276559', 'nama' => 'NOR HAIKAL', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567823'],
            ['no' => 24, 'nisn' => '0106817935', 'nama' => 'NURUL ATIQAH', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567824'],
            ['no' => 25, 'nisn' => '0106073096', 'nama' => 'NURWAHIDAH OKTAVIA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567825'],
            ['no' => 26, 'nisn' => '0105835826', 'nama' => 'QANIA ZULFA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567826'],
            ['no' => 27, 'nisn' => '0109948428', 'nama' => 'Rika Ramadani', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567827'],
            ['no' => 28, 'nisn' => '0093656953', 'nama' => 'Salsabila Azzahra', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567828'],
            ['no' => 29, 'nisn' => '0103482677', 'nama' => 'Sandra Aulia Putri', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567829'],
            ['no' => 30, 'nisn' => '0096359004', 'nama' => 'SORAYA NOVA ERIZA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567830'],
            ['no' => 31, 'nisn' => '0102260300', 'nama' => 'SURYANI', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567831'],
            ['no' => 32, 'nisn' => '0106517042', 'nama' => 'SYAFIQ PRATAMA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567832'],
            ['no' => 33, 'nisn' => '0104192054', 'nama' => 'TUTI SUDARSI', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567833'],
            ['no' => 34, 'nisn' => '0102709662', 'nama' => 'YULI YANDA PUTRI', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567834'],
            ['no' => 35, 'nisn' => '0109424695', 'nama' => 'ZULCHIE RIZKY PRATAMA', 'kelas' => 'XI TKJ 1', 'no_hp' => '081234567835'],
        ];

        foreach ($siswaXITKJ1 as $item) {
            Siswa::updateOrCreate(
                ['nisn' => $item['nisn']],
                [
                    'nama'           => $item['nama'],
                    'kelas'          => $item['kelas'],
                    'no_hp_orangtua' => $item['no_hp'],
                    'password'       => Hash::make('siswa123'),
                ]
            );
        }
    }
}
