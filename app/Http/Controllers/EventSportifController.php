<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSportifRequest;
use App\Models\EventSportif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
            $urlPoster=null;

            if(($request->file('poster')!==null)&&($request->file('poster')->isValid())){

                $ext=$request->file('poster')->extension();
                $fileName=Str::uuid().'.'.$ext;
                $poster=$request->file('poster')->storeAs('public/images',$fileName);
                $urlPoster=env('APP_URL').Storage::url($poster);
            }

            Auth::user()->eventSportifs()->create([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'urlPoster' => $urlPoster,
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventSportif $eventSportif)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventSportif $eventSportif)
    {
        //
    }
}
