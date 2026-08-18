<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'acc_bank_db';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'com_id',
        'bank_name',
        'branc_name',
        'accno',
        'ifsc_code',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
