<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable =[
        'first_name' , 'last_name' ,
        'email' , 'user_id' , 'phone' , 'address' ,
        'total_amount',
    ];
    protected static function booted(){
        static::creating(function(Order $order){
            $now = Carbon::now();
            $max= Order::whereYear('created_at' , $now->year)->max('number');
            if(!$max){
              $max=$now->year.'0000';
            }
            $order->number = $max + 1;
        });
    }


    public function items()
    {
        return $this->belongsToMany(Item::class, OrderItem::class, 'order_id', 'item_id')
            ->withPivot('price', 'quantity');
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id')->withDefault();
       }



}
