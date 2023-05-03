<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventSportif>
 */
class EventSportifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $width=640;
        $height=800;
        //$path=$this->faker->image('storage/images',$width,$height,'sport',true,true,'sport',false);
        $path=$this->faker->image('storage/app/public/images',$width,$height,'sport',true,true,'sport',false);
        return [
            'nom' => $this->faker->sentence(),
            'description' => $this->faker->words(2,true),
            'lieu'=> $this->faker->state(),
            'poster' =>$path,// $this->faker->imageUrl(360, 360, true),
            'posterURL'=>config('app.url').'/storage/'.Str::after($path, 'public/'),
            'dateDebut' => $this->faker->date(),
            'dateFin' => $this->faker->date(),
        ];
    }
}
