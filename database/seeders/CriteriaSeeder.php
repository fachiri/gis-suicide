<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            (object) [
                'criteria' => 'Laki-laki',
                'type' => 'gender',
                'code' => 'A1',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Perempuan',
                'type' => 'gender',
                'code' => 'A2',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Wirausaha',
                'type' => 'occupation',
                'code' => 'B1',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Wiraswasta',
                'type' => 'occupation',
                'code' => 'B2',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Pelajar',
                'type' => 'occupation',
                'code' => 'B3',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Buruh',
                'type' => 'occupation',
                'code' => 'B5',
                'value' => 5
            ],
            (object) [
                'criteria' => 'ASN',
                'type' => 'occupation',
                'code' => 'B4',
                'value' => 3
            ],
            (object) [
                'criteria' => 'Trauma',
                'type' => 'motive',
                'code' => 'C1',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Stress',
                'type' => 'motive',
                'code' => 'C2',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Asmara',
                'type' => 'motive',
                'code' => 'C3',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Usia Non Produktif',
                'type' => 'age_class',
                'code' => 'D3',
                'value' => 3
            ],
            (object) [
                'criteria' => 'Usia Muda',
                'type' => 'age_class',
                'code' => 'D1',
                'value' => 5
            ],
            (object) [
                'criteria' => 'Usia Produktif',
                'type' => 'age_class',
                'code' => 'D2',
                'value' => 5
            ],
            (object) [
                'criteria' => 'SD',
                'type' => 'education',
                'code' => 'E1',
                'value' => 4
            ],
            (object) [
                'criteria' => 'SMP',
                'type' => 'education',
                'code' => 'E2',
                'value' => 4
            ],
            (object) [
                'criteria' => 'SMA',
                'type' => 'education',
                'code' => 'E3',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Tidak Sekolah',
                'type' => 'education',
                'code' => 'E4',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Tidak Diketahui',
                'type' => 'education',
                'code' => 'E5',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Menikah',
                'type' => 'marital_status',
                'code' => 'F1',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Belum Menikah',
                'type' => 'marital_status',
                'code' => 'F2',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Tidak Diketahui',
                'type' => 'marital_status',
                'code' => 'F3',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Ekonomi Kelas Menengah',
                'type'=> 'economic_status',
                'code' => 'G2',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Ekonomi Kelas Bawah',
                'type'=> 'economic_status',
                'code' => 'G3',
                'value' => 4
            ],
            (object) [
                'criteria' => 'Ekonomi Kelas Atas',
                'type'=> 'economic_status',
                'code' => 'G1',
                'value' => 3
            ],
        ];

        foreach ($items as $item) {
            Criteria::create([
                'type' => $item->type,
                'name' => $item->criteria,
                'code' => $item->code,
                'value' => $item->value
            ]);
        }
    }
}
