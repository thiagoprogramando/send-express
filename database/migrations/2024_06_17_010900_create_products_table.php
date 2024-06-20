<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('file')->nullable();

            $table->decimal('value', 10, 2)->default(0.00);

            $table->boolean('credit_opt')->nullable();
            $table->integer('credit_installments')->default(1);
            $table->boolean('boleto_opt')->nullable();
            $table->integer('boleto_installments')->default(1);
            $table->boolean('pix_opt')->nullable();
            $table->integer('pix_installments')->default(1);

            $table->longText('url_redirect')->nullable();
            $table->string('status')->default('pendent'); // default status is pendent
            $table->unsignedBigInteger('views')->default(0); // default views is 0

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('product');
    }
};
