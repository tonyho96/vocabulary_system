<?php

use App\User;
use Illuminate\Database\Seeder;

class GenerateDefaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        try {
            DB::beginTransaction();

            $defaultUser = User::where('name', '=', 'admin')->first();

            if ($defaultUser) {
                $defaultUser->delete();
            }

            $confirmation_code = str_random(30);
            $defaultUserData = [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'role' => config('user.role.admin'),
                'status' => 'verified'
            ];

            User::insert($defaultUserData);
            DB::commit();
            echo "Seeding user data has done.\n";
        }
        catch (\ Exception $e) {
            echo "Seeding Company data has fail.\n";
            DB::rollback();
            die($e->getMessage());
            return false;
        }
    }
}
