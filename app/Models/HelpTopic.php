<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpTopic extends Model
{
    use HasFactory;

    protected $table = 'b10_api_help_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'topic_name',
        'topic_desc',
        'post_date',
        'post_time',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
