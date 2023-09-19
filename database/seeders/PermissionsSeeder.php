<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //dump('permissions and roles assigning to super admin');

        // all system permissions
        foreach (PermissionEnum::cases() as $permission) {
            Permission::query()->create(['name' => $permission, 'guard' => 'api']);
        }

        // all system roles
        foreach (RoleEnum::cases() as $role) {
            Role::query()->create(['name' => $role, 'guard' => 'api']);
        }

        $this->assignRoleToAdmin();
    }

    /**
     * @return void
     */
    private function assignRoleToAdmin(): void
    {
        // primary role and permission
        $role_super_admin = Role::query()->where('name', RoleEnum::admin->value)->first();

        // assign primary permission to role
        $role_super_admin->syncPermissions(PermissionEnum::super_admin->value);

        // find admin
        $super_admin = User::query()->first();
        // if user not found then create
        if (is_null($super_admin)) {
            $super_admin = User::query()->create([
                'name' => 'admin',
                'password' => bcrypt('admin'),
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
            ]);
        } else {
            $super_admin->update([
                'email_verified_at' => now(),
            ]);
        }

        Auth::loginUsingId($super_admin->id);

        // assign primary role and permission to super admin
        $super_admin->syncRoles(RoleEnum::admin->value);
        $super_admin->syncPermissions(PermissionEnum::super_admin->value);
    }
}
