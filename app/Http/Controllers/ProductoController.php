<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::paginate();

        return view('producto.index', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }

    public function fotos()
    {
        $productos = Producto::paginate();

        return view('producto.fotos', compact('productos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
        
    }
    public function mostrarFoto(string $ruta)
    {
        $file = Storage::disk('fotos')->get($ruta);
        return Image::make($file)->response();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        $categorias= Categoria::pluck('nombre','id');
        return view('producto.create', compact('producto','categorias'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $id = $request->categoria_id;
            $image      = $request->file('imagen');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('fotos')->put('/' . $fileName, file_get_contents($image));
            $producto = new Producto;
            $producto->categoria_id = $id;
            $producto->nombre = $request->nombre;
            $producto->imagen = $fileName;
            $producto->caracteriticas = $request->caracteriticas;
            $producto->precio = $request->precio;
            $producto->save();
            return redirect()->route('productos.index')
            ->with('success', 'Producto created successfully.');
        }
       

        /*request()->validate(Producto::$rules);

        $producto = Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto created successfully.'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $categorias= Categoria::pluck('nombre','id');
        return view('producto.edit', compact('producto','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        request()->validate(Producto::$rules);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $producto = Producto::find($id)->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
