<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array("Hoạt động","Ngừng hoạt động");
        for ($i = 0; $i < 10; $i++) {
            $shop = new Shop();
            $shop->name = "Shop $i";
            $shop->phone = "0123456" . rand(0, 9) . $i;
            $shop->email = "shop$i@gmail.com";
            $shop->address = "Shop $i address";
            $shop->master = "Master $i";
            $shop->status = $array[rand(0, 1)];
            $shop->save();
        }
    }
}
