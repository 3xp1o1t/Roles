<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permisos de Usuarios
        Permission::create([
            'name' => 'Navegar usuarios',
            'slug' => 'users.index',
            'description' => 'Lista y navega todos los usuarios'
        ]);
        Permission::create([
            'name' => 'Ver detalle de usuario',
            'slug' => 'users.show',
            'description' => 'Ver un usuario en especifico'
        ]);
        Permission::create([
            'name' => 'Editar usuario',
            'slug' => 'users.edit',
            'description' => 'Editar un usuario especifico'
        ]);
        Permission::create([
            'name' => 'Eliminar usuario',
            'slug' => 'users.destroy',
            'description' => 'Eliminar un usuario'
        ]);

        // Permisos de roles.
        Permission::create([
            'name' => 'Navegar roles',
            'slug' => 'roles.index',
            'description' => 'Lista y navega todos los roles'
        ]);
        Permission::create([
            'name' => 'Ver detalle de rol',
            'slug' => 'roles.show',
            'description' => 'Ver la informacion de un rol especifico'
        ]);
        Permission::create([
            'name' => 'Crear rol',
            'slug' => 'roles.create',
            'description' => 'Crear un nuevo rol'
        ]);
        Permission::create([
            'name' => 'Editar rol',
            'slug' => 'roles.edit',
            'description' => 'Actualizar los datos de un rol'
        ]);
        Permission::create([
            'name' => 'Eliminar rol',
            'slug' => 'roles.destroy',
            'description' => 'Eliminar cualquier rol del sistema'
        ]);

        // Permisos de productos
        Permission::create([
            'name' => 'Navegar productos',
            'slug' => 'products.index',
            'description' => 'Lista y navega todos los productos'
        ]);
        Permission::create([
            'name' => 'Ver detalle de producto',
            'slug' => 'products.show',
            'description' => 'Ver la informacion de un producto especifico'
        ]);
        Permission::create([
            'name' => 'Crear producto',
            'slug' => 'products.create',
            'description' => 'Crear un nuevo producto'
        ]);
        Permission::create([
            'name' => 'Editar producto',
            'slug' => 'products.edit',
            'description' => 'Actualizar los datos de un producto'
        ]);
        Permission::create([
            'name' => 'Eliminar producto',
            'slug' => 'products.destroy',
            'description' => 'Eliminar cualquier producto del sistema'
        ]);
    }
}
