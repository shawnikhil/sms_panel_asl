<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SenderId extends Model
{
    use HasFactory;

    protected $table = 'sms_1_sender_id';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sender_id',
        'entity_id',
        'sender_desc',
        'entry_date',
        'entry_time',
        'modified_date',
        'modified_time',
        'modified_mesg',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
