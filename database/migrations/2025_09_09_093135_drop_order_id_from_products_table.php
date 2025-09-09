<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 1. أولاً احذف ال foreign key constraint
            $table->dropForeign(['order_id']);
            
            // 2. ثانياً احذف العمود نفسه
            $table->dropColumn('order_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained('orders') // ← الجدول هنا
                  ->nullOnDelete(); // ← من غير parameters
        });
    }
};