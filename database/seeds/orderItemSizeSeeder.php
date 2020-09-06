<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class orderItemSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 20; $i++) {
            $orderItemId = factory(App\order_item::class)->create()->id;
            $sizes = [
                ["size_name" => "S",
                 "qty" => rand(1,20),
                 "order_item_id" => $orderItemId,
                 "created_at" => date("Y-m-d H:i:s"),
                 "order_by" => 1
                ],
                ["size_name" => "M",
                    "qty" => rand(1,20),
                    "order_item_id" => $orderItemId,
                    "created_at" => date("Y-m-d H:i:s"),
                    "order_by" => 2
                ],
                ["size_name" => "L",
                    "qty" => rand(1,20),
                    "order_item_id" => $orderItemId,
                    "created_at" => date("Y-m-d H:i:s"),
                    "order_by" => 3
                ],
                ["size_name" => "XL",
                    "qty" => rand(1,20),
                    "order_item_id" => $orderItemId,
                    "created_at" => date("Y-m-d H:i:s"),
                    "order_by" => 4
                ]
            ];
            foreach ($sizes as $size) {
                DB::table('order_item_sizes')->insert($size);
            }
        }
    }
}
