<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Communique as CommuniqueRequest;
use App\Http\Resources\Communique as CommuniqueResource;
use App\Http\Resources\CommuniqueCollection;
use App\Models\Communique;

use Log;

class CommuniqueController extends Controller
{

     /**
     * @var App\Models\Communique
     */
    protected $model;

    public function __construct(Communique $model) {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communiques = new CommuniqueCollection($this->model->paginate());
        return response()->json($communiques);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Communique   $request
     * @param  int  $pet
     * @return \Illuminate\Http\Response
     */
    public function store(CommuniqueRequest $request, $pet)
    {
        try {

            $communique = $this->model->fill($request->all());
            $communique->pets_id = $pet;
            $communique->save();

            return response()->json(new CommuniqueResource($communique), 201);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return response()->json('Erro interno do servidor', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $communique = new CommuniqueResource($this->model->findOrFail($id));
            return response()->json($communique, 200); 
        }  catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json('Erro interno do servidor', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Communique  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommuniqueRequest $request, $id)
    {
        try {

            $communique = $this->model->findOrFail($id);
            $communique->fill($request->all());
            $communique->save();

            return response()->json($communique, 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return response()->json('Erro interno do servidor', 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $communique = $this->model->findOrFail($id);
            $communique->delete();

            return response()->json(204);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json('Erro interno do servidor', 500);
        }
    }
}
