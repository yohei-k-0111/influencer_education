<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryTime;
use App\Models\Curriculum;


class DeliveryTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $curriculums = Curriculum::factory()->count(10)->create();
        DeliveryTime::factory()->count(20)->recycle($curriculums)->create();

    }
}
