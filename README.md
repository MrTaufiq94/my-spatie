
> # Training Spatie : taufiqfarid
_________________
## -- Create New Project --
### Langkah 1
- Cipta projek baharu dengan nama ***my-spatie***.

        composer create-project --prefer-dist laravel/laravel my-spatie

### Langkah 2
- Di *phpmyadmin* cipta satu *database* dengan nama ***db_myspatie***.

### Langkah 3
- Membuat *configuration connection* dengan database yang telah dibuat.
- Di bahagian file ***.env*** cari kode berikut. 

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=laravel
        DB_USERNAME=root
        DB_PASSWORD=

- *edit* code berikut seperti berikut:

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=db_myspatie
        DB_USERNAME=root
        DB_PASSWORD=

-----------------
## -- Cara Install Spatie --
### Langkah 1
- Di dalam *project terminal* jalankan kod perintah berikut.

        composer require spatie/laravel-permission
### Langkah 2
- *Publish Configuration* dengan kod perintah berikut.

        php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

- Apabila kita jalankan perintah di atas kita kan mendapat file-file berikut.

    1. config/permissions.php
    2. database/migrations/2020_07_16_033645_create_permission_tables.php

### Langkah 3
- Tambah *Traits*  ***HasRoles*** di model *User* seperti berikut.

        <?php

        namespace App\Models;

        use Spatie\Permission\Traits\HasRoles;
        use Illuminate\Notifications\Notifiable;
        use Illuminate\Contracts\Auth\MustVerifyEmail;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Foundation\Auth\User as Authenticatable;

        class User extends Authenticatable
        {
            use HasFactory, Notifiable, HasRoles;

            /**
            * The attributes that are mass assignable.
            *
            * @var array
            */
            protected $fillable = [
                'name',
                'email',
                'password',
            ];

            /**
            * The attributes that should be hidden for arrays.
            *
            * @var array
            */
            protected $hidden = [
                'password',
                'remember_token',
            ];

            /**
            * The attributes that should be cast to native types.
            *
            * @var array
            */
            protected $casts = [
                'email_verified_at' => 'datetime',
            ];
        }

- Diatas kita *import traits* dari laravel spatie.

        use Spatie\Permission\Traits\HasRoles;
                    
- Dan ubah menggunakan *traits* tersebut di *Model Class User*, seperti berikut.

        use HasFactory, Notifiable, HasRoles;

### Langkah 4
- Tambahkan ***Middleware Role & Permission*** di file ***app/Http/Kernel.php*** kemudian masukkan kode berikut di dalam ***$routeMiddleware***.

        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,

- Secara jelasnya kod kita akan jadi seperti berikut.

        protected $routeMiddleware = [
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
        ];

-----------------
## -- Membuat Data Seeder untuk Roles & Permissions & Users --
### Langkah 1
- jalankan perintah di bawah untuk membuat data *seeder* untuk ***roles***.

        php artisan make:seed RolesTableSeeder

- Di dalam ***database/seeders/RolesTableSeeder.php*** kemudian ubah kod seperti berikut.

        <?php

        namespace Database\Seeders;

        use Illuminate\Database\Seeder;
        use Spatie\Permission\Models\Role;

        class RolesTableSeeder extends Seeder
        {
            /**
            * Run the database seeds.
            *
            * @return void
            */
            public function run()
            {
                $role = Role::create([
                        'name' => 'admin'
                ]);

                $role1 = Role::create([
                        'name' => 'manager'
                ]);
            }
        }

- Diatas kita *import* data model ***Role*** untuk digunakan dari *package laravel spatie*.

        use Spatie\Permission\Models\Role;

- Kemudian, kita buat data *role* baru dengan nama ***admin*** dan ***manager*** ke dalam *database*.

        
        $role = Role::create([
            'name' => 'admin'
        ]);

        $role1 = Role::create([
            'name' => 'manager'
        ]);


### Langkah 2
- jalankan perintah di bawah untuk membuat data *seeder* untuk ***permissions***.
            
            php artisan make:seed PermissionsTableSeeder

- Di dalam ***database/seeders/PermissionsTableSeeder.php*** kemudian ubah kod seperti berikut.

        <?php

        namespace Database\Seeders;

        use Illuminate\Database\Seeder;
        use Spatie\Permission\Models\Permission;

        class PermissionsTableSeeder extends Seeder
        {
            /**
            * Run the database seeds.
            *
            * @return void
            */
            public function run()
            {
                //permission for posts
                Permission::create(['name' => 'posts.index']);
                Permission::create(['name' => 'posts.create']);
                Permission::create(['name' => 'posts.edit']);
                Permission::create(['name' => 'posts.delete']);
            }
        }

- Diatas kita *import* data model ***Permission*** untuk digunakan dari *package laravel spatie*.

        use Spatie\Permission\Models\Permission;

