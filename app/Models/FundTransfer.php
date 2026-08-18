<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundTransfer extends Model
{
    use HasFactory;

    protected $table = 'b2_api_user_fund_transfer_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tnuserid',
        'regno',
        'reqtype',
        'transfertype',
        'transfer_amt',
        'wallet_type_id',
        'transdesc',
        'online_tranid',
        'trans_date',
        'trans_time',
        'opening_bal',
        'closing_bal',
        'request_id',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
