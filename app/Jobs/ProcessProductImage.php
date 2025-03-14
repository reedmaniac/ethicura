<?php

namespace App\Jobs;

use App\Models\ProductImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProcessProductImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'image-processing';

    /**
     * The product image model instance.
     *
     * @var ProductImage
     */
    protected $productImage;

    /**
     * The base storage path for product images.
     *
     * @var string
     */
    private const PRODUCT_STORAGE_PATH = 'app/public/product_images/';

    /**
     * Create a new job instance.
     */
    public function __construct(ProductImage $productImage)
    {
        $this->productImage = $productImage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imagePath = storage_path(self::PRODUCT_STORAGE_PATH . $this->productImage->path);
        $sizes = ['thumbnail' => 150, 'medium' => 500, 'large' => 1000];
        $orientation = $this->productImage->type;

        foreach ($sizes as $sizeName => $size) {
            $resizedImage = Image::make($imagePath)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Save JPG version
            $resizedPath = "product_images/{$orientation}/{$sizeName}/" . $this->productImage->uuid . '.jpg';
            Storage::disk('public')->put($resizedPath, (string) $resizedImage->encode());

            // Save WebP version
            $webpPath = "product_images/{$orientation}/{$sizeName}/" . $this->productImage->uuid . '.webp';
            Storage::disk('public')->put($webpPath, (string) $resizedImage->encode('webp'));
        }
    }
}
