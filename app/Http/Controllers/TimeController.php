<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Theatre;

class TimeController extends Controller
{   
    protected $times;

    public function __constructor(Time $times)
    {
        $this->times = $times;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Time::all();
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
            $var = Theatre::findOrFail($request->theatre_id);
            if($request->time != NULL && $var){

                $new = [

                    'time' => $request->time,
                    'theatre_id' => $request->theatre_id,

                ];

                $new = Time::create($new);

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
            $var = Time::findOrFail($id);
            return response([$var->time]);
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
            if($request->time != NULL || $request->theatre_id != NULL){
                $var = Time::findOrFail($id);
                $var->update([
                        'time' => $request->time,
                        'theatre_id' => $request->theatre_id,
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
            $var = Time::findOrFail($id);
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
