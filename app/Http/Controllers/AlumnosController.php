<?php

namespace App\Http\Controllers;

use App\Models\Alumnos;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AlumnosController extends Controller
{
    public function Error_SQL(QueryException $e) {
        $errorCode = $e->getCode();
        $errorMessage = $e->getMessage();
    
        switch ($errorCode) {
            case 23000:
                if (preg_match("/Duplicate entry '(.*?)' for key/", $errorMessage, $matches)) {
                    return "Error: Entrada duplicada de dato: " . $matches[1];
                }
                return "Error: Entrada duplicada de dato";
            default:
                return "Error en la acción realizada";
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Alumnos::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $alumno = new Alumnos();
            $alumno->nombre = $request->nombre;
            $alumno->apellido = $request->apellido;
            $alumno->email = $request->email;
            $alumno->save();
    
            return "Registro ".$request->nombre." añadido satisfactoriamente";
        } catch (QueryException  $e) {
            $errorMessage = $e->getMessage();

            if (strpos($errorMessage, 'Duplicate entry') !== false) {
                preg_match("/Duplicate entry '(.*?)' for key/", $errorMessage, $matches);
                $duplicateValue = $matches[1] ?? 'valor_desconocido';
    
                return response()->json(['error' =>'Error: '. $duplicateValue.' ya esta en uso'], 422);
            }
    
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }
 
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumnos $alumnos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumnos $alumnos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumnos $alumnos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumnos $alumnos)
    {
        //
    }
       
    
}
