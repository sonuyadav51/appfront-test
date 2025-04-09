<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\NotificationService;;


class ProductService
{
    /**
     * Create a new class instance.
     */
   public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function updateProduct(Product $product, array $data,string $email = 'admin@example.com'): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $oldPrice = $product->price;
            $product->update($data);

            if (isset($data['price']) && $oldPrice != $product->price) {
                try {
                    $this->notificationService->sendPriceChangeNotification(
                        $product,
                        $oldPrice,
                        $product->price,
                        $email
                    );
                } catch (\Exception $e) {
                    Log::error('Notification failed: ' . $e->getMessage());
                }
            }

            return $product;
        });
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
    }
}
