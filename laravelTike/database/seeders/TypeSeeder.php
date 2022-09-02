<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type1=Type::create([
            'name' => "mountain"
        ]);

        $type2=Type::create([
            'name' => "lifting"
        ]);

        $type3=Type::create([
            'name' => "race"
        ]);

        $type4=Type::create([
            'name' => "casual"
        ]);

        $type5=Type::create([
            'name' => "sports"
        ]);
    }
}
