<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'b8_api_user_notification_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'regno',
        'notification_msg',
        'nitification_desc',
        'notification_date',
        'notification_time',
        'feedbackdesc',
        'feedback_date',
        'markasread',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
