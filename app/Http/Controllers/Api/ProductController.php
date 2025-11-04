<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort by price
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category')->where('is_active', true)->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function featured(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc');

        $perPage = $request->get('per_page', 20);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function adminIndex(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort by price
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(25);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function store(Request $request)
    {
        // Get data from request - using input() works better with multipart/form-data
        $inputData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'sale_price' => $request->input('sale_price'),
            'sku' => $request->input('sku'),
            'stock_quantity' => $request->input('stock_quantity'),
            'category_id' => $request->input('category_id'),
            'is_featured' => $request->input('is_featured'),
            'is_active' => $request->input('is_active'),
        ];

        $validator = Validator::make($inputData, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $inputData;
        
        // Convert string booleans to actual booleans
        $data['is_featured'] = filter_var($data['is_featured'], FILTER_VALIDATE_BOOLEAN) || $data['is_featured'] === '1' || $data['is_featured'] === 1;
        $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) || $data['is_active'] === '1' || $data['is_active'] === 1;
        
        // Generate slug from name
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = '/images/' . $imageName;
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product->load('category'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        // Get data from request - using input() works better with multipart/form-data
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'sale_price' => $request->input('sale_price'),
            'sku' => $request->input('sku'),
            'stock_quantity' => $request->input('stock_quantity'),
            'category_id' => $request->input('category_id'),
            'is_featured' => $request->input('is_featured'),
            'is_active' => $request->input('is_active'),
        ];

       

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Convert string booleans to actual booleans
        $data['is_featured'] = filter_var($data['is_featured'], FILTER_VALIDATE_BOOLEAN) || $data['is_featured'] === '1' || $data['is_featured'] === 1;
        $data['is_active'] = filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) || $data['is_active'] === '1' || $data['is_active'] === 1;
        
        // Generate slug from name if name changed
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        
        // Handle image upload or keep existing image
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = '/images/' . $imageName;
        } elseif ($request->has('current_image')) {
            // Keep existing image when editing without uploading new one
            $data['image'] = $request->input('current_image');
        }
        // If no new image is uploaded and no current_image is provided,
        // we don't include 'image' in $data, which keeps the existing image in the database

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product->load('category'),
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}