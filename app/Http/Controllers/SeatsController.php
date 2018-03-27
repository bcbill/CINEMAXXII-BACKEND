<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Seats;

class SeatsController extends Controller
{
    
    protected $seats;

    public function __constructor(Seats $seats)
    {
        $this->seats = $seats;
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
            $var = Time::findOrFail($request->time_id); //get the requested timee id

            //prevent auto-increment error in database upon entering a time id that doesnt exist
            if($var != NULL && $request->position != NULL){

                $new = [
                    
                    'time_id' => $request->time_id,
                    'position' => $request->position,

                ];

                $new = Seats::create($new);

                return response([
                    "Successful!",
                ]);

            }else{
                return response([
                    "Failed",
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
            $selected = Seats::findOrFail($id);
            return response([
                $selected
            ]);
        }catch(\Exception $e){//if the \ is not used before Exception, there will be an error App\Http\Controllers\Exception not found
            return response([
                $e->getMessage()
            ]);
        }
    }

    /**
     * Display all resources.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        return Seats::all();
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
            if($request->time_id != NULL || $request->position != NULL || $request->taken != NULL){
                //in case a field was not being updated/left as null let the current data in the database be stored in var
                $var = Seats::findOrFail($id);
                if($request->time_id == NULL){
                    $request->time_id = $var->time_id;
                }
                if($request->position == NULL){
                    $request->position = $var->position;
                }
                if($request->taken == NULL){
                    $request->taken = $var->taken;
                }

                $var->update([
                        'time_id' => $request->time_id,
                        'position' => $request->position,
                        'taken' => $request->taken,
                    ]);

                return response([
                    "Successful"
                ]);

            }else{
                return response([
                    "No Changes Were Made"
                ]);
            }
        }catch(\Exception $e){
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
            $var = Seats::findOrFail($id);
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
}
