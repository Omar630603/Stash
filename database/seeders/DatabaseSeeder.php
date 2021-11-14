<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Category;
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
            ['name' => 'Omar Al-Maktary', 'email' => 'omar@stash.com', 'username'=> 'OmarBranch', 'password'=> Hash::make('123456789'), 'phone' => '+620821345679', 'address' => 'Malang'],
            ['name' => 'Alif Ananda', 'email' => 'Alif@stash.com', 'username'=> 'AlifBranch', 'password'=> Hash::make('123456789'), 'phone' => '+620895647238', 'address' => 'Jakarta'],
        ];
        User::insert($users);
        $branches = [
            ['ID_User' => 1, 'branch_name' => 'Malang Main', 'city'=> 'Malang', 'branch_address'=> 'Malang, Suhat'],
            ['ID_User' => 2, 'branch_name' => 'Jakarta Main', 'city'=> 'Jakarta', 'branch_address'=> 'Jakarta'],
        ];
        Branch::insert($branches);
        $categories = [
            ['category_name' => 'Small', 'category_description' => 'Small Storage Units', 'dimensions'=> '3 X 3 M', 'pricePerDay'=> '1000'],
            ['category_name' => 'Medium', 'category_description' => 'Medium Storage Units', 'dimensions'=> '6 X 6 M', 'pricePerDay'=> '2000'],
            ['category_name' => 'Large', 'category_description' => 'Large Storage Units', 'dimensions'=> '9 X 9 M', 'pricePerDay'=> '3000'],
        ];
        Category::insert($categories);
        $banks = [
            ['ID_Branch' => 1, 'bank_name' => 'BCA', 'accountNo'=> '09582142301'],
            ['ID_Branch' => 1, 'bank_name' => 'BNI', 'accountNo'=> '08221485655'],
            ['ID_Branch' => 2, 'bank_name' => 'BCA', 'accountNo'=> '09512554125'],
            ['ID_Branch' => 2, 'bank_name' => 'BNI', 'accountNo'=> '08565856655'],
        ];
        Bank::insert($banks);
    }
}
