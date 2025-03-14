<?php

namespace Database\Seeders;

use App\Models\Corporation;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $corporation = Corporation::firstOrCreate(
            ['name' => 'Ethical Foods Inc.', 'slug' => 'ethical-foods'],
            ['description' => 'A company committed to ethical food production.']
        );

        // Assign ethical labels to the corporation
        $corporation->attachTags(['B Corporation', 'Carbon Neutral'], 'corporationEthicalLabel');

        $products = [
            [
                'name' => 'Organic Vegan Protein Bar',
                'description' => 'A healthy and sustainable protein bar made with organic ingredients.',
                'barcode' => '1234567890123'],
            [
                'name' => 'Fair Trade Dark Chocolate',
                'description' => 'Rich dark chocolate made from fair trade cocoa.',
                'barcode' => '1234567890124'],
            [
                'name' => 'Gluten-Free Granola',
                'description' => 'Crunchy granola that is 100% gluten-free.',
                'barcode' => '1234567890125'],
            [
                'name' => 'Sustainably Sourced Coffee',
                'description' => 'Ethically sourced coffee beans with a smooth flavor.',
                'barcode' => '1234567890126'],
            [
                'name' => 'Organic Almond Butter',
                'description' => 'Creamy almond butter made with organic almonds.',
                'barcode' => '1234567890127'],
            [
                'name' => 'Plant-Based Protein Powder',
                'description' => 'High-quality protein powder made from plant-based ingredients.',
                'barcode' => '1234567890128'],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'uuid' => Str::uuid(),
                'name' => $productData['name'],
                'description' => $productData['description'],
                'barcode' => $productData['barcode'],
                'corporation_id' => $corporation->id,
                'status' => 'published',
            ]);

            // Assign random certifications and packaging tags
            $product->attachTags(['Organic', 'Non-GMO'], 'productCertification');
            $product->attachTags(['Recyclable Packaging', 'Plastic-Free'], 'productPackaging');
        }
    }
}
