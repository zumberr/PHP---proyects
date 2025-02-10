<?php

namespace App\Http\Controllers\Anime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Show\Show;
use App\Models\Comment\Comment;
use App\Models\Following\Following;
use App\Models\View\View;
use App\Models\Episode\Episode;

use Auth;
use Redirect;

class AnimeController extends Controller
{
    


    public function animeDetails($id) {

        $show = Show::find($id);

        $randomShows = Show::select()->orderBy('id', 'desc')->take('5')
         ->where('id', '!=', $id)->get();




        $comments = Comment::select()->orderBy('id', 'desc')->take(8)
         ->where('show_id', $id)->get();





        $numberComments = Comment::where('show_id', $id)->count();

        //getting number of views
        $numberViews = View::where('show_id', $id)->count();
        
        if(isset(Auth::user()->id)) {


            //validating following shows

            $validateFollowing = Following::where('user_id', Auth::user()->id)
            ->where('show_id', $id)->count();
   

            //validating views

            $validateViews = View::where('user_id', Auth::user()->id)
            ->where('show_id', $id)->count();


            if($validateViews == 0) {
   
                $views = View::create([

                    "show_id" => $id,
                    "user_id" => Auth::user()->id,
                
                ]);
            }

            return view('shows.anime-detils', compact('show', 'randomShows', 'comments', 'validateFollowing', 'numberViews', 'numberComments'));

        } else {
            return view('shows.anime-detils', compact('show', 'randomShows', 'comments', 'numberViews', 'numberComments'));

        }


     

        

    }


    public function insertComments(Request $request, $id) {

        
        $insertComments = Comment::create([

            "show_id" => $id,
            "user_name" => Auth::user()->name,
            "image" => Auth::user()->image,
            "comment" => $request->comment
        ]);

        if($insertComments) {

            return Redirect::route('anime.details', $id)->with(['success' => 'Comment added successfully']);
        }

    }


    public function follow(Request $request, $id) {

        
        $follow = Following::create([

            "show_id" => $id,
            "user_id" => Auth::user()->id,
            "show_image" => $request->show_image,
            "show_name" => $request->show_name,
           
        ]);

        if($follow) {

            return Redirect::route('anime.details', $id)->with(['follow' => 'You followed this show successfully']);
        }

    }




    public function animeWatching($show_id, $episode_id) {


        $show = Show::find($show_id);

        $episode = Episode::where('episode_name', $episode_id)->where('show_id', $show_id)->first();

        $episodes = Episode::select()->where('show_id', $show_id)->get();


        //comments
        $comments = Comment::select()->orderBy('id', 'desc')->take(8)
        ->where('show_id', $show_id)->get();


        return view('shows.anime-watching', compact('show', 'episode', 'episodes', 'comments'));

    }



    public function category($category_name) {


        $shows = Show::where('genere', $category_name)->get();

        $forYouShows = Show::select()->orderBy('name', 'asc')->take(4)->get();



        return view('shows.category', compact('shows', 'category_name', 'forYouShows'));

    }



    public function searchShows(Request $request) {


        $show = $request->get('show');

        $searches = Show::where('name', 'like', "%$show%")
         ->orWhere('genere', 'like', "%$show%")->get();


        return view('shows.searches', compact('searches'));

    }



    

    
    



    
}
