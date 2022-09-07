<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\BasketController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', IndexController::class)->name('index');
Route::get('/page/{page:slug}', 'App\Http\Controllers\PageController')->name('page.show');

/*
 * Каталог товаров: категория, бренд и товар
 */
Route::group([
    'as' => 'catalog.', // имя маршрута, например catalog.index
    'prefix' => 'catalog', // префикс маршрута, например catalog/index
], function () {
    // главная страница каталога
    Route::get('index', 'App\Http\Controllers\CatalogController@index')
        ->name('index');
    // категория каталога товаров
    Route::get('category/{category:slug}', 'App\Http\Controllers\CatalogController@category')
        ->name('category');
    Route::get('category/menu/{category:slug}', 'App\Http\Controllers\CatalogController@menu')
        ->name('category.menu');
    // бренд каталога товаров
    Route::get('brand/{brand:slug}', 'App\Http\Controllers\CatalogController@brand')
        ->name('brand');
    // страница товара каталога
    Route::get('product/{product:slug}', 'App\Http\Controllers\CatalogController@product')
        ->name('product');
    // страница результатов поиска
    Route::get('search', 'App\Http\Controllers\CatalogController@search')
        ->name('search');
    Route::get('viewmode/{toViewMode}', 'App\Http\Controllers\CatalogController@setviewmode')
        ->name('viewmode');
});

Route::get('/basket/index', [BasketController::class, "index"])->name('basket.index');
Route::post('/basket/add/{id}', 'App\Http\Controllers\BasketController@add')
    ->where('id', '[0-9]+')
    ->name('basket.add');
Route::post('/basket/plus/{id}', [BasketController::class, 'plus'])
    ->where('id', '[0-9]+')
    ->name('basket.plus');
Route::post('/basket/minus/{id}', [BasketController::class, 'minus'])
    ->where('id', '[0-9]+')
    ->name('basket.minus');
Route::post('/basket/remove/{id}', [BasketController::class, 'remove'])
    ->where('id', '[0-9]+')
    ->name('basket.remove');
Route::post('/basket/clear', [BasketController::class, 'clear'])->name('basket.clear');
Route::get('/basket/checkout', [BasketController::class, "checkout"])->name('basket.checkout');
Route::post('/basket/saveorder', 'App\Http\Controllers\BasketController@saveOrder')->name('basket.saveorder');
Route::get('/basket/success/{order_id}', 'App\Http\Controllers\BasketController@success')
    ->where('order_id', '[0-9]+')
    ->name('basket.success');
Route::post('/basket/profile', 'App\Http\Controllers\BasketController@profile')
    ->name('basket.profile');
//Route::get('/basket/success', 'App\Http\Controllers\BasketController@success')->name('basket.success');

Auth::routes();

Route::group([
    'as' => 'user.', // имя маршрута, например user.index
    'prefix' => 'user', // префикс маршрута, например user/index
    'middleware' => ['auth'] // один или несколько посредников
], function () {
    // главная страница личного кабинета пользователя
    Route::get('index', 'App\Http\Controllers\HomeController@index')->name('index');
    // CRUD-операции над профилями пользователя
    Route::resource('profile', 'App\Http\Controllers\ProfileController');
    // просмотр списка заказов в личном кабинете
    Route::get('order', 'App\Http\Controllers\OrderController@index')->name('order.index');
    // просмотр отдельного заказа в личном кабинете
    Route::get('order/{order}', 'App\Http\Controllers\OrderController@show')->name('order.show');
});


Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('index', 'App\Http\Controllers\Admin\IndexController')->name('index');
});

Route::group([
    'as' => 'admin.', // имя маршрута, например admin.index
    'prefix' => 'admin', // префикс маршрута, например admin/index
    'middleware' => ['auth', 'admin'] // один или несколько посредников
], function () {
    // главная страница панели управления
    Route::get('index', 'App\Http\Controllers\Admin\IndexController')->name('index');
    // CRUD-операции над категориями каталога
    Route::resource('category', 'App\Http\Controllers\Admin\CategoryController', ['except' => ['create']]);
    Route::get('category/create/{parent}', 'App\Http\Controllers\Admin\CategoryController@create')
        ->name('category.create');
    // CRUD-операции над брэндами каталога
    Route::resource('brand', 'App\Http\Controllers\Admin\BrandController');
    // CRUD-операции над товарами каталога
    Route::resource('product', 'App\Http\Controllers\Admin\ProductController', ['except' => ['create']]);
    Route::get('product/create/{category}', 'App\Http\Controllers\Admin\ProductController@create')
        ->name('product.create');
    // доп.маршрут для просмотра товаров категории
    Route::get('product/category/{category}', 'App\Http\Controllers\Admin\ProductController@category')
        ->name('product.category');
    // просмотр и редактирование заказов
    Route::resource('order', 'App\Http\Controllers\Admin\OrderController', ['except' => [
        'create', 'store', 'destroy'
    ]]);
    // просмотр и редактирование пользователей
    Route::resource('user', 'App\Http\Controllers\Admin\UserController', ['except' => [
        'create', 'store', 'show', 'destroy'
    ]]);
    // CRUD-операции над страницами сайта
    Route::resource('page', 'App\Http\Controllers\Admin\PageController');
    // загрузка изображения из редактора
    Route::post('page/upload/image', 'App\Http\Controllers\Admin\PageController@uploadImage')
        ->name('page.upload.image');
    // удаление изображения в редакторе
    Route::delete('page/remove/image', 'App\Http\Controllers\Admin\PageController@removeImage')
        ->name('page.remove.image');
});
