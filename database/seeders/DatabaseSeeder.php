<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Category;
use App\Models\DeliveryVehicle;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Omar Al-Maktary', 'email' => 'omar@stash.com', 'username' => 'OmarBranch', 'password' => Hash::make('123456789'), 'phone' => '+620821345679', 'address' => 'Malang'],
            ['name' => 'Alif Ananda', 'email' => 'Alif@stash.com', 'username' => 'AlifBranch', 'password' => Hash::make('123456789'), 'phone' => '+620895147238', 'address' => 'Jakarta'],
            ['name' => 'Bggio Deroger', 'email' => 'baggio@stash.com', 'username' => 'BaggioBranch', 'password' => Hash::make('123456789'), 'phone' => '+620895646547', 'address' => 'Surabaya'],
            ['name' => 'Rizki', 'email' => 'rizki@gmail.com', 'username' => 'RizkiDriver', 'password' => Hash::make('15987'), 'phone' => '+620836545679', 'address' => 'Malang'],
            ['name' => 'Radith', 'email' => 'radith@gmail.com', 'username' => 'RadithDriver', 'password' => Hash::make('75321'), 'phone' => '+620895647238', 'address' => 'Jakarta'],
            ['name' => 'Lelyta', 'email' => 'lelyta@gmail.com', 'username' => 'LelytaDriver', 'password' => Hash::make('78952'), 'phone' => '+620895648526', 'address' => 'Surabaya'],
            ['name' => 'Rivaldo', 'email' => 'rivaldo@gmail.com', 'username' => 'RivaldoUser', 'password' => Hash::make('123456789'), 'phone' => '+620837895679', 'address' => 'Malang'],
            ['name' => 'Reta', 'email' => 'reta@gmail.com', 'username' => 'RetaUser', 'password' => Hash::make('123456789'), 'phone' => '+620898747238', 'address' => 'Jakarta'],
            ['name' => 'Dapo', 'email' => 'dapo@gmail.com', 'username' => 'DapoUser', 'password' => Hash::make('123456789'), 'phone' => '+620825848526', 'address' => 'Surabaya'],
        ];
        User::insert($users);
        $branches = [
            ['ID_User' => 1, 'branch_name' => 'Malang Main', 'city' => 'Malang', 'branch_address' => 'Malang, St. Malang'],
            ['ID_User' => 2, 'branch_name' => 'Jakarta Main', 'city' => 'Jakarta', 'branch_address' => 'Jakarta, St. Jakarta'],
            ['ID_User' => 3, 'branch_name' => 'Surabaya Main', 'city' => 'Surabaya', 'branch_address' => 'Surabaya, St.Surabaya'],
        ];
        Branch::insert($branches);
        $drivers = [
            ['ID_Branch' => 1, 'ID_User' => 4, 'vehicle_name' => 'RizkiDriver', 'vehicle_phone' => '+620836545679', 'model' => 'Toyota', 'plateNumber' => '15987', 'pricePerK' => 2000],
            ['ID_Branch' => 2, 'ID_User' => 5, 'vehicle_name' => 'RadithDriver', 'vehicle_phone' => '+620895647238', 'model' => 'Honda', 'plateNumber' => '75321', 'pricePerK' => 2500],
            ['ID_Branch' => 3, 'ID_User' => 6, 'vehicle_name' => 'LelytaDriver', 'vehicle_phone' => '+620895648526', 'model' => 'Yamaha', 'plateNumber' => '78952', 'pricePerK' => 3000],
        ];
        DeliveryVehicle::insert($drivers);
        $categories = [
            ['category_name' => 'Small', 'category_description' => 'Small Storage Units', 'dimensions' => '3 X 3 M', 'pricePerDay' => '1000', 'category_img' => 'Category_images/smallCategoryDefulat.png'],
            ['category_name' => 'Medium', 'category_description' => 'Medium Storage Units', 'dimensions' => '6 X 6 M', 'pricePerDay' => '2000', 'category_img' => 'Category_images/mediumCategoryDefulat.png'],
            ['category_name' => 'Large', 'category_description' => 'Large Storage Units', 'dimensions' => '9 X 9 M', 'pricePerDay' => '3000', 'category_img' => 'Category_images/largeCategoryDefulat.png'],
        ];
        Category::insert($categories);
        $banks = [
            ['ID_Branch' => 1, 'bank_name' => 'BCA', 'accountNo' => '09582142301'],
            ['ID_Branch' => 1, 'bank_name' => 'BNI', 'accountNo' => '08221485655'],
            ['ID_Branch' => 2, 'bank_name' => 'BCA', 'accountNo' => '09512554125'],
            ['ID_Branch' => 2, 'bank_name' => 'BNI', 'accountNo' => '08565856655'],
            ['ID_Branch' => 3, 'bank_name' => 'BCA', 'accountNo' => '09512548587'],
            ['ID_Branch' => 3, 'bank_name' => 'BNI', 'accountNo' => '08565887579'],
        ];
        Bank::insert($banks);
    }
}
