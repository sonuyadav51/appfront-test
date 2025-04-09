<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Log;;
use App\Services\ProductService;
use App\Services\FileUploadService;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;

class AdminController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected FileUploadService $fileUploadService
    ) {}

    public function loginPage()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->except('_token'))) {
            return redirect()->route('admin.products');
        }

        return redirect()->back()->with('error', 'Invalid login credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit_product', compact('product'));
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $updated = $this->productService->updateProduct($product, $request->only(['name', 'description', 'price']));

        if ($request->hasFile('image')) {
            $path = $this->fileUploadService->upload($request->file('image'));
            $updated->image = $path;
            $updated->save();
        }

        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->productService->deleteProduct($product);
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    public function addProductForm()
    {
        return view('admin.add_product');
    }

    public function addProduct(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->only(['name', 'description', 'price']));

        if ($request->hasFile('image')) {
            $path = $this->fileUploadService->upload($request->file('image'));
            $product->image = $path;
        } else {
            $product->image = 'product-placeholder.jpg';
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product added successfully');
    }
}