<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiAutoNo extends Model
{
    use HasFactory;

    protected $table = 'api_user_autono_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'incno',
        'apiautono',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
