<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $rol = new Roles();
            $rol->nombre = $request->nombre;
            $rol->descripcion = $request->descripcion;
            $rol->activo = $request->activo;
            $rol->save();

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
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
            $rol = Roles::findOrFail($request->id);

            $rol->nombre = $request->nombre;
            $rol->descripcion = $request->descripcion;
            $rol->activo = $request->activo;
            $rol->save();
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

    public function selectRol(Request $request)
    {
        $roles = Roles::where('activo', '=', '1')
            ->select('id','nombre')
            ->orderBy('nombre', 'asc')->get();
        return ['roles' => $roles];
    }

    public function listado(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == ''){
            $roles = Roles::select('roles.id','roles.nombre','roles.descripcion', 'roles.activo')
                ->orderBy('roles.nombre','asc')->paginate(10);
        }else{
            $roles = Roles::select('roles.id','roles.nombre','roles.descripcion','roles.activo')
                ->where('roles.'.$criterio, 'like', '%'.$buscar.'%')
                ->orderBy('roles.nombre','asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem()
            ],
            'roles'    => $roles
        ];
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = Roles::findOrFail($request->id);
        $user->activo = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $user = Roles::findOrFail($request->id);
        $user->activo = '1';
        $user->save();
    }
}
