<?php

namespace App\Http\Controllers;

use App\Enums\ProductCategory;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        #echo json_encode($request->all());
        #exit;
        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' =>'required|string|max:300',
            'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|min:1|max:9999',
            'category' =>'required|string|in:' . implode(',', ProductCategory::values()),
        ]);

        // Criando um novo produto
        $produto = Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => ProductCategory::getCategory($request->category)->value,
        ]);

        return response()->json([
            'message' => 'Produto cadastrado com sucesso!',
            'produto' => $produto
        ], 201);
    }

    public function show(string $id){
        #echo $id;
        return Products::find($id);
    }

    public function search(Request $request){
        try {
            $perPage = $request->query('per_page',15);
            $perPage = min(max($perPage, 1), 100);

            $query= Products::query();
            
            if ($request->has('name')){
                $query->where('name', 'like', '%' . $request->query('name') . '%');
            }

            if ($request->has('category')){
                $query->where('category', $request->query('category'));
            }

            if ($request->has('min_price')){
                $query->where('price', '>=', $request->query('min_price'));
            }

            if ($request->has('max_price')){
                $query->where('price', '<=', $request->query('max_price'));
            }

            $sortBy = $request->query('sort_by','name');
            $sortOrder = $request->query('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);

            $produtos = $query->paginate($perPage);

            return response()->json([
                'message' =>'Produtos recuperados com successo',
                'produtos' => $produtos
            ],200);
        } catch (\Exception $e){
            return response()->json([
                'message' => 'Erro ao recuperar produtos',
                'error' => $e ->getMessage()
            ], 500);
        }
        }
    }

