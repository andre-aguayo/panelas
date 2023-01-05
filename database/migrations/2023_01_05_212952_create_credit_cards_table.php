<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->uuid('uuid')->default(DB::raw('(UUID())'))->primary();
            $table->foreignUuid('user_uuid')->references('uuid')->on('users');
            $table->string('cardholder_name')->nullable(false);
            $table->string('number')->nullable(false);
            $table->string('expiration_date')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['uuid', 'user_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_cards', function (Blueprint $table) {
            $table->dropForeign(['user_uuid']);
        });
        Schema::dropIfExists('credit_cards');
    }
};
