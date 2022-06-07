<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $credentials = $request->only('username', 'password');
            $validator = Validator::make($credentials, [
                'username' => 'string|required',
                'password' => 'string|required',
            ], [
                'username.required' => 'username é um campo obrigatório!',
                'password.required' => 'Senha é um campo obrigatório',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }

            $user = new User([
                'username' => $request->username,
                'password' => md5($request->password),
                'status' => true
            ]);
            $user->save();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro ao tentar cadastrar novo usuário!'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function search(string $username, string $password)
    {
        if (!$username && !$password) {
            return response()->json([
                'status' => false,
                'message' => 'Informe todos os dados!'
            ]);
        }

        $user = User::where('username', $username)
            ->where('password', md5($password))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhum usuário foi encontrado!'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Usuário encontrado!',
            'user' => $user
        ]);
    }

    public function update(Request $request, int $id)
    {
        try {
            $credentials = $request->only('username', 'status');
            $validator = Validator::make($credentials, [
                'username' => 'string|required',
                'status' => 'required'
            ], [
                'username.required' => 'username é um campo obrigatório!',
                'status.required' => 'Status é um campo obrigatório'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }

            $updateUser = User::where('id', $id)
                ->update([
                    'username' => $request->username,
                    'status' => $request->status
                ]);

            if (!$updateUser) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erro ao tentar editar o usuário!'
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Usuário editado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
