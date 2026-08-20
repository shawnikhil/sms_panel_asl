<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTranLazer extends Model
{
    use HasFactory;

    protected $table = 'b4_api_user_tran_lazer_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'regno',
        'transdesc',
        'trans_date',
        'trans_time',
        'credit_amt',
        'debit_amt',
        'opening_bal',
        'closing_bal',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'regno', 'regno');
    }
}
