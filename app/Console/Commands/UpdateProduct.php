<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendPriceChangeNotification;
use Illuminate\Support\Facades\Log;
use App\Services\ProductService;

class UpdateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:update {id} {--name=} {--description=} {--price=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a product with the specified details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected ProductService $productService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
  
    public function handle(): int
    {
        $id = $this->argument('id');
        $product = Product::find($id);

        if (!$product) {
            $this->error("Product not found.");
            return 1;
        }

        $data = array_filter([
            'name' => $this->option('name'),
            'description' => $this->option('description'),
            'price' => $this->option('price'),
        ], fn ($value) => !is_null($value));

        if (isset($data['name']) && strlen(trim($data['name'])) < 3) {
            $this->error("Name must be at least 3 characters long.");
            return 1;
        }

        if (empty($data)) {
            $this->info("No changes provided. Product remains unchanged.");
            return 0;
        }
        $this->productService->updateProduct($product, $data);

        $this->info("Product updated successfully.");
        return 0;
    }
}
