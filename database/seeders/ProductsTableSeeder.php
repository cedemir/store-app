<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('products')->insert([
        //     'name'       => 'Primeiro Produto',
        //     'description' => 'Produto teste com seeds',
        //     'body'     => 'Conteúdo do Produto',
        //     'in_stock'    => 34,
        //     'price'       => (14.99 * 100),
        //     'is_active'   => 1,
        //     'slug'        => 'primeira-produto'
        // ]);

        \App\Models\Product::factory(30)
            ->hasPhotos(5)
            ->create();
    }
}
