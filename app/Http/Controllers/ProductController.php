<?php

namespace App\Http\Controllers;

use App\Enums\ProductCategory;
use App\Models\Products;
use App\Http\Services\ProductService;
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

    public function search(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 15);
            $perPage = min(max($perPage, 1), 100);

            $query = Products::query();
            $service = new ProductService($request);
            $filteredQuery = $service->apply($query);
            
            $produtos = $filteredQuery->paginate($perPage);

            return response()->json([
                'message' => 'Produtos recuperados com sucesso',
                'produtos' => $produtos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao recuperar produtos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $produto = Products::findOrFail($id);
            $produto->delete();

            return response()->json([
                'message' => 'Produto deletado com sucesso!'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Produto não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar produto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            // Busca o produto pelo ID
            $produto = Products::findOrFail($id);

            // Validação dos dados recebidos
            $request->validate([
                'name' => 'string|max:255|unique:products,name,' . $id,
                'description' => 'string|max:300',
                'price' => 'numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
                'stock' => 'integer|min:1|max:9999',
                'category' => 'string|in:' . implode(',', ProductCategory::values()),
            ]);

            // Atualiza o produto
            $produto->update([
                'name' => $request->name ?? $produto->name,
                'description' => $request->description ?? $produto->description,
                'price' => $request->price ?? $produto->price,
                'stock' => $request->stock ?? $produto->stock,
                'category' => $request->category ? ProductCategory::getCategory($request->category)->value : $produto->category,
            ]);

            return response()->json([
                'message' => 'Produto atualizado com sucesso!',
                'produto' => $produto
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Produto não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar produto',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

