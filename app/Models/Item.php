<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(restaurant::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, CategoryItem::class, 'item_id', 'category_id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, OrderItem::class, 'item_id', 'order_id')
        ->withPivot('price','quantity')->using(OrderItem::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, UserItem::class, 'item_id', 'user_id');
    }

    public function orderItem()
{
    return $this->hasOne(OrderItem::class);
}

public function cartUsers()
{
    return $this->belongsToMany(User::class, 'carts')
    ->using(Cart::class)->withPivot('cookie_id',
'id' , 'quantity')->as('cart');
}


}
