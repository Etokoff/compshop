<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter {

    private $builder;
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function apply($builder) {
        $this->builder = $builder;
        foreach ($this->request->query() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    private function orderBy($value) {
        $products = $this->builder->get();
        $count = $products->count();
        if ($count > 1) {
            if ($value == 'price-low-high') {
                $this->builder->orderBy('price')->get();
            } elseif ($value == 'price-high-low') {
                $this->builder->orderBy('price', 'desc')->get();
            } elseif ($value == 'name-a-z') {
                $this->builder->orderBy('name')->get();
            } elseif ($value == 'name-z-a') {
                $this->builder->orderBy('name', 'desc')->get();
            }
        }
    }

    private function new($value) {
        if ('yes' == $value) {
            $this->builder->where('new', true);
        }
    }

    private function hit($value) {
        if ('yes' == $value) {
            $this->builder->where('hit', true);
        }
    }

    private function sale($value) {
        if ('yes' == $value) {
            $this->builder->where('sale', true);
        }
    }

    private function discount($value) {
        if ('yes' == $value) {
            $this->builder->where('discount', '>', 0);
        }
    }
}
