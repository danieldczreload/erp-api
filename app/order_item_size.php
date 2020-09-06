<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_item_size extends Model
{
    protected $fillable = [
        'size_name', 'qty', 'order_by'
    ];

    public function order_item(){
        return $this->belongsTo(order_item::class);
    }
}
