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
            $table->decimal('saturated_fat', 8, 2)->nullable();
            $table->decimal('trans_fat', 8, 2)->nullable();
            $table->integer('cholesterol')->nullable();
            $table->decimal('dietary_fiber', 8, 2)->nullable();
            $table->decimal('sugars', 8, 2)->nullable();
            $table->decimal('added_sugars', 8, 2)->nullable();
            $table->integer('sodium')->nullable();
            $table->integer('vitamin_a')->nullable();
            $table->integer('vitamin_c')->nullable();
            $table->integer('vitamin_d')->nullable();
            $table->integer('calcium')->nullable();
            $table->integer('iron')->nullable();
            $table->integer('potassium')->nullable();
            $table->decimal('net_carbs', 8, 2)->nullable();
            $table->string('serving_size')->nullable();
            $table->integer('servings_per_container')->nullable();
            $table->decimal('calories', 8, 2)->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();
            $table->decimal('carbohydrates', 8, 2)->nullable();


            $table->enum('glycemic_index', ['low', 'medium', 'high'])->nullable();
            /* glycemic index, which is categorized as:
                Low (≤ 55)
                Medium (56–69)
                High (≥ 70)
            */
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'saturated_fat', 'trans_fat', 'cholesterol', 'dietary_fiber', 'sugars', 'added_sugars',
                'sodium', 'vitamin_a', 'vitamin_c', 'vitamin_d', 'calcium', 'iron', 'potassium',
                'net_carbs', 'glycemic_index', 'serving_size', 'servings_per_container',
                'calories', 'protein', 'fat', 'carbohydrates'
            ]);
        });
    }
};
