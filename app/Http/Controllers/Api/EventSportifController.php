<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventSportifRequest;
use App\Http\Resources\EventSportifResource;
use App\Models\EventSportif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EventSportifController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(EventSportif::class, 'eventSportif');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EventSportifResource::collection(EventSportif::paginate(2));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventSportifRequest $request)
    {
         $user=User::find(1);

        DB::beginTransaction();
        try{
            $validated = $request->validated();
            $poster=null;
            $posterURL=null;

            if(($request->file('poster')!==null)&&($request->file('poster')->isValid())){

                $ext=$request->file('poster')->extension();
                $fileName=Str::uuid().'.'.$ext;
                $poster=$request->file('poster')->storeAs('public/images',$fileName);
                $posterURL=env('APP_URL').Storage::url($poster);
            }

            $eventSportif=Auth::user()->eventSportifs()->create([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'posterURL' => $posterURL,
                'dateDebut' => $validated['dateDebut'],
                'dateFin' => $validated['dateFin']
            ]);

        }catch(ValidationException $exception){
            DB::rollBack();
        }

        DB::commit();

        return response(new EventSportifResource($eventSportif), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new EventSportifResource(EventSportif::with('categories')->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventSportifRequest $request, string $id)
    {

        $eventSportif=EventSportif::find($id);

        DB::beginTransaction();
        try{
            $validated = $request->validated();

            $poster=$eventSportif->poster;
            $posterURL=$eventSportif->posterURL;

            if(($request->file('poster')!==null)&&($request->file('poster')->isValid())){

                $ext=$request->file('poster')->extension();
                $fileName=Str::uuid().'.'.$ext;
                $poster=$request->file('poster')->storeAs('public/images',$fileName);
                $urlPoster=env('APP_URL').Storage::url($poster);

                //Supprimer l'ancien poster s'il existe
                DB::afterCommit(function() use($eventSportif){
                    if($eventSportif->poster!=null){
                        Storage::delete($eventSportif->poster);
                    }

                });

            }
            $eventSportifUpdated=Auth::user()->eventSportifs()->where('id',$eventSportif->id)->update([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'posterURL' => $posterURL,
                'dateDebut' => $validated['dateDebut'],
                'dateFin' => $validated['dateFin']
            ]);

        }catch(ValidationException $exception){
            DB::rollback();
        }
        DB::commit();

        return response(new EventSportifResource($eventSportifUpdated),Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $eventSportif=EventSportif::find($id);

        DB::beginTransaction();
        try{
            DB::afterCommit(function() use($eventSportif){

                if($eventSportif->poster!=null){
                    Storage::delete($eventSportif->poster);
                }

            });

            $eventSportif->delete();

        }catch(ValidationException $e){
            DB::rollback();
        }
        DB::commit();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
