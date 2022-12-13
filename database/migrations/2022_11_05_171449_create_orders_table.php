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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('voice')->nullable();
            $table->date('date');
            $table->time('time');
            $table->boolean('urgent')->default(false);
            $table->boolean('complex')->default(false);
            $table->enum('care_for', ['experience', 'cost'])->default('cost');
            $table->string('response')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->double('deal');
            $table->json('properties');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('runner_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('address_id')->nullable()->references('id')->on('addresses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
