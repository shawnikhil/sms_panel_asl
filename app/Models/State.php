<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'mukta_state_db';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'country_id',
        'state_name',
        'state_code',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
