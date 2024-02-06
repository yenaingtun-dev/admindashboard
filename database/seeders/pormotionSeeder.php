<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class pormotionSeeder extends Seeder
{
    public function run()
    {
        $pormotionSeeder = [
            [
                'title' => 'pormotion_access',
            ],
            [
                'title' => 'pormotion_create',
            ],
            [
                'title' => 'pormotion_edit',
            ],
            [
                'title' => 'pormotion_show',
            ],
            [
                'title' => 'pormotion_delete',
            ],
        ];
        Permission::insert($pormotionSeeder);
    }
}
