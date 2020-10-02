<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\ClienteEndereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteEnderecoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClienteEndereco::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory()->create()->id,
            'rua' => $this->faker->name,
            'numero' => rand(1,100),
            'bairro' => $this->faker->citySuffix,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'cep' => substr(str_replace('-', '', $this->faker->postcode), 0, 8)
        ];
    }
}
