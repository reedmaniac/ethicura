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
        // @todo - Notes/Description explaining what the label actually means
        // @todo - Link to certification or More Info website
        // pivot field explaining the last time certification (or whatever) was renewed, tracked, something


        // Product tags - Certifications

        Tag::findOrCreate(['name' => 'Fair Trade', 'slug' => 'fair-trade'], 'productCertification');
        Tag::findOrCreate(['name' => 'Rainforest Alliance Certified', 'slug' => 'rainforest-alliance'], 'productCertification');
        Tag::findOrCreate(['name' => 'USDA Organic', 'slug' => 'usda-organic'], 'productCertification');
        Tag::findOrCreate(['name' => 'Demeter Biodynamic', 'slug' => 'demeter-biodynamic'], 'productCertification');

        // Animal Welfare or Humane
        Tag::findOrCreate(['name' => 'Animal Welfare Approved', 'slug' => 'animal-welfare-approved'], 'productCertification');
        Tag::findOrCreate(['name' => 'Certified Humane', 'slug' => 'certified-humane'], 'productCertification');

        // Sustability
        Tag::findOrCreate(['name' => 'MSC Certified Sustainable Seafood', 'slug' => 'msc-certified'], 'productCertification');

        // Fair Trade
        Tag::findOrCreate(['name' => 'Fair for Life', 'slug' => 'fair-for-life'], 'productCertification');

        // Origin (https://garnachagrenache.com/european-quality-certification-pdo-pgi-tsg-explained/)
        // - Alaska Seafood Certified
        // - Certified California Grow
        // - Appellation d'Origine Contrôlée (ex: wine, cheese), this might be a label AND a pivot field...?

        // Religious
        // - Halal Certified
        // - Kosher Certified


        // Type: Regenerative Farming
        // - Regenerative Organic Certified (ROC)
        // - Land to Market Verified
        // - Demeter Biodynamic
        // - Land to Market Verified
        // - Regenerative Organic Certified (ROC)

        // Type: Organic
        // - USDA Organic
        // - EU Organic
        // - Canada Organic
        // - JAS Organic (Japan)

        // Type: Pesticide-Free
        // - Certified Naturally Grown (CNG)
        // - Non-GMO Project Verified

        // Pollinator:
        // - Pollinator Steward Certification (PSC)
        // - Bee Friendly Farming

        // Health:
        // - Heart-Check Certified (AHA)
        // - Paleo Certified
        // - Keto Certified

        /*

        Additional Certification Organizations:

        GFCO – Gluten-Free Certification Organization
        Certifies products as gluten-free (less than 10 ppm of gluten). It’s a program of the Gluten Intolerance Group (GIG) and is one of the most recognized gluten-free certifications globally.

        SQF – Safe Quality Food
        A food safety management certification program recognized by the Global Food Safety Initiative (GFSI). It ensures products are produced, processed, and handled according to the highest standards.

        BRC – British Retail Consortium
        Now known as BRCGS (Brand Reputation through Compliance Global Standards). It provides food safety and quality certifications, primarily recognized in the UK and internationally.

            BRCGS Food Safety
            BRCGS Packaging Materials
            BRCGS Storage and Distribution
            BRCGS Agents and Brokers
            BRCGS Consumer Products
            BRCGS Gluten-Free Certification Program
            BRCGS Plant-Based Global Standard

        GFSI – Global Food Safety Initiative
        Not a certification itself but a benchmark for food safety standards (like SQF, BRC, IFS, etc.). It ensures that various certification schemes meet a common set of criteria.

        GMP – Good Manufacturing Practices
        A system for ensuring products are consistently produced and controlled according to quality standards. Applies to food, cosmetics, pharmaceuticals, and supplements.

            NSF GMP Registered
            UL GMP Certification
            NPA GMP Certification (Natural Products Association)
            FDA GMP Compliance (not a certification, but inspection-based)
            USP GMP Compliance (United States Pharmacopeia)

        */


        // Free From Certifications:
        // - @link:  https://www.asifood.com/certified-free-from-certification
        // - Data Source - List of SKUs:  https://cfffoods.org/cff-approved-cpgs/
        // - Because there are multiple certification types, it may be necessary to have a "type" field to abstract searching
        // - Some certifications include more than one food so there may need to be more of a HasMany relation
        // Perhaps we need a 'productType' tag and then the pivot has the source? Or maybe we keep
        // Certifications above and specify a freeFrom column in the pivot...That might make some sense.

        // Product Type Labels:
        // - These are the searchable ones
        // - Certifications will be the informative/listed items, but perhaps only searchable through API, not consumer app?
        // Organic
        // Vegan
        // Kosher
        // Keto
        // Paleo (ugh!)
        // Peanut Free
        // Tree nut Free
        // Milk Free
        // Fish Free
        // Egg Free
        // Sesame Free
        // Shellfish Free
        // Soy Free
        // Wheat Free
        // Gluten Free
        // Pollinator Friendly
        // Pasture Raised / Free Range
        // Fair Trade


        Tag::findOrCreate(['name' => 'Organic', 'slug' => 'organic'], 'productLabel');
        Tag::findOrCreate(['name' => 'Biodynamic', 'slug' => 'biodynamic'], 'productLabel');
        Tag::findOrCreate(['name' => 'Non-GMO', 'slug' => 'non-gmo'], 'productLabel');
        Tag::findOrCreate(['name' => 'Vegan', 'slug' => 'vegan'], 'productLabel');

        // https://ota.com/news-center/conscious-consumption-younger-generations-fueling-growth-organic-industry
        // Regenerative?


        // Product tags - Packaging
        Tag::findOrCreate(['name' => 'Recyclable Packaging', 'slug' => 'recyclable-packaging'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Compostable', 'slug' => 'compostable'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Biodegradable', 'slug' => 'biodegradable'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Plastic-Free', 'slug' => 'plastic-free'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Minimal Packaging', 'slug' => 'minimal-packaging'], 'productPackaging');
        Tag::findOrCreate(['name' => 'Reusable Packaging', 'slug' => 'reusable-packaging'], 'productPackaging');
        // TerraCycle Partnered
        // Reusable / Returnable Packaging

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

        // Equitable Food Initiative (EFI)
        // Worker Welfare Certified
    }
}
