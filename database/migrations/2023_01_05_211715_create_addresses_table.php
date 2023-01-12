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
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('UF', array_column(UFEnum::cases(), 'value'));
            $table->string('city')->nullable(false);
            $table->string('district')->nullable(false);
            $table->string('street')->nullable(false);
            $table->string('number')->nullable(false);
            $table->string('reference')->nullable(false);
            $table->timestamps();

            $table->index(['id', 'user_id', 'city', 'UF']);
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
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('addresses');
    }
};
