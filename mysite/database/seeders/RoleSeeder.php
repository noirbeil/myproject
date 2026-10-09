<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Очищаем кэш разрешений
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Создаем роли
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Создаем разрешения для студий
        Permission::create(['name' => 'view studios']);
        Permission::create(['name' => 'create studios']);
        Permission::create(['name' => 'edit studios']);
        Permission::create(['name' => 'delete studios']);

        // Даем админу все разрешения
        $adminRole->givePermissionTo(Permission::all());

        // Создаем тестового пользователя админа если его нет
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Администратор',
                'password' => bcrypt('password'),
            ]
        );

        // Назначаем роль admin
        $adminUser->assignRole('admin');
    }
}