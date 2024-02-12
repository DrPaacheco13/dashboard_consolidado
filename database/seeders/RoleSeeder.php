<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['name' => 'pagina.gestionuser.index']);

        Permission::create(['name' => 'pagina.gestionuser.crear']);
        Permission::create(['name' => 'pagina.gestionuser.editar']);
        Permission::create(['name' => 'pagina.gestionuser.destroy']);

        Permission::create(['name' => 'pagina.gestionmall.index']);

        Permission::create(['name' => 'pagina.gestionmall.crear']);
        Permission::create(['name' => 'pagina.gestionmall.editar']);
        Permission::create(['name' => 'pagina.gestionmall.destroy']);

    }
}
