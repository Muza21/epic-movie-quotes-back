<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Genre::factory(10)->create();
        \App\Models\Genre::create(
            [
            'name' => [
                'en' => 'Adventure',
                'ka' => 'სათავგადასავლო'
            ]
        ],
        );
        \App\Models\Genre::create([
                'name' => [
                    'en' => 'Drama',
                    'ka' => 'დრამა'
                ]
            ]);
        \App\Models\Genre::create([
            'name' => [
                'en' => 'Documentary',
                'ka' => 'დოკუმენტური'
            ]
        ]);
        \App\Models\Genre::create([
            'name' => [
                'en' => 'Comedy',
                'ka' => 'კომედია'
            ]
        ]);
        \App\Models\Genre::create([
            'name' => [
                'en' => 'History',
                'ka' => 'ისტორიული'
            ]
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
