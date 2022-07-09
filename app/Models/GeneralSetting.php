<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
    	'mail_config' => 'object',
        'sms_config' => 'object',
        'off_day' => 'object',
    ];

    public function scopeSitename($query, $page_title)
    {
        $page_title = empty($page_title) ? '' : ' - ' . $page_title;
        return $this->sitename . $page_title;
    }
}
