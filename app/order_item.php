<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    protected $fillable = [
        'style', 'color', 'ship_info','fob_price'
    ];

    public function work_order(){
        return $this->belongsTo(work_order::class);
    }

    public function order_item_sizes(){
        return $this->hasMany(order_item_size::class);
    }
}
