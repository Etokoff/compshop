<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valuta extends Model {

    use HasFactory;

    protected $fillable = [
        'vnazva',
        'pvnazva',
    ];
    /**
     * Связь «один ко многим» таблицы `valuts` с таблицей `products`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany(Product::class);
    }


}