- Selepas itu, kita menambahkan permissions yang akan kita gunakan di dalam project nanti, seperti contoh untuk akses halaman ***index post, create post, edit post*** dan ***delete post***.

### Langkah 3
- jalankan perintah di bawah untuk membuat data *seeder* untuk ***users***.

        php artisan make:seed UserTableSeeder

- Di dalam ***database/seeders/UserTableSeeder.php*** kemudian ubah kod seperti berikut.

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

                //assign permission to role admin
                $role = Role::find(1);
                $permissions = Permission::all();

                $role->syncPermissions($permissions);

                //assign role admin with permission to user 1
                $user = User::find(1);
                $user->assignRole($role->name);
                
                // --------------------------------------------------------------------------------
                
                //assign permission to role manager
                $role = Role::find(2);
                $permissions = ['posts.index', 'posts.index'];

                $role->syncPermissions($permissions);

                //assign role manager with permission to user 2
                $user = User::find(2);
                $user->assignRole($role->name);
                }
        }

- Diatas kita mencipta dua(2) users dengan role ***admin dan manager*** masing permission yang berbeza.
-----------------------
## -- Register ke Database Seeder --
### Langkah 1
- Ok, kita akan *register* ***RolesTableSeeder*** dan ***PermissionTableSeeder*** yang sudah kita buat di atas ke dalam ***DatabaseSeeder***, supaya dapat menjalankan perintah seeder nanti.

- Di dalam ***database/seeders/DatabaseSeeder.php*** kemudian ubah kod pada ***function run*** seperti berikut.

        public function run()
        {
            $this->call(RolesTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
            $this->call(UserTableSeeder::class);
        }

- Jalankan perintah ini untuk *generate Composer autoloader*. Kerana jika perintah di bawah ini tidak di jalankan kadang-kadang *TableSeeder* kita tidak dibaca.

            composer dump-autoload

------------
## -- Membuat Authentication --
### Langkah 1
- Membuat *Authentication* di Laravel kita boleh menggunakan ***Laravel UI*** untuk melakukan *scaffolding*, yang mana nanti akan automatik di *generate* ***routes, views*** dan ***controller*** untuk *Authentication*. Jalankan perintah berikut.

        composer require laravel/ui:^3.0

- Setelah proses *installed* selesai kemudian jalankan perintah di bawah ini untuk melakukan scaffolding.

        php artisan ui bootstrap --auth

- Seterusnya jalankan perintah berikut.

        npm install
        npm run dev

- Jika perintah ini keluar ***'Finished. Please run Mix again.'*** semasa proses *install*. Jalankan sekali lagi perintah berikut.
         
        npm run dev

------------
## -- Menjalankan Migration & Seeder --
### Langkah 1
- Sekarang kita akan menjalankan ***migration*** untuk men-*generate* *table* yang sudah pernah kita buat sebelum ini dan sekaligus memasukkan data ke dalam *table* dengan *data seeder* yang sudah kita buat.

        php artisan migrate --seed

------------
## -- Memaparkan Output Bersarkan Permission --
### Langkah 1
- Di dalam folder ***resouces/views/home.blade.php*** dan silakan buka file tersebut dan ubah kodnya menjadi seperti berikut.

        @extends('layouts.app')

        @section('content')
        <div class="container">
                <div class="row justify-content-center">
                        <div class="col-md-8">
                                <div class="card">
                                        <div class="card-header">{{ __('Dashboard') }}</div>

                                        <div class="card-body">
                                        @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                                </div>
                                        @endif

                                        @can('posts.index')
                                                <h3>Post Index</h3>
                                                <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.index</b></span> sahaja</p>
                                        @endcan
                                        <hr>
                                        @can('posts.create')
                                                <h3>Post Create</h3>
                                                <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.create</b></span> sahaja</p>
                                        @endcan
                                        <hr>
                                        @can('posts.edit')
                                                <h3>Post Edit</h3>
                                                <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.edit</b></span> sahaja</p>
                                        @endcan
                                        <hr>
                                        @can('posts.delete')
                                                <h3>Post Delete</h3>
                                                <p>Isi ini hanya boleh di baca oleh user yang mempunyai permision <span><b>posts.delete</b></span> sahaja</p>
                                        @endcan


                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        @endsection

- Di atas kita membuat directive ***@can()*** dimana kita memaparkan ouput dari  permission ***posts.index, post.create*** dll.

        @can('posts.index')
               //something here
        @endcan

- Sekarang kita boleh mencuba jalankan *project* kita untuk melihat output berdasrkan permissions, silakan buka di http://localhost:8000/home.

- Anda boleh mencuba login dengan user yang berlainan untuk melihat hasilnya.
        1. email : admin@gmail.com dan pass : password
        2. email : computer@gmail.com dan pass : password

># Selamat Mencuba #AlwaySmile ;)

