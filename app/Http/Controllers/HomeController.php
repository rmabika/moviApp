<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        // $client = new \GuzzleHttp\Client();

        // $request = $client->get('http://google.com');

        // $response = $request->getBody();

       

        // dd($response);

        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET',
            'https://api.themoviedb.org/3/discover/movie',
            [
                'query' => [
                    'api_key' => '24d3fbf03845a5eb6156a5c94a78a58a',
                    'language' => 'en-US',
                    'page' => 1,
                    'total_pages' => 9,
                    'total_results' => 45
                  

                ]
            ]
        );

        $body = $response->getBody();
        $data = json_decode($body);

        // echo "<pre>";
        // print_r(json_encode($data));
        // echo "</pre>";

        //dd($data[0]['original_title']);

       // echo $data->original_title;

        $result = [
            'movies' => (object)$data,
        ];

       


    // var_dump($result);

      return view('home')->with('result', $result);
  
  }

  function addFavorite(Request $request){

   


    if($request){

      $favMovie = new Favorite;


      $movieCheck = Favorite::Where('title', $request->title)->first();
     // print_r($movieCheck);  


      if($movieCheck){

        return json_encode(['status'=>'error',
                'message' => 'Sorry, this movie already added to the list'
              ]);
      }else{

      $favMovie->title = $request->title;
      $favMovie->release_date = $request->release_date;
      $favMovie->backdrop_path = $request->image_path;
      $favMovie->user_id = Auth::id();
      $favMovie->save();

      // return $request->id;
       return json_encode(['status'=>'success',
                'message' => 'Great, this movie was successfully added to the list'
              ]);

      }

    

    }

  }



  function myContact(){

      return view('contact');
  }


  function getFavorites(){

    $favoritesmovies = Favorite::where('user_id', Auth::id())->get();
    $movies = $favoritesmovies;
    

    //  dd($movies);

     return view('my-favorites',  array('movies' => $movies));



  }






}
