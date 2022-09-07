<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kod', 10);
            $table->string('artikul', 30);
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->string('name', 100);
            $table->text('content')->nullable();
            $table->string('slug', 100)->unique();
            $table->string('image', 100)->nullable();
            $table->decimal('price_in', 10, 2, true)->default(0);
            $table->decimal('price', 10, 2, true)->default(0);
            $table->decimal('price_opt', 10, 2, true)->default(0);
            $table->mediumInteger('valuta_id')->default(840);
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы categories
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
            // внешний ключ, ссылается на поле id таблицы brands
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('products');
    }
}
