<?php

namespace Database\Seeders;

use App\Models\Campaign;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class CamoaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campaign::updateOrCreate([
            'name' => 'Damac akoya',
            'description' => 'Damac akoya'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Damac hills',
            'description' => 'Damac hills'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Dubai hills',
            'description' => 'Dubai hills'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Larosa',
            'description' => 'Larosa'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Damac creek',
            'description' => 'Damac creek'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Sobha',
            'description' => 'Sobha'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Beachfront',
            'description' => 'Beachfront'
        ]);
        Campaign::updateOrCreate([
            'name' => 'Riviera',
            'description' => 'Riviera'
        ]);
    }
}
