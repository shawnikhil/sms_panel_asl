<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsApi extends Model
{
    use HasFactory;

    protected $table = 'j7_dmt_apisetup_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'vendor_name',
        'apiname',
        'apitype',
        'apino',
        'lastch_date',
        'lastch_time',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
