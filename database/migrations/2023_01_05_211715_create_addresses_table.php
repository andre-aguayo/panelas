<?php

use App\EnumTypes\UFEnum;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('uuid')->default(DB::raw('(UUID())'))->primary();
            $table->foreignUuid('user_uuid')->references('uuid')->on('users');
            $table->enum('UF', array_column(UFEnum::cases(), 'value'));
            $table->string('city')->nullable(false);
            $table->string('district')->nullable(false);
            $table->string('street')->nullable(false);
            $table->string('number')->nullable(false);
            $table->string('reference')->nullable(false);
            $table->timestamps();

            $table->index(['uuid', 'user_uuid', 'city', 'UF']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_uuid']);
        });
        Schema::dropIfExists('addresses');
    }
};
