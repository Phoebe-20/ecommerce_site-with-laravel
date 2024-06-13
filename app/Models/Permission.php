<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permission';

    static public function getRecord()
    {
        $getPermission = Permission::name('name')->get();
        $result = array();
        foreach ($getPermission as $value)
        {
            $data = array();
            $data['id'] = $value->id;
        }
    }
}
