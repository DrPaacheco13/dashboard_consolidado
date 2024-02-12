<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MallsModel extends Model
{
    protected $connection = 'mysql_1';

    public function __construct()
    {
        configureDatabaseConnection();
    }

    public function GetLastMallInsert()
    {
        $mall = DB::table('malls')->orderBy('id', 'desc');
        $data = $mall->first();

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getMall($id)
    {
        $mall = DB::table('malls');
        $mall->where(['id' => $id]);
        $data = $mall->first();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function insertMall($data)
    {
        $insert = DB::table('malls')->insert($data);
        if ($insert) {
            return $insert;
        } else {
            return false;
        }
    }

    public function updateMall($data, $id)
    {
        $mall = DB::table('malls');
        $mall->where("id", $id);
        return $mall->update($data);
    }

    public function deleteCliente($data, $id)
    {
        $cliente = $this->db->table('clientes');
        $cliente->set($data);
        $cliente->where("id", $id);
        return $cliente->update();
    }
}
