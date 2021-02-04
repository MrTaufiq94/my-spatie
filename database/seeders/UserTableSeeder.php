<?php

    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;

    class UserTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
        *
        * @return void
        */
        public function run()
        {

            $data = [
                [
                    'name'      => 'Taufiq Farid',
                    'email'     => 'admin@gmail.com',
                    'password'  => bcrypt('password')
                ],
                [
                    'name'      => 'Computer',
                    'email'     => 'computer@gmail.com',
                    'password'  => bcrypt('password')
                ],  
            ];
    
            DB::table('users')->insert($data);

            //assign permission to role
            $role = Role::find(1);
            $permissions = Permission::all();

            $role->syncPermissions($permissions);

            //assign role with permission to user
            $user = User::find(1);
            $user->assignRole($role->name);

            // --------------------------------------------------------------------------------
            
            //assign permission to role
            $role2 = Role::find(2);
            $permissions2 = ['posts.index', 'posts.index'];

            $role2->syncPermissions($permissions2);

            //assign role with permission to user 2
            $user2 = User::find(2);
            $user2->assignRole($role2->name);
        }
  }
