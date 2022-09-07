<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Helpers\ProductFilter;
use Illuminate\Http\Request;

class CatalogController extends Controller {

    public $viewMode=1;
    public $pagination=9;
    public $orderBy='default';

    public function index() {
        // корневые категории
        $roots = Category::where('parent_id', 0)->get();
        // популярные бренды
        $brands = Brand::popular();
        return view('catalog.index', compact('roots', 'brands'));
    }

    public function brand(Brand $brand, ProductFilter $filters) {
        $products = $brand
            ->products() // возвращает построитель запроса
            ->filterProducts($filters)
            ->paginate(6)
            ->withQueryString();
        return view('catalog.brand', compact('brand', 'products'));
    }

    public function product(Product $product) {
        return view('catalog.product', compact('product'));
    }

    public function category(Category $category, Request $request) {
        $filters =new ProductFilter($request);
        if ($request->has('orderBy')) {
            $orderBy = $request->input('orderBy');
            $this->orderBy = $orderBy;
        } else {
            $orderBy = $this->orderBy;
        }

        $pagination = $request->session()->get('pagination', $this->pagination);

        if ($request->has('pagination')) {
            $pagination = $request->input('pagination');
            session(['pagination' => $pagination]);
        } else {
            $pagination = $this->pagination;
        }
        $orderByName = "Сортировать по";
        switch ($orderBy) {
            case "price-low-high":
                $orderByName = 'Цена <i class="fas fa-sort-numeric-down"></i>';
                break;
            case "price-high-low":
                $orderByName = 'Цена <i class="fas fa-sort-numeric-down-alt"></i>';
                break;
            case "name-a-z":
                $orderByName = 'Название <i class="fas fa-sort-alpha-down"></i>';
                break;
            case "name-z-a":
                $orderByName = 'Название <i class="fas fa-sort-alpha-down-alt"></i>';
                break;
        }
        $viewMode = $this->viewMode;
        $products = Product::categoryProducts($category->id) // товары категории и всех ее потомков
        ->filterProducts($filters) // фильтруем товары категории и всех ее потомков
        ->paginate($pagination)
            ->withQueryString();
        $parents = Category::getAllParents($category->id);
        if (! $request->ajax()) {
            return view('catalog.category', compact('category', 'products', 'viewMode', 'parents', 'orderBy', 'orderByName'));
        } else {
            return view('catalog.part.list', compact('products'));
        }
    }

    public function menu(Category $category) {
        $items = Category::where('parent_id', $category->id)->get();
        $html="";
        foreach ($items as $item){
            $html = $html."<li>";
            $url = "\catalog\category\\".$item->slug;
            $html = $html."<a href='".$url."'>".$item->name."</a>";
            if ($item->chld_ct>0) {
                $html = $html . "<span class='badge badge-dark' onclick='ToggleCatalog(this)' onmouseover='this.style.cursor=`pointer`'>";
                $html = $html . "<i id='fa-" . $item->slug . "' class='fa fa-plus'></i>";
                $html = $html . "</span>";
                $html = $html . "<ul id='" . $item->slug . "' style='display: none'></ul>";
            }
        }
        return $html;
        //return response()->json(['items' => $items]);
        //return view('layout.part.roots', compact('items'));
    }

    public function search(Request $request) {
        $search = $request->input('query');
        $query = Product::search($search);
        $products = $query->paginate($this->pagination)->withQueryString();
        return view('catalog.search', compact('products', 'search'));
    }

    public function setviewmode($toViewMode) {
        $this->viewMode = $toViewMode;
        session(['viewMode' => $toViewMode]);
        return back();
    }
}
