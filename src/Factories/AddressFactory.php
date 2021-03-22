<?php


namespace Boleto\Factories;

use Boleto\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'street' => $this->faker->name,
            'complement' => $this->faker->word,
            'number' => $this->faker->numberBetween(1,1000),
            'neighborhood' => $this->faker->word,
            'cep' => $this->faker->numerify('########'),
            'city' => $this->faker->name,
            'UF' => $this->faker->countryCode
        ];
    }
}
