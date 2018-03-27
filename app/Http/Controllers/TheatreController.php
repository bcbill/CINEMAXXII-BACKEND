<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theatre;

class TheatreController extends Controller
{

    protected $theatres;

    public function __constructor(Theatre $theatres)
    {
        $this->theatres = $theatres;
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
            //prevents creating a record with nothing in it
            if($request->movie_name != NULL && $request->section != NULL){

                $new = [

                    'movie_name' => $request->movie_name,
                    'section' => $request->section,

                ];

                $new = Theatre::create($new);

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
            $var = Theatre::findOrFail($id);
            return response([$var]); //section,movie name,movie time
        }catch(\Exception $e){
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
        return Theatre::all();
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
            if($request->movie_name != NULL || $request->section != NULL){
                //in case a field was not being updated/left as null let the current data in the database be stored in var
                $var = Theatre::findOrFail($id);
                if($request->movie_name == NULL){
                    $request->movie_name = $var->movie_name;
                }
                if($request->section == NULL){
                    $request->section = $var->section;
                }
                $var->update([
                        'movie_name' => $request->movie_name,
                        'section' => $request->section,
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
            $var = Theatre::findOrFail($id);
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
