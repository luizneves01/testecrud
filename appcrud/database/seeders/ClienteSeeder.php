<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Cliente;
use App\Models\ClienteEndereco;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        ClienteEndereco::factory()->times(50)->create();
    }
}
