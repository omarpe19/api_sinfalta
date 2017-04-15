<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Jugador;
use DB;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except' => ['create','index']]);

    }
    public function index(Request $request)
    {
        try{
            $email = $request->input('email');
            $clave = $request->input('clave');
            $login=DB::table('jugador as j')
                ->select('email','clave','api_token')
                ->where('email','=',$email)
                //->where('clave','=',$clave)
                ->get();
            $checkPass=Hash::check($clave, $login[0]->clave);
            if ($login and $checkPass){
                return response()->json(['api_token'=>$login[0]->api_token,'success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false]);
        }



    }

    public function show($id)
    {
        return Jugador::findOrFail($id);

    }
    public function create(Request $request)
    {
        try{
            if (Jugador::where('email', '=', Input::get('email'))->count() > 0) {
                return response()->json("si existe");
            }
            $jugador=new Jugador;
            $jugador->id_estatus='1';
            $jugador->clave=Hash::make($request->get('clave'));
            $jugador->email=$request->get('email');
            $jugador->nombre=$request->get('nombre');
            $jugador->sexo=$request->get('sexo');
            $jugador->fecha_nacimiento=$request->get('fecha_nacimiento');
            $jugador->api_token=str_random(64);
            $jugador->save();
            return response()->json(['api_token'=>$jugador->api_token,'success'=>true]);
        }catch(QueryException $ex){ 
            ($ex->getMessage());
          return response()->json(['success'=>false]);
        }
       
    }
}
