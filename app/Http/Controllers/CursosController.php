<?php
namespace App\Http\Controllers;

use App\Models\Cursos;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CursosController extends Controller
{
    public function index()
    {
        return Cursos::where('status', 1)->get();
    }

    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            'nombre' => 'required',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $curso = new Cursos();
            $curso->nombre = $request->nombre;
            $curso->docente_id = $request->docente_id;
            $curso->save();

            return response()->json(['message' => 'Curso creado correctamente'], 201);
        } catch (QueryException $e) {
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

    public function show($id)
    {
        try {
            $curso = Cursos::findOrFail($id);
            return response()->json($curso);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El curso ' . $id.' no existe no fue encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nombre' => 'required',
            'docente_id' => 'required|exists:docentes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $curso = Cursos::findOrFail($id);
            $curso->nombre = $request->nombre;
            $curso->docente_id = $request->docente_id;
            $curso->save();

            return response()->json(['message' => 'Curso actualizado correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El curso ' . $id.' no existe no fue encontrado'], 404);
        } catch (QueryException $e) {
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
            $curso = Cursos::findOrFail($id);
            if($curso->status){
                $curso->status = 0; 
                $curso->save();
                return response()->json(['msj' => 'Curso eliminado correctamente'], 200);
            }
            return response()->json(['msj' => 'Este Curso ya habia sido eliminado'], 200);
           
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El Curso ' . $id.' no existe no fue encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la acción realizada'], 500);
        }
    }

}
