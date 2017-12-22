<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';

 	/**
 	 * 获取订单商品信息
 	 * @return [type] [description]
 	 */
    public function carts()
    {
        return $this->hasMany('App\Entity\Carts', 'order_no', 'order_no');
    }
}