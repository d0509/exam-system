<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin =  Role::where('name', 'admin')->first();
        $permissions = Permission::all();
        $admin->syncPermissions($permissions);


        $teacher =  Role::where('name', 'teacher')->first();
        $teacherPermissions = $permissions->filter(function ($permission) {
            return str_contains($permission->name, 'question');
        });
        $teacher->syncPermissions($teacherPermissions);

        $student =  Role::where('name', 'student')->first();
        $studentPermissions = $permissions->filter(function ($permission) {
            return str_contains($permission->name, 'question');
        });
        $student->syncPermissions($studentPermissions);
    }
}
