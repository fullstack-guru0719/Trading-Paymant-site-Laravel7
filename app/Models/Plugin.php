<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plugin extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'shortcode' => 'object',
    ];

    public function scopeGenerateScript()
    {
        $script = $this->script;
        foreach ($this->shortcode as $key => $item) {
            $script = shortCodeReplacer('{{' . $key . '}}', $item->value, $script);
        }
        return $script;
    }
}
