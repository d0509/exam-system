<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'add-question',
            'edit-question',
            'delete-question',
            'view-question',
            'add-user',
            'edit-user',
            'delete-user',
            'view-user',
            'add-role',
            'edit-role',
            'delete-role',
            'add-permission',
            'edit-permission',
            'delete-permission',
        ];

        foreach ($permissions as $permission) {
            Permission::updateorCreate(['name' => $permission],[
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
