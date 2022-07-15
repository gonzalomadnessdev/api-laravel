<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libros;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LibrosController extends Controller
{
    public $mensaje_error = "Ha ocurrido un error";
    public $dirDestinoImg = './img/';

    // GET 'libros'
    public function getLibroS()
    {

        $libros = Libros::all();

        return response()->json([
            'status' => 'ok',
            'libros' => $libros
        ]);
    }

    //GET 'libros/{id}'
    public function getLibro($id)
    {

        $libros = new Libros;
        $libro = $libros->find($id);

        return response()->json([
            'status' => 'ok',
            'libro' => $libro
        ]);
    }

    //POST 'libros'
    public function createLibro(Request $request)
    {

        if ($request->hasFile('imagen') && $request->titulo) {

            Log::debug('paso la validacion');

            $imagen = $request->file('imagen');
            $nuevoNombreArchivo = $this->manejoDeImagen($imagen);

            $libro = new Libros;
            $libro->titulo = $request->titulo;
            $libro->imagen = ltrim($this->dirDestinoImg, '.') . $nuevoNombreArchivo;

            $libro->save();

            return response()->json([
                'status' => 'ok',
                'mensaje_ok' => 'Libro guardado exitosamente'
            ]);
        }

        Log::error('NO paso la validacion');
        return response('', 400)->json([
            'status' => 'error',
            'mensaje_error' => $this->mensaje_error
        ])->setStatusCode(400);
    }

    //DELETE 'libros/{id}'
    public function removeLibro($id)
    {

        $libro = Libros::find($id);

        if ($libro) {

            $dirImg = base_path('public') . $libro->imagen;

            if (file_exists($dirImg)) {
                unlink($dirImg);
            }

            $libro->delete();

            return response()->json([
                'status' => 'ok',
                'mensaje_ok' => 'Libro borrado exitosamente'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'mensaje_error' => $this->mensaje_error
        ])->setStatusCode(400);
    }

    //PUT 'libros/{id}'
    public function updateLibro(Request $request, $id)
    {

        $libro = Libros::find($id);

        if ($request->hasFile('imagen') && $request->titulo && $libro) {

            //Borro la imagen jpg
            $dirImg = base_path('public') . $libro->imagen;
            if (file_exists($dirImg)) {
                unlink($dirImg);
            }

            $imagen = $request->file('imagen');
            $nuevoNombreArchivo = $this->manejoDeImagen($imagen);

            $libro->titulo = $request->titulo;
            $libro->imagen = ltrim($this->dirDestinoImg, '.') . $nuevoNombreArchivo;

            $libro->save();

            return response()->json([
                'status' => 'ok',
                'mensaje_ok' => 'Libro actualizado exitosamente'
            ]);

        }

        return response('', 400)->json([
            'status' => 'error',
            'mensaje_error' => $this->mensaje_error
        ])->setStatusCode(400);

    }

    //Manejo de imagenes
    private function manejoDeImagen($imagen){

        //Renombrar con timestamp
        $nombreArchivo = $imagen->getClientOriginalName();
        $nuevoNombreArchivo = Carbon::now()->timestamp . '_' . $nombreArchivo;

        //Mover a carpeta
        $imagen->move($this->dirDestinoImg, $nuevoNombreArchivo);

        //devuelve el nombre
        return $nuevoNombreArchivo;
    }

}


