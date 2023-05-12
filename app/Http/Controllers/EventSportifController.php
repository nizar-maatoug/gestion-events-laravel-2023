<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSportifRequest;
use App\Models\EventSportif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EventSportifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventSportifs=auth()->user()->eventSportifs()->paginate();
        $data=[
            'title' => $description="Mes évènements sportifs",
            'description' => $description,
            'eventSportifs' => $eventSportifs,

            'heading' => $description
        ];
        return view('events.mes-events',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data=[
            'title' => $description="ajouter nouvel evenement",
            'description' => $description,

            'heading' => $description
        ];
        return view('events.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventSportifRequest $request)
    {

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

            Auth::user()->eventSportifs()->create([
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

        return redirect()->route('eventSportifs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventSportif $eventSportif)
    {
        $data=[
            'title' => 'Evènnement sportif: '.$eventSportif->nom,
            'description' => 'Détails event: '.$eventSportif->nom,
            'heading' => config('app.name'),
            'eventSportif' => $eventSportif
        ];
        return view('events.details-event', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventSportif $eventSportif)
    {
        abort_if(auth()->user()->id !== $eventSportif->organisateur->id,403 );

        $data=[
            'title' => $description="Editer évenement Sportif ".$eventSportif->nom,
            'description' => $description,
            'heading' => $description,
            'eventSportif' =>$eventSportif
        ];
        return view('events.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventSportifRequest $request, EventSportif $eventSportif)
    {
        abort_if($eventSportif->organisateur->id !== auth()->id(),403);

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
            Auth::user()->eventSportifs()->where('id',$eventSportif->id)->update([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'posterURL' => $urlPoster,
                'dateDebut' => $validated['dateDebut'],
                'dateFin' => $validated['dateFin']
            ]);

        }catch(ValidationException $exception){
            DB::rollback();
        }
        DB::commit();

        return redirect()->route('eventSportifs.show',[$eventSportif]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventSportif $eventSportif)
    {
        abort_if($eventSportif->organisateur->id !== auth()->id(),403);

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

        return redirect()->route('eventSportifs.index');
    }
}
