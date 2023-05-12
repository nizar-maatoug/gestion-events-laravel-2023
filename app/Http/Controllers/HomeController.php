<?php

namespace App\Http\Controllers;

use App\Models\EventSportif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       // Auth::logout();
        //Auth::login(User::first());
        $eventSprotifs=EventSportif::paginate(2);
        $data=[
            'title' => 'Evènements Sportifs',
            'description' => 'Liste des évènements sportifs',
            'heading' => config('app.name'),
            'eventSportifs' => $eventSprotifs
        ];

        return view('home.index',$data);
    }
}
