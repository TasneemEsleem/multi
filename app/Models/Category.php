<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    public function item()
    {
        return $this->hasMany(Item::class);
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'Parent'
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class , CategoryItem::class , 'category_id', 'item_id' );
    }
    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }
}
