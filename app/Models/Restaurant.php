<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function item()
    {
        return $this->hasMany(Item::class);
    }
    public function categories() {
        return $this->hasMany(Category::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
