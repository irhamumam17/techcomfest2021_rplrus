<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $administrator = new \App\User;
      $administrator->username = "admin";
      $administrator->name = "Admin";
      $administrator->email = "admin@email.com";
      $administrator->roles = json_encode(["ADMIN"]);
      $administrator->password = \Hash::make("123456");
      // $administrator->avatar = "saat-ini-tidak-ada-file.png";
      $administrator->address = "Jl. Admin";
      $administrator->phone = "085777777777";

      $administrator->save();

      $this->command->info("User Admin berhasil diinsert");
    }
}
