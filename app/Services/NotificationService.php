<?php

namespace App\Services;

use App\Jobs\SendPriceChangeNotification;
use App\Models\Product;

class NotificationService
{
     public function sendPriceChangeNotification(Product $product, $oldPrice, $newPrice, $email): void
    {
        SendPriceChangeNotification::dispatch($product, $oldPrice, $newPrice,$email);
    }
}
