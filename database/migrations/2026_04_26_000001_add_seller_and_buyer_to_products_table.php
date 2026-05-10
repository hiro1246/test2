<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerAndBuyerToProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('seller_user_id')
                ->nullable()
                ->after('image_path')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('buyer_user_id')
                ->nullable()
                ->after('seller_user_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('buyer_user_id');
            $table->dropConstrainedForeignId('seller_user_id');
        });
    }
}
