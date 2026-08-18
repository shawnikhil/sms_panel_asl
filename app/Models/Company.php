<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'mukta_system_company_db';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'display_name',
        'billnoprefix',
        'begining_from',
        'commencing_from',
        'address1',
        'address2',
        'address3',
        'tinno',
        'cstno',
        'taxno',
        'cinno',
        'itpan_no',
        'fax_no',
        'country',
        'statecode',
        'mob_one',
        'mob_two',
        'mob_three',
        'land_no',
        'email_id',
        'email_id_inv',
        'website',
        'gstno',
        'gstper',
        'enableless',
        'lessper',
        'descone',
        'desctwo',
        'descthree',
        'comp_logo',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];
}
