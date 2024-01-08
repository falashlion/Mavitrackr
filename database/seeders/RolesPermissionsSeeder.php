<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use HasUuids;
    public function run(): void
    {
        // To reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        $permissions = [
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'user list',
            'user create',
            'user edit',
            'user delete',
            'kpis list',
            'kpis create',
            'kpis edit',
            'kpis delete',
            'kpas delete',
            'kpas list',
            'kpas create',
            'kpas edit',
            'feedback list',
            'feedback create',
            'feedback edit',
            'feedback delete',
            'kpisweight list',
            'kpisweight create',
            'kpisweight edit',
            'kpisweight delete',
            'kpisScore list',
            'kpisScore create',
            'kpisScore edit',
            'kpisScore delete',
            'departments list',
            'departments create',
            'departments edit',
            'departments delete',
            'direct reports list'
        ];
        foreach ($permissions as $permission){
        Permission::create(['name'=>$permission]);
        }
        // create roles and assign created permission
    $role1 = Role::create(['name'=>'Superadmin']);
    $role1->givePermissionTo($permission);
    $role2 = Role::create(['name'=>'Admin']);
    $role2->givePermissionTo('user list');
    $role2->givePermissionTo('user create');
    $role2->givePermissionTo('user edit');
    $role2->givePermissionTo('user delete');
    $role2->givePermissionTo('feedback list');
    $role2->givePermissionTo('feedback create');
    $role2->givePermissionTo('feedback delete');
    $role2->givePermissionTo('feedback edit');
    $role2->givePermissionTo('kpas edit');
    $role2->givePermissionTo('kpas list');
    $role2->givePermissionTo('kpas delete');
    $role2->givePermissionTo('kpas create');
    $role2->givePermissionTo('departments edit');
    $role2->givePermissionTo('departments list');
    $role2->givePermissionTo('departments delete');
    $role2->givePermissionTo('departments create');
    $role2->givePermissionTo('role list');
    $role2->givePermissionTo('permission list');
    $role3 = Role::create(['name'=>'Manager']);
    $role3->givePermissionTo('kpisweight list');
    $role3->givePermissionTo('kpisweight create');
    $role3->givePermissionTo('kpisweight edit');
    $role3->givePermissionTo('kpisweight delete');
    $role3->givePermissionTo('kpisScore list');
    $role3->givePermissionTo('kpisScore create');
    $role3->givePermissionTo('kpisScore edit');
    $role3->givePermissionTo('kpisScore delete');
    $role3->givePermissionTo('direct reports list');
    $role4 = Role::create(['name'=>'Employee']);
    $role4->givePermissionTo('kpis list');
    $role4->givePermissionTo('kpis create');
    $role4->givePermissionTo('kpis edit');
    $role4->givePermissionTo('kpis delete');
    $role4->givePermissionTo('kpas list');

    // create super admin user
    $superAdmin = User::create([
        'user_matricule'=>'Admin123',
        'password'=>'Admin123',
        'first_name' => 'Super',
        'last_name' => 'Admin',
        'phone' => '1234567890',
        'email' => 'superadmin@example.com',
        'email_verified_at' => now(),
        'departments_id' => null,
        'positions_id' => null,
    ]);
    $superAdmin->assignRole($role1,$role2,$role3,$role4);
}
}
