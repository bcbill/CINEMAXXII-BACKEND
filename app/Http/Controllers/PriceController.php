<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;

class PriceController extends Controller
{   
    protected $prices;

    public function __constructor(Price $prices)
    {
        $this->prices = $prices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Price::all();
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
            if($request->price){

                $new = [
                    'price' => $request->price
                ];

                $new = Price::create($new);

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
            $var = Price::findOrFail($id);
            return response([$var]);
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
            if($request->price != NULL){
                //prevent updating element into null value
                $var = Price::findOrFail($id);
                if($request->price == NULL){
                    $request->price = $var->price;
                }
                $var->update([
                        'price' => $request->price,
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
            $var = Price::findOrFail($id);
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
