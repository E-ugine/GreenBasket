<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => "Red & Navy Checked Slim Formal Shirt",
                'description' => 'Red and navy checked formal shirt, has a button-down collar, a full button placket, long sleeves, a curved hemline.',
                'quantity' => 21,
                'price' => 200.10,
                'image' => 'https://assets.myntassets.com/h_1440,q_100,w_1080/v1/assets/images/1038959/2015/12/7/11449479796511-INVICTUS-Red--Navy-Checked-Slim-Formal-Shirt-4621449479796242-3.jpg',
                'created_at' => new DateTime,
                'updated_at' => null,
            ],
            [
                'name' => "Men Red Classic Slim Fit Solid Formal Shirt",
                'description' => 'Red solid formal shirt, has a slim collar, button placket, 1 pocket, long sleeves, curved hem',
                'quantity' => 400,
                'price' => 1600.21,
                'image' => 'https://assets.myntassets.com/h_1440,q_100,w_1080/v1/assets/images/3117516/2018/3/10/11520666535008-JAINISH-Men-Red-Classic-Slim-Fit-Solid-Formal-Shirt-2801520666534871-3.jpg',
                'created_at' => new DateTime,
                'updated_at' => null,
            ],
            [
                'name' => "White & Red Checked Slim Formal Shirt",
                'description' => 'White, red and blue checked formal shirt, has a contrast spread collar, a full button placket, long sleeves, a curved hemline',
                'quantity' => 37,
                'price' => 378.00,
                'image' => 'https://assets.myntassets.com/h_1440,q_100,w_1080/v1/assets/images/1038966/2015/12/8/11449575702385-INVICTUS-White--Red-Checked-Slim-Formal-Shirt-5221449575701961-1.jpg',
                'created_at' => new DateTime,
                'updated_at' => null,
            ],
        ];

        DB::table('products')->insert($products);
    }
}