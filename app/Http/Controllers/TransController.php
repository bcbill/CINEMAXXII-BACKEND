<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Ticket;
use App\User;

class TransController extends Controller
{   
    protected $transactions;

    public function __constructor(Transaction $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::all();
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
            $var = Ticket::findOrFail($request->ticket_id);
            $var2 = User::findOrFail($request->user_id);

            if($var && $var2){

                $new = [

                    'ticket_id' => $request->ticket_id,
                    'user_id' => $request->user_id,

                ];

                $new = Transaction::create($new);

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
            $var = Transaction::leftJoin('tickets', 'tickets.id', '=', 'transactions.ticket_id')
                ->leftJoin('users','users.id','=','transactions.user_id')
                ->crossJoin('prices')
                ->select('transactions.*', 'users.name', 'prices.price')
                ->where('transactions.id',$id)->first();
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
            if($request->ticket_id != NULL || $request->user_id != NULL){
                $var = Transaction::findOrFail($id);
                if($request->ticket_id == NULL){
                    $request->ticket_id = $var->ticket_id;
                }
                if($request->user_id == NULL){
                    $request->user_id = $var->user_id;
                }
                $var->update([
                        'ticket_id' => $request->ticket_id,
                        'user_id' => $request->user_id,
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
            $var = Transaction::findOrFail($id);
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
