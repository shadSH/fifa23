<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $getRole = Role::where('name', 'Super Admin')->first();
        if (! $getRole) {
            $getRole = Role::create([
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ]);
        }
        $getAdmin = Admin::where('email', 'admin@demo.com')->first();
        if (! $getAdmin) {
            $insertAdmin = Admin::create([
                'name' => fake()->name(),
                'email' => 'admin@demo.com',
                'role_id' => $getRole->id,
                'password' => Hash::make('12345678'), // password
            ]);
            $insertAdmin->assignRole($getRole->id);
        }

        //         \App\Models\Admin::factory(1)->create();

        // \App\Models\Admin::factory()->create([
        //     'name' => 'Test Admin',
        //     'email' => 'test@example.com',
        // ]);
    }
}
