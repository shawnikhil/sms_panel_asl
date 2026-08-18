<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $table = 'sms_2_manage_tamplates';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sender_id',
        'template_id',
        'content_text',
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
}
