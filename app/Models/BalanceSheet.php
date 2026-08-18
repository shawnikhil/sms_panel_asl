<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    use HasFactory;

    protected $table = 'b4_api_user_balance_sheet_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'uregno',
        'regamt',
        'instamt_for_prepaid',
        'service_amt_for_prepaid',
        'comamt_for_prepaid',
        'total_amt_for_prepaid',
        'instamt_for_utility',
        'service_amt_for_utility',
        'comamt_for_utility',
        'total_amt_for_utility',
        'instamt_for_bank',
        'service_amt_for_bank',
        'comamt_for_bank',
        'total_amt_for_bank',
        'instamt_for_travel',
        'service_amt_for_travel',
        'comamt_for_travel',
        'total_amt_for_travel',
        'balance_amt',
        'sms_balance',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
