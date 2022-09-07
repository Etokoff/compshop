<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Basket;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {

        View::composer('layout.part.roots', function($view) {
            static $items = null;
            if (is_null($items)) {
                $items = Category::where('parent_id', 0)->get();
            }
            $view->with(['items' => $items]);
        });
        //View::composer('layout.part.brands', function($view) {
            //$view->with(['items' => Brand::popular()]);
        //});
        View::composer('layout.site', function($view) {
            $getkurs = new Client();
            $res = $getkurs->get('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11');
            if ($res->getStatusCode()==200) {
                $res2 = json_decode($res->getBody(), true);
                $kurs = $res2[0]['sale'];
            } else {
                $kurs = '';
            }
            $view->with(['positions' => Basket::getCount(), 'kurs' => $kurs]);
        });
        View::composer('layout.part.pages', function($view) {
            static $pages = null;
            $adminka = 0;
			if (is_null($pages)) {
			    if (!is_null(auth()->user())) {
			        if (auth()->user()->admin) {
			            $adminka = 1;
                    }
                }
				$pages = Page::where('adminka','=',$adminka)->get()->sortBy('order');
			}
			$view->with(['pages' => $pages]);
        });
    }
}
