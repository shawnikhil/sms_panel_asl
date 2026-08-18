<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsApi extends Model
{
    use HasFactory;

    protected $table = 'j7_dmt_apisetup_tbl';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'vendor_name',
        'apiname',
        'apitype',
        'apino',
        'lastch_date',
        'lastch_time',
        'status',
        'insert_date',
        'insert_user',
        'update_date',
        'update_user',
    ];

    /**
     * Get formatted change datetime (e.g. 25/03/2026 02:57:49 PM)
     */
    public function getFormattedChangeDateTimeAttribute(): string
    {
        $datePart = '';
        if (!empty($this->lastch_date)) {
            try {
                $datePart = Carbon::parse($this->lastch_date)->format('d/m/Y');
            } catch (\Exception $e) {
                $datePart = (string)$this->lastch_date;
            }
        } elseif (!empty($this->insert_date)) {
            try {
                return Carbon::parse($this->insert_date)->format('d/m/Y h:i:s A');
            } catch (\Exception $e) {}
        }

        $timePart = trim((string)$this->lastch_time);

        $combined = trim($datePart . ' ' . $timePart);
        return $combined ?: '-';
    }

    /**
     * Get vendor display name with parentheses
     */
    public function getVendorDisplayAttribute(): string
    {
        $v = trim((string)$this->vendor_name);
        if (empty($v)) return '';
        return str_starts_with($v, '(') ? $v : '(' . $v . ')';
    }

    /**
     * Check if gateway is active
     */
    public function getIsActiveAttribute(): bool
    {
        return in_array(strtoupper((string)$this->status), ['1', 'ACTIVE', 'Y', 'YES'], true);
    }
}
