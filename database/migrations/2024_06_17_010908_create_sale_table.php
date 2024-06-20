<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_seller')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_client')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_product')->constrained('products')->onDelete('cascade');

            $table->string('method')->nullable();
            $table->integer('installments')->nullable();

            $table->string('status')->default('pendent'); // default status is pendent
            $table->boolean('delivery')->default(false); // default status is pendent
            
            $table->longText('token')->nullable();
            $table->longText('url')->nullable();
            $table->longText('key_unique')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sale');
    }
};
