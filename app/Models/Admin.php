<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'mukta_admin_db';
    protected $primaryKey = 'admin_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'admin_username',
        'admin_password',
        'admin_fname',
        'admin_lname',
        'mob_one',
        'mob_two',
        'email_id',
        'pinno',
        'country_name',
        'state_name',
        'address',
        'pass_criteria',
        'profile_img',
        'admin_type',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];

    protected $hidden = [
        'admin_password',
    ];

    public function getAuthPassword(): string
    {
        return $this->admin_password ?? '';
    }

    public function getRememberTokenName()
    {
        return null;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // no remember token column on this table
    }
}
