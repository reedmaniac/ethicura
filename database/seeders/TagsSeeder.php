<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Product tags - Certifications
        Tag::findOrCreate(['name' => 'Organic', 'slug' => 'organic'], 'productCertification');
        Tag::findOrCreate(['name' => 'Non-GMO', 'slug' => 'non-gmo'], 'productCertification');
        Tag::findOrCreate(['name' => 'Fair Trade', 'slug' => 'fair-trade'], 'productCertification');
        Tag::findOrCreate(['name' => 'Rainforest Alliance Certified', 'slug' => 'rainforest-alliance'], 'productCertification');
        Tag::findOrCreate(['name' => 'USDA Organic', 'slug' => 'usda-organic'], 'productCertification');
        Tag::findOrCreate(['name' => 'Demeter Biodynamic', 'slug' => 'demeter-biodynamic'], 'productCertification');
        Tag::findOrCreate(['name' => 'Animal Welfare Approved', 'slug' => 'animal-welfare-approved'], 'productCertification');
        Tag::findOrCreate(['name' => 'Certified Humane', 'slug' => 'certified-humane'], 'productCertification');
        Tag::findOrCreate(['name' => 'MSC Certified Sustainable Seafood', 'slug' => 'msc-certified'], 'productCertification');
        Tag::findOrCreate(['name' => 'Fair for Life', 'slug' => 'fair-for-life'], 'productCertification');

        // Product tags - Packaging
        Tag::findOrCreate(['name' => 'Recyclable Packaging', 'slug' => 'recyclable-packaging'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Compostable', 'slug' => 'compostable'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Biodegradable', 'slug' => 'biodegradable'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Plastic-Free', 'slug' => 'plastic-free'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Minimal Packaging', 'slug' => 'minimal-packaging'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Reusable Packaging', 'slug' => 'reusable-packaging'], 'productPackaging');

        // Corporation tags - Ethical Labeling
        Tag::findOrCreate(['name' => 'B Corporation', 'slug' => 'b-corporation'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => '1% for the Planet', 'slug' => 'one-percent-for-the-planet'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Carbon Neutral', 'slug' => 'carbon-neutral'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Certified Climate Neutral', 'slug' => 'climate-neutral'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Fair Trade Certified Business', 'slug' => 'fair-trade-business'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Ethical Consumer Best Buy', 'slug' => 'ethical-consumer-best-buy'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Women-Owned Business Certified', 'slug' => 'women-owned-business'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Living Wage Certified', 'slug' => 'living-wage-certified'], 'corporationEthicalLabel');
        Tag::findOrCreate(['name' => 'Zero Waste Certified', 'slug' => 'zero-waste'], 'corporationEthicalLabel');
    }
}
