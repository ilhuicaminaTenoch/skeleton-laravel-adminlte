<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
            $proveedor = User::join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id','users.nombre','users.password',
                    'users.activo', 'users.id_rol', 'roles.nombre as rol')
                ->orderBy('users.nombre','asc')->paginate(3);
        }else{
            $proveedor = User::join('roles', 'users.id_rol', '=', 'roles.id')
                ->select('users.id','users.nombre','users.password',
                    'users.activo', 'users.id_rol', 'roles.nombre as rol')
                ->where('users.'.$criterio, 'like', '%'.$buscar.'%')
                ->orderBy('users.nombre','asc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'         => $proveedor->total(),
                'current_page'  => $proveedor->currentPage(),
                'per_page'      => $proveedor->perPage(),
                'last_page'     => $proveedor->lastPage(),
                'from'          => $proveedor->firstItem(),
                'to'            => $proveedor->lastItem()
            ],
            'personas'    => $proveedor
        ];
    }
}
