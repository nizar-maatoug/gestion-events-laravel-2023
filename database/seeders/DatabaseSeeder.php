<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Athlete;
use App\Models\Categorie;
use App\Models\Equipe;
use App\Models\EventSportif;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(2)
            ->has(EventSportif::factory()
                ->count(3)
                ->has(Categorie::factory()
                    ->count(3)
                    ->state(new Sequence(
                        ['nom' => 'Minim'],
                        ['nom' => 'Cadet'],
                        ['nom' => 'Senior'],
                    ))
                    ->state(new Sequence(
                        ['genre' => 'HOMME'],
                        ['genre' => 'FEMME'],
                    ))
                    ->state(new Sequence(
                        ['poids' => '-40 KG'],
                        ['poids' => '-50 KG'],
                        ['poids' => '+50 KG'],
                    ))
                    ->has(Athlete::factory()
                        ->count(2)
                        ->state(function (array $attributes, Categorie $categorie) {
                            return ['genre' => $categorie->genre];
                        })
                        ->for(
                            Equipe::factory()
                        )
                        ->hasCommentaires(2)

                    )

                )
                ->hasCommentaires(2)

            )
            ->create();
    }
}
