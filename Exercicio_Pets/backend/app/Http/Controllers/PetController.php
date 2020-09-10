<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Pet as PetRequest;
use App\Http\Resources\Pet as PetResource;
use App\Http\Resources\PetCollection;
use App\Models\Pet;

use Log;

class PetController extends Controller
{

     /**
     * @var App\Models\Pet
     */
    protected $model;

    public function __construct(Pet $model) {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = new PetCollection($this->model->paginate());
        return response()->json($pets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Pet   $request
     * @return \Illuminate\Http\Response
     */
    public function store(PetRequest $request)
    {
        try {

            // $user = $request->user();
            $userId = $request->user_id;
            $pet = $this->model->fill($request->all());
            $pet->status = $pet->status ? $pet->status : 'lost';
            $pet->pet_owners_id = $userId;
            // $pet->photo = $this->uploadPhoto($request);
            $pet->photo = "";

            $pet->save();

            return response()->json(new PetResource($pet), 201);

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
            $pet = new PetResource($this->model->findOrFail($id));
            return response()->json($pet, 200); 
        }  catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json('Erro interno do servidor', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Pet  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PetRequest $request, $id)
    {
        try {

            $pet = $this->model->findOrFail($id);
            $pet->fill($request->all());
            $pet->save();

            return response()->json($pet, 200);

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
            $pet = $this->model->findOrFail($id);
            $pet->delete();

            return response()->json(204);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json('Erro interno do servidor', 500);
        }
    }

    /**
     * Upload field Photo
     * 
     * @param  \App\Http\Requests\Pet  $request
     * @return string $path
     */
    private function uploadPhoto(Request $request) {
        $fileName = time().'.'.$request->photo->extension();  
        $request->photo->move(public_path('uploads'), $fileName);
        $path = "uploads/{$fileName}";

        return $path;
    }
}
