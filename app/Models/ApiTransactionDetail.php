<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiTransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'z_1_api_transaction_details';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'servid',
        'trandate',
        'trantime',
        'userid',
        'usertoken',
        'userip',
        'usermachine',
        'sender_id',
        'smsapi',
        'template_id',
        'rechargeno',
        'smstext',
        'credit_count',
        'amount',
        'tran_status',
        'complain_text',
        'complain_date',
        'sms_type',
        'sms_send_by',
        'custsend_log',
        'apirecv_log',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
}
