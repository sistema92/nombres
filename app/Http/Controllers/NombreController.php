<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nombre;
class NombreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if($request->ajax()){
            $datos=Nombre::orderBy('id','DESC')->paginate(2);
            return response()->json($datos);
        }

    }

    public function buscar(Request $request){
        //FILTROS
            if($request->ajax()){
                $nombre=$request->get('nombre');
                $datos=Nombre::where('nombre','like',"%$nombre%")->paginate(5);
                return response()->json($datos);
            }

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

        $datos=new Nombre();
        $datos->nombre=$request->nombre;
        $datos->apellido=$request->apellido;
        $datos->edad=$request->edad;
        $datos->save();

        return;
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
    public function update(Request $request,$id)
    {
        //
        $datos=Nombre::find($id);
        $datos->nombre=$request->nombre;
        $datos->apellido=$request->apellido;
        $datos->edad=$request->edad;
        $datos->save();
        return $datos;

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
        $datos=Nombre::find($id);
        $datos->delete();
    }
}
