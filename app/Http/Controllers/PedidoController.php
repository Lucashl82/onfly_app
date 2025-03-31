<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Repositories\PedidoRepository;

class PedidoController extends Controller
{
    public function __construct(Pedido $pedido) {
        $this->pedido = $pedido;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $pedidoRepository = new PedidoRepository($this->pedido);

        if($request->has('filtro')) {
            $pedidoRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $pedidoRepository->selectAtributos($request->atributos);
        } 

        return response()->json($pedidoRepository->getResultadoPaginado(3), 200);
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
        $request->validate($this->pedido->rules(), $this->pedido->feedback());

        $pedido = $this->pedido->create([
            'nome' => $request->nome,
            'data_ida' => $request->data_ida,
            'data_volta' => $request->data_volta,
            'destino' => $request->destino,
            'status' => $request->status
        ]);

        return response()->json($pedido, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = $this->pedido->find($id);
        if($pedido === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        } 

        return response()->json($pedido, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedido = $this->pedido->find($id);

        if($pedido === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($pedido->rules() as $input => $regra) {
                
                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas, $pedido->feedback());

        } else {
            $request->validate($pedido->rules(), $pedido->feedback());
        }
        
        //preenchendo o objeto $pedido com todos os dados do request
        $pedido->fill($request->all());

        $pedido->save();
        return response()->json($pedido, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedido = $this->pedido->find($id);

        if($pedido === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        //remove o arquivo antigo
        Storage::disk('public')->delete($pedido->imagem);        

        $pedido->delete();
        return response()->json(['msg' => 'O pedido foi removido com sucesso!'], 200);
        
    }
}
