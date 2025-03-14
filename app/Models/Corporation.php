<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

class Corporation extends Model
{
    /** @use HasFactory<\Database\Factories\CorporationFactory> */
    use HasFactory;

    use HasTags;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the products associated with the corporation.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the ethical labels assigned to the corporation.
     */
    public function ethicalLabels()
    {
        return $this->tags()->where('type', 'corporationEthicalLabel');
    }
}
