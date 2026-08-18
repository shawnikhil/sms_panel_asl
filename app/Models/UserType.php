<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'x_ueser_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_name',
        'user_id',
        'uregamt',
        'lockamt',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
