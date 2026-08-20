<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{

    protected $table = 'b1_api_user_reg_tbl';
    public $timestamps = false;

    public function getAuthPassword(): string
    {
        return $this->userpass ?? '';
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
        // No remember token column on this user table.
    }

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


      protected $fillable = [
        'id',
        'regno',
        'catid',
        'apitoken',
        'ipaddress',
        'apiremarks',
        'callbackurl',
        'refdist',
        'regtype',
        'isotpverify',
        'otpverifytype',
        'proimg',
        'fname',
        'lname',
        'phone',
        'email',
        'dob',
        'sex',
        'addsdt',
        'landmark',
        'nation',
        'pincode',
        'panno',
        'regamt',
        'paymode',
        'paydesc',
        'company_name',
        'gstnumber',
        'aadharno',
        'userid',
        'userpass',
        'otp_reqpay',
        'pin_code',
        'pass_criteria',
        'attachment1',
        'attachment2',
        'attachment3',
        'attachment4',
        'apistatus',
        'status',
        'package_id',
        'lockamt',
        'whlabel_folder',
        'regst_date',
        'regst_time',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user'
    ];


    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'catid', 'id');
    }

    public function balanceSheet()
    {
        return $this->hasOne(BalanceSheet::class, 'uregno', 'regno');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
