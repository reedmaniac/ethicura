<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Corporation;
use App\Models\Product;
use App\Http\Resources\Api\CorporationResource;
use App\Http\Resources\Api\CorporationProductResource;

class CorporationsTest extends TestCase
{
    use RefreshDatabase;

    public function testApiReturnsListOfcorporations()
    {
        Corporation::factory()->count(3)->create();

        $response = $this->getJson('/api/corporations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['id', 'name', 'slug', 'description', 'ethical_labels'],
                ],
            ]);
    }

    public function testApiReturnsSingleValidCorporation()
    {
        $corporation = Corporation::factory()->create();

        $response = $this->getJson("/api/corporations/{$corporation->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(
                (new CorporationResource($corporation))->toArray(request())
            );
    }

    public function testReturnsAListOfProductsForACorporation()
    {
        $corporation = Corporation::factory()->create();
        Product::factory()->count(3)->create(['corporation_id' => $corporation->id]);

        $response = $this->getJson("/api/corporations/{$corporation->id}/products");

        $response->assertStatus(200)
             ->assertJsonStructure([
                 'data' => [
                     ['id', 'uuid', 'name', 'description', 'barcode', 'status'],
                 ],
             ]);
    }

    public function testReturnsASingleProductForACorporation()
    {
        $corporation = Corporation::factory()->create();
        $product = Product::factory()
            ->create(['corporation_id' => $corporation->id])
            ->load('certifications', 'packaging');

        $response = $this->getJson("/api/corporations/{$corporation->id}/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(
                (new CorporationProductResource($product))->toArray(request())
            );
    }
}
