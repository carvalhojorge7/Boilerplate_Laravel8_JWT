<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($user->password);

            $user->save();

            return response()->json($user, 201);
        } catch (\Exception $e) {

            report($e);
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            return response()->json($user);
        } catch (Exception $e) {
            report($e);
            return response()->json(['mensagem' => 'Registro Não Encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['mensagem' => 'Registro Não Encontrado'], 404);
            }

            $user->fill($request->except('password'));

            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }

            $user->save();


            return response()->json($user);
        } catch (\Exception $e) {

            return response()->json(['error' => $e]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['mensagem' => 'Registro Não Encontrado'], 404);
            }
            $user->delete();

            return response()->json($user, 204);
        } catch (\Exception $e) {

            return response()->json(['error' => $e]);
        }
    }
}
