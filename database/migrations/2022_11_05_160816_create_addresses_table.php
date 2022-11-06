<?php

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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->string('city',50);
            $table->string('state',50);
            $table->string('street',100)->nullable();
            $table->string('suite',50)->nullable();
            $table->string('zip',20)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
