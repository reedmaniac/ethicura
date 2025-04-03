<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Tags\HasTags;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use HasTags;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'barcode',
        'corporation_id',
        'status',
        'calories',
        'protein',
        'fat',
        'carbohydrates',
        'saturated_fat',
        'trans_fat',
        'cholesterol',
        'dietary_fiber',
        'sugars',
        'added_sugars',
        'sodium',
        'vitamin_a',
        'vitamin_c',
        'vitamin_d',
        'calcium',
        'iron',
        'potassium',
        'net_carbs',
        'glycemic_index',
        'serving_size',
        'servings_per_container',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->uuid = Str::uuid();
        });
    }

    /**
     * Get the corporation assigned to the product.
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class);
    }

    /**
     * Get the certifications assigned to the product.
     */
    public function certifications()
    {
        return $this->tags()->where('type', 'productCertification');
    }

    /**
     * Get the packaging details assigned to the product.
     */
    public function packaging()
    {
        return $this->tags()->where('type', 'productPackaging');
    }
}
