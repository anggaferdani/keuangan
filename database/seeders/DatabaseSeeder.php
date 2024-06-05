<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Status;
use App\Models\Category;
use App\Models\Karyawan;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'Administrator',
            'User',
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }

        $permissions = [
            'dashboard',
            'role-index',
            'role-create',
            'role-show',
            'role-edit',
            'role-delete',
            'permission-index',
            'permission-create',
            'permission-show',
            'permission-edit',
            'permission-delete',
            'karyawan-index',
            'karyawan-create',
            'karyawan-show',
            'karyawan-edit',
            'karyawan-delete',
            'project-index',
            'project-create',
            'project-show',
            'project-edit',
            'project-delete',
            'price-submit-index',
            'price-submit-create',
            'price-submit-show',
            'price-submit-edit',
            'price-submit-delete',
            'price-developer-index',
            'price-developer-create',
            'price-developer-show',
            'price-developer-edit',
            'price-developer-delete',
            'gaji-index',
            'gaji-create',
            'gaji-show',
            'gaji-edit',
            'gaji-delete',
            'thr-index',
            'thr-create',
            'thr-show',
            'thr-edit',
            'thr-delete',
            'kasbon-index',
            'kasbon-create',
            'kasbon-show',
            'kasbon-edit',
            'kasbon-delete',
            'reimburse-index',
            'reimburse-create',
            'reimburse-show',
            'reimburse-edit',
            'reimburse-delete',
            'paid-project-index',
            'paid-project-create',
            'paid-project-show',
            'paid-project-edit',
            'paid-project-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        $superadmin = Role::where('id', 1)->first();
        $permissionsToAttach = Permission::whereNotIn('name', [])->get();
        $superadmin->permissions()->attach($permissionsToAttach);

        User::create([
            'name' => 'Angga Wahyu Ferdani',
            'email' => 'eanggawahyu@gmail.com',
            'password' => bcrypt(12345678),
            'role_id' => 1,
        ]);
        
        Karyawan::create([
            'user_id' => 1,
            'nip' => '12345678',
            'nominal_gaji' => '4000000',
            'nominal_tunjangan_hari_raya' => '500000',
        ]);

        $statuses = [
            ['Submit Proposal', 2],
            ['Follow Up', 2],
            ['Running', 1],
            ['Done', 1],
            ['Cencel', 2],
            ['Pending', 2],
        ];

        foreach ($statuses as $status) {
            Status::create([
                'name' => $status[0],
                'status' => $status[1],
            ]);
        }

        $categories = [
            ['package', 'Package'],
            ['person', 'Person'],
            ['year', 'Year'],
            ['month', 'Month'],
        ];

        foreach ($categories as $status) {
            Category::create([
                'name' => $status[0],
                'text' => $status[1],
            ]);
        }
    }
}
