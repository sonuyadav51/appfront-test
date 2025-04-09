<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\PriceChangeNotification;

class SendPriceChangeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   
   /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Product $product,
        public float $oldPrice,
        public float $newPrice
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to('admin@example.com')->send(
            new PriceChangeNotification($this->product, $this->oldPrice, $this->newPrice)
        );
    }
}
