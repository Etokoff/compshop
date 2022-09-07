<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'name',
        'slug',
        'content',
        'parent_id',
        'editable',
        'adminka',
    ];
    /**
     * Связь «один ко многим» таблицы `pages` с таблицей `pages`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * Связь «страница принадлежит» таблицы `pages` с таблицей `pages`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo(Page::class);
    }

    public function isEditable() {
        return $this->editable;
    }
}
