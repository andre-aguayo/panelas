<?php

use App\EnumTypes\UFEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('description')->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('phone')->nullable(false);
            $table->enum('UF', array_column(UFEnum::cases(), 'value'));
            $table->string('city')->nullable(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'UF', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};