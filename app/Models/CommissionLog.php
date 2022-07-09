<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{
    protected $guarded = ['id'];

    protected $table = "commission_logs";

    public function user(){
        return $this->belongsTo('App\Models\User','to_id','id');
    }
    public function bywho(){
        return $this->belongsTo('App\Models\User','from_id','id');
    }
}
