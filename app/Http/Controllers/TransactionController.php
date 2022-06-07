<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->only('user_id', 'type', 'description', 'value');

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'type' => 'string|required',
            'description' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'erros' => $validator->errors()
            ]);
        }

        $newTransaction = new Transaction([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'description' => $request->description,
            'value' => $request->value,
            'status' => true,
            'created_at' => date('Y-m-d H:i:d'),
            'updated_at' => date('Y-m-d H:i:d')
        ]);
        $newTransaction->save();

        if (!$newTransaction) {
            return response()->json([
                'status' => false,
                'message' => 'Transação não cadastrada!'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transação cadastrada com sucesso!',
            'transaction' => $newTransaction
        ]);
    }

    public function show(int $user_id)
    {
        return response()->json([
            'transactions' => Transaction::where('user_id', $user_id)
                ->where('status', true)->get()
        ]);
    }

    public function update(Request $request, int $id)
    {
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Informe o id'
            ]);
        }

        $data = $request->only('type', 'description', 'value');

        $validator = Validator::make($data, [
            'type' => 'string|required',
            'description' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'erros' => $validator->errors()
            ]);
        }

        $update = Transaction::where('id', $id)
            ->update([
                'type' => $request->type,
                'description' => $request->description,
                'value' => $request->value,
                'updated_at' => date('Y-m-d H:i:d')
            ]);

        if (!$update) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao atualizar dado'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transação editada com sucesso!'
        ]);
    }

    public function getById(int $id)
    {
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Informe o id'
            ]);
        }

        return response()->json([
            'status' => true,
            'transaction' => Transaction::where('id', $id)->first()
        ]);
    }

    //  Destroy
    public function updateStatus(int $id)
    {
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'Informe o id'
            ]);
        }

        $statusDestroy = Transaction::where('id', $id)
            ->update(['status' => false]);

        if (!$statusDestroy) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao tentar mudar o status da transação!'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transação desativada com sucesso!'
        ]);
    }
}
