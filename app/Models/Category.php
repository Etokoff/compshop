<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model {

    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'content',
        'image',
        'chld_ct',
    ];

    /**
     * Проверяет, что переданный идентификатор id может быть родителем
     * этой категории; что категорию не пытаются поместить внутрь себя
     */
    public function validParent($id) {
        $id = (integer)$id;
        // получаем идентификаторы всех потомков текущей категории
        $ids = $this->getAllChildren($this->id);
        $ids[] = $this->id;
        return ! in_array($id, $ids);
    }
    /**
     * Возвращает всех потомков категории с идентификатором $id
     */
    public static function getAllChildren($id) {
        // получаем прямых потомков категории с идентификатором $id
        $children = self::where('parent_id', $id)->with('children')->get();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->id;
            // для каждого прямого потомка получаем его прямых потомков
            if ($child->children->count()) {
                $ids = array_merge($ids, self::getAllChildren($child->id));
            }
        }
        return $ids;
    }
    /**
     * Возвращает всех предков категории с идентификатором $id
     */
    public static function getAllParents($id) {
        // получаем прямых потомков категории с идентификатором $id
        $parents = [];
        $cat = self::find($id);

        while ($cat->parent_id > 0) {
            array_unshift($parents, $cat);
            $cat = self::find($cat->parent_id);
        }
        array_unshift($parents, $cat);
        return $parents;
    }
    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `products`
     */
    public function products() {
        return $this->hasMany(Product::class);
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`
     */
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * возвращает родителя
     */
    public function getParent() {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    /**
     * Возвращает список корневых категорий каталога товаров
     */
    public static function roots() {
        return self::where('parent_id', 0)->with('children')->get();
    }
    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`, но
     * позволяет получить не только дочерние категории, но и дочерние-дочерние
     */
    public function descendants() {
        return $this->hasMany(Category::class, 'parent_id')->with('descendants');
    }

    /**
     * Возвращает список всех категорий каталога в виде дерева
     */
    public static function hierarchy() {
        return self::where('parent_id', 0)->with('descendants')->get();
    }
}
