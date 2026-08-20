<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletType extends Model
{
    use HasFactory;

    protected $table = 'x_api_wallet_type_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'typename',
        'acctype',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
