<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id'); // permission id
            $table->string('name', 100);       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name', 100);       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([PermissionRegistrar::$pivotPermission, PermissionRegistrar::$pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'usuarios.index', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 2, 'name' => 'usuarios.create', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 3, 'name' => 'usuarios.edit', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 4, 'name' => 'usuarios.destroy', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 5, 'name' => 'mall.index', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 6, 'name' => 'mall.create', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 7, 'name' => 'mall.edit', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 8, 'name' => 'mall.destroy', 'guard_name' => 'web', 'created_at' => '2022-11-10 00:43:47', 'updated_at' => '2022-11-10 00:43:47'],
            ['id' => 9, 'name' => 'pagina.gestionuser.index', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 10, 'name' => 'pagina.gestionuser.crear', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 11, 'name' => 'pagina.gestionuser.editar', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 12, 'name' => 'pagina.gestionuser.destroy', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 13, 'name' => 'pagina.gestionmall.index', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 14, 'name' => 'pagina.gestionmall.create', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 15, 'name' => 'pagina.gestionmall.edit', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 16, 'name' => 'pagina.gestionmall.destroy', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
        ]);

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
            ['id' => 2, 'name' => 'Usuario', 'guard_name' => 'web', 'created_at' => '2022-11-24 17:28:00', 'updated_at' => '2022-11-24 17:28:00'],
        ]);

        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_type' => 'App\Models\User', 'model_id' => 1],
            ['role_id' => 1, 'model_type' => 'App\Models\User', 'model_id' => 3],
            ['role_id' => 2, 'model_type' => 'App\Models\User', 'model_id' => 6],
        ]);
        DB::table('role_has_permissions')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 1],
            ['permission_id' => 6, 'role_id' => 1],
            ['permission_id' => 7, 'role_id' => 1],
            ['permission_id' => 8, 'role_id' => 1],
        ]);

        

        
        
        
        
        
        
        

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}