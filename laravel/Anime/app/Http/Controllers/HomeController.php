<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show\Show;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $shows = Show::select()->orderBy('id', 'desc')->take(4)->get();

        $trendingShows = Show::select()->orderBy('name', 'desc')->take(6)
         ->get();


        $adventureShows = Show::select()->orderBy('id', 'desc')->take(6)
         ->where('genere','adventure')->get(); 


        $recentShows = Show::select()->orderBy('id', 'desc')->take(6)->get();
 
        $liveShows = Show::select()->orderBy('id', 'desc')->take(6)
        ->where('genere','action')->get(); 


        $forYouShows = Show::select()->orderBy('name', 'desc')->take(4)->get();



        return view('home', compact('shows', 'trendingShows', 'adventureShows', 'recentShows', 'liveShows', 'forYouShows'));
    }
}
