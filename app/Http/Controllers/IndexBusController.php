<?php

namespace App\Http\Controllers;
use App\Models\Buses;
use Illuminate\Http\Request;

class IndexBusController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $buses = Buses::where([
            ['bus_name', '!=', Null],
            [function($query) use ($request){
                if(($term = $request->term)){
                    $query->orWhere('bus_name', 'LIKE', '%'. $term . '%')->get();
                    
                    
                }
            
            }]
        ])

         ->orderBy("bus_name","asc")
         ->paginate(10);

       
        //Show Bookings     
        return view('indexbuses', compact('buses'),['buses'=>$buses])
        ->with('i',(request()->input('page',1)-1)*5);
   }
}
