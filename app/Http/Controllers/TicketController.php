<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Seats;
use App\Theatre;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{   
    protected $tickets;

    public function __constructor(Ticket $tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ticket::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $var = Seats::findOrFail($request->seats_id);

            //compared to "Empty" because of overriding in Seats.php
            if($var->taken == "Empty"){
                
                $new = [

                    'seats_id' => $request->seats_id,

                ];

                $new = Ticket::create($new);

                $var->taken = true;
                $var->save();

                return response([
                    "Successful!"
                ]);

            }else{
                return response([
                    "Failed, Seat is already booked"
                ]);
            }

        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
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
        try{
            // DB::enableQueryLog();
            $var = Ticket::leftJoin('seats', 'seats.id', '=', 'tickets.seats_id')
                ->leftJoin('times','times.id','=','seats.time_id')
                ->leftJoin('theatres','theatres.id','=','times.theatre_id')
                ->crossJoin('prices')
                ->select('tickets.*', 'theatres.movie_name', 'theatres.section', 'seats.position', 'seats.taken','times.time','prices.price')
                ->where('tickets.id', $id)->first();
            // return response([
            //     DB::getQueryLog()
            // ]);
            // die();
            if($var){
                return response([
                    $var
                ]);
            }else{
                return response(["Failed"]);
            }
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            if($request->seats_id != NULL){
                $var = Ticket::findOrFail($id);
                if($request->seats_id == NULL){
                    $request->seats_id = $var->seats_id;
                }
                $var->update([
                        'seats_id' => $request->seats_id,
                     ]);

                return response([
                    "Successful"
                ]);
            }else{
                return response([
                    "No Changes Were Made"
                ]);
            }
        }catch(\Exception $e){ //catches invalid UUID syntax as well
            return response([
                $e->getMessage()
            ]);
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
        try{
            $var = Ticket::findOrFail($id);
            if(isset($var)){
                $var -> delete();
                return response([
                    "Successful"
                ]);
            }
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }

    public function getTicket($id){
        try{
            //get by seat id
            $var = Ticket::where('seats_id',$id)->first();
            return response([
                'ticket' => $var
            ]);
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }
}
