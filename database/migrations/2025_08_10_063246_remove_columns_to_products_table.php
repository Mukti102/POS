<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'initial_stock',
                'stock',
                'cost_price',
                'selling_price'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('initial_stock')->after('name');
            $table->integer('stock')->after('initial_stock');
            $table->decimal('cost_price', 20, 2)->after('stock');
            $table->decimal('selling_price', 20, 2)->after('cost_price');
        });
    }
};
