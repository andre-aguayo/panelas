<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Marcas e descriçoes do produto ficarao em more products description
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->foreignUuid('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('image');
            $table->integer('value');
            $table->integer('cost');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id', 'product_category_id', 'name', 'value', 'cost']);
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
            $table->dropForeign(['product_category_id']);
        });

        Schema::dropIfExists('products');
    }
};
