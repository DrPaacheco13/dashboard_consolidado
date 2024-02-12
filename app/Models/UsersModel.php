<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersModel extends Model
{
    protected $connection = 'mysql_1';
    
    public function __construct()
    {
        configureDatabaseConnection();
    }

    public function getUsers($where, $select = NULL)
    {
        $user = DB::table('users as u');
        if (!empty($select)) {
            $user->select($select);
        } else {
            $user->selectRaw('u.*, m.nombre as nombre_mall, r.name as nombre_rol, d.nombre as nombre_distribucion');
        }
        if (!empty($where)) {
            $user->where($where);
        } else {
            $user->where(['estado' => true, 'deleted' => false]);
        }
        $user->join('malls as m', 'u.id_mall', '=', 'm.id');
        $user->join('roles as r', 'u.role_id', '=', 'r.id');
        $user->join('distribucion as d', 'u.distribucion_id', '=', 'd.id', 'left');
        $data = $user->get();
        if ($data) {
            return json_decode($data);
        } else {
            return false;
        }
    }
    public function getUser($id)
    {
        $user = DB::table('users');
        $user->where(['id' => $id]);
        $data = $user->first();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function insertUser($data)
    {
        $insert = DB::table('users')->insert($data);
        if ($insert) {
            return $insert;
        } else {
            return false;
        }
    }

    public function updateUser($data, $id)
    {
        $user = DB::table('users');
        $user->where("id", $id);
        return $user->update($data);
    }

    public function deleteUser($data, $id)
    {
        $user = DB::table('users');
        $user->where("id", $id);
        return $user->update($data);
    }
}
