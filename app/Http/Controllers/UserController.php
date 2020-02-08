<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        return view('user.home');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $usuario = new User();
            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->activo = $request->activo;
            $usuario->id_rol = $request->idRol;
            $usuario->save();

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            DB::beginTransaction();
            $usuario = User::findOrFail($request->id);

            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->activo = $request->activo;
            $usuario->id_rol = $request->idRol;
            $usuario->save();
            DB::commit();

        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
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
        //
    }

    public function listUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $usuarios = User::join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id','users.nombre','users.password', 'users.email',
                    'users.activo as estatus' ,'users.id_rol', 'roles.nombre as rol')
                ->orderBy('users.nombre','asc')->paginate(10);
        }else{
            $usuarios = User::join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id','users.nombre','users.password', 'users.email',
                    'users.activo as estatus', 'users.id_rol', 'roles.nombre as rol')
                ->where('users.'.$criterio, 'like', '%'.$buscar.'%')
                ->orderBy('users.nombre','asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'         => $usuarios->total(),
                'current_page'  => $usuarios->currentPage(),
                'per_page'      => $usuarios->perPage(),
                'last_page'     => $usuarios->lastPage(),
                'from'          => $usuarios->firstItem(),
                'to'            => $usuarios->lastItem()
            ],
            'usuarios'    => $usuarios
        ];
    }
}
