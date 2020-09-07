<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class work_order
 * @package App
 */
class work_order extends Model
{

    protected $fillable = [
        'order_number', 'client', 'ship_date'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 1,
        'erp' => ''
    ];

    public function order_items(){
        return $this->hasMany(order_item::class);
    }
}
