<?php

namespace App\Http\Controllers;

use App\Models\EventSportif;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $eventSprotifs=EventSportif::all();
        $data=[
            'title' => 'Evènements Sportifs',
            'description' => 'Liste des évènements sportifs',
            'heading' => config('app.name'),
            'eventSportifs' => $eventSprotifs
        ];

        return view('home.index',$data);
    }
}
