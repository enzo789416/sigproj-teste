<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate as FacadesGate;

class UserController extends Controller //a ideia daqui é poder ter administração dos usuarios cadastrados no sistema assim controlando melhor quem faz o que
{                                       //por mais que nao tenha sido pedido no teste achei legal colocar
    public function __construct()       //alem disso este gerenciamento de usuarios é um projeto base que tenho onde uso todos para os projetos que faço
    {
        $this->middleware('auth'); //usuario tem que estar logado para acessar estas funcoes
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); //pega todos os usuarios e manda pra pagina inicial pra listar
        return view('admin.user.index')->with('users', $users);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function edit(User $user)
    {
        if (FacadesGate::denies('edit-users')) {
            return redirect(route('admin.user.index')); //editar usuario colocando funcoes novas ou retirando
        }
        $roles = Role::all();
        return view('admin.user.edit')->with(
            [
                'user' => $user,
                'roles' => $roles
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->route('admin.user.index')->with('success', $user->name . ' has updated successfully!'); //atualiza usuarios
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) //deletar alguma funcao ou usuario
    {
        if (FacadesGate::denies('delete-users')) {
            return redirect(route('admin.user.index'));
        }
        $user->roles()->detach();
        $user->delete();
        return redirect()->route('admin.user.index')->with('error', $user->name . ' has deleted successfully');
    }
}
