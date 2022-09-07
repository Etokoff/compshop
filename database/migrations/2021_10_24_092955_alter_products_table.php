<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('new')->after('valuta_id')->default(false);
            $table->boolean('hit')->after('valuta_id')->default(false);
            $table->boolean('sale')->after('valuta_id')->default(false);
            $table->tinyInteger('discount')->after('new')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('new');
            $table->dropColumn('hit');
            $table->dropColumn('sale');
            $table->dropColumn('discount');
        });
    }
}
