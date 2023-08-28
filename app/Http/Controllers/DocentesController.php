<?php

namespace App\Http\Controllers;

use App\Models\Docentes;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DocentesController extends Controller
{
  
    public function index()
    {
        return Docentes::where('status', 1)->get();
    }

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
            $alumno = new Docentes();
            $alumno->nombre = $request->nombre;
            $alumno->apellido = $request->apellido;
            $alumno->email = $request->email;
            $alumno->save();
    
            return "Registro ".$request->nombre." añadido satisfactoriamente";
        } catch (QueryException  $e) {
            $errormsj = $e->getMessage();

            if (strpos($errormsj, 'Duplicate entry') !== false) {
                preg_match("/Duplicate entry '(.*?)' for key/", $errormsj, $matches);
                $duplicateValue = $matches[1] ?? 'Tienes un valor que';
    
                return response()->json(['error' =>'Error: '. $duplicateValue.' ya esta en uso'], 422);
            }
    
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }
 
    public function show($id)
    {
        try {
            $alumno = Docentes::findOrFail($id);
            return response()->json($alumno);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El alumno ' . $id.' no existe no fue encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'status' => 'required|boolean',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $alumno = Docentes::findOrFail($id);
            $alumno->nombre = $request->nombre;
            $alumno->apellido = $request->apellido;
            $alumno->email = $request->email;
            $alumno->status = $request->status;; 
            $alumno->save();
    
            return response()->json(['msj' => 'Alumno actualizado correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El alumno ' . $id.' no existe no fue encontrado'], 404);
        } catch (QueryException  $e) {
            $errormsj = $e->getMessage();

            if (strpos($errormsj, 'Duplicate entry') !== false) {
                preg_match("/Duplicate entry '(.*?)' for key/", $errormsj, $matches);
                $duplicateValue = $matches[1] ?? 'Tienes un valor que';
    
                return response()->json(['error' =>'Error: '. $duplicateValue.' ya esta en uso'], 422);
            }
    
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $alumno = Docentes::findOrFail($id);
            $alumno->status = 0; 
            $alumno->save();
            return response()->json(['msj' => 'Alumno eliminado correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El alumno ' . $id.' no existe no fue encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }
       
    
}
