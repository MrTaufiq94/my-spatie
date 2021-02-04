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
