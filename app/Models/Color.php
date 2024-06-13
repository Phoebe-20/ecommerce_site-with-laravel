<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'color';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        return self::select('color.*', 'users.name as create_by_name')
                ->join('users', 'users.id', '=', 'color.create_by')
                ->orderBy('color.id', 'desc')
                ->paginate(50);
    }

    static public function getRecordActive()
    {
        return self::select('color.*')
                ->join('users', 'users.id', '=', 'color.create_by')
                ->where('color.status', '=', 0)
                ->orderBy('color.name', 'asc')
                ->get();
    }
  
}
