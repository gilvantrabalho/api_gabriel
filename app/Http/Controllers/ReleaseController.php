<?php

namespace App\Http\Controllers;

use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReleaseController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'releases' => Release::all(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $credentials = $request->only('user_id', 'transaction_id', 'operation_type');
            $validator = Validator::make($credentials, [
                'user_id' => 'required',
                'transaction_id' => 'required',
                'operation_type' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }

            $release = new Release([
                'user_id' => $request->user_id,
                'transaction_id' => $request->transaction_id,
                'operation_type' => $request->operation_type,
                'created_at' => date('Y-m-d: H:i:s')
            ]);
            $release->save();

            if (!$release) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro ao tentar cadastrar novo lançamento!'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Lançamento cadastrado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
