<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'd1_package_master_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'refuserid',
        'pack_name',
        'pacch',
        'whch',
        'apistatus',
        'default_status',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
