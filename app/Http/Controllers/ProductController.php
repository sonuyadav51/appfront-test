<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $exchangeRate = $this->getExchangeRate();

        return view('products.list', compact('products', 'exchangeRate'));
    }

    public function show(Request $request)
    {
        $id = $request->route('product_id');
        $product = Product::find($id);
        $exchangeRate = $this->getExchangeRate();

        return view('products.show', compact('product', 'exchangeRate'));
    }

    /**
     * @return float
     */
    private function getExchangeRate(): float
    {
        try {
            $response = Http::timeout(5)->get('https://open.er-api.com/v6/latest/USD');

            if ($response->successful()) {
                $data = $response->json();
                return $data['rates']['EUR'] ?? config('app.exchange_rate');
            }
        } catch (\Exception $e) {
           \Log::error('Exchange rate fetch failed: ' . $e->getMessage());
        }

        return config('app.exchange_rate');
    }
}