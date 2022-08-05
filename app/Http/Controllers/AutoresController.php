<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoresController extends Controller
{
    // GET 'autor'
    public function getAutores()
    {

        $autor = Autor::all();

        return response()->json([
            'status' => 'ok',
            'autores' => $autor
        ]);
    }

    //POST 'libros'
    public function createAutor(Request $request)
    {

        $validated = $request->validate([
            'nombre' => 'required',
            'apellido' => 'required'
        ]);

        $autor = new Autor;
        $autor->nombre = $request->nombre;
        $autor->apellido = $request->apellido;

        $autor->save();

        return response()->json([
            'status' => 'ok',
            'mensaje_ok' => 'Autor guardado exitosamente'
        ]);

        return response()->json([
            'status' => 'error',
            'mensaje_error' => "Ha ocurrido un error"
        ])->setStatusCode(400);
    }
}
