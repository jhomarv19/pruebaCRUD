<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    // Obtener todos los productos de la base de datos con select
    public function index(): JsonResponse
    {
        try {
            // Query select
            $products = DB::select('SELECT * FROM products');
            return response()->json(['status' => 200, 'data' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 100, 'error' => $e->getMessage()], 500);
        }
    }

    // Obtener todos los productos de la base de datos con select con id
    public function show($id): JsonResponse
    {
        try {
            // Query select
            $product = DB::select('SELECT * FROM products WHERE id = ?', [$id]);

            if (empty($product)) {
                return response()->json(['status' => 100, 'error' => 'Product not found'], 404);
            }

            return response()->json(['status' => 200, 'data' => $product[0]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 100, 'error' => $e->getMessage()], 500);
        }
    }

    // Insertar un nuevo producto en la base de datos con insert
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        try {
            // Query insert
            DB::insert("
                INSERT INTO products (name, price, description, created_at, updated_at)
                VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
            ", [
                $request->name,
                $request->price,
                $request->description
            ]);

            $id = DB::getPdo()->lastInsertId();

            return response()->json([
                'status' => 200,
                'message' => 'Producto creado correctamente',
                'id' => $id
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 100,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Actualizar un producto existente en la base de datos con update
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'description' => 'nullable|string',
            'stock' => 'sometimes|integer'
        ]);

        try {
            $data = [];
            if ($request->has('name')) $data[] = $request->name;
            if ($request->has('price')) $data[] = $request->price;
            if ($request->has('description')) $data[] = $request->description;
            if ($request->has('stock')) $data[] = $request->stock;

            if (empty($data)) {
                return response()->json(['status' => 100, 'error' => 'No fields to update'], 400);
            }

            $fieldsQuery = '';
            if ($request->has('name')) $fieldsQuery .= 'name = ?, ';
            if ($request->has('price')) $fieldsQuery .= 'price = ?, ';
            if ($request->has('description')) $fieldsQuery .= 'description = ?, ';
            if ($request->has('stock')) $fieldsQuery .= 'stock = ?, ';

            $fieldsQuery .= 'updated_at = ? WHERE id = ?';
            $data[] = now();
            $data[] = $id;

            $query = "UPDATE products SET $fieldsQuery";
            // Query update
            $affected = DB::update($query, $data);

            if ($affected === 0) {
                return response()->json(['status' => 100, 'error' => 'Product not found or not updated'], 404);
            }

            return response()->json(['status' => 200, 'message' => 'Producto actualizado'], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 100, 'error' => $e->getMessage()], 500);
        }
    }

    // Eliminar un producto existente en la base de datos con delete
    public function destroy($id): JsonResponse
    {
        try {
            // Query delete
            $deleted = DB::delete('DELETE FROM products WHERE id = ?', [$id]);
            if ($deleted === 0) {
                return response()->json(['status' => 100, 'error' => 'Product not found'], 404);
            }
            return response()->json(['status' => 200, 'message' => 'Producto eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 100, 'error' => $e->getMessage()], 500);
        }
    }
}
