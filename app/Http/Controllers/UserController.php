<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; //for hashing
use App\User;

class UserController extends Controller
{
    protected $users;

    public function __constructor(User $users)
    {
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display the specified resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $var = User::findOrFail($id);
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
            if($request->name != NULL || $request->password != NULL || $request->email != NULL || $request->phone != NULL || $request->dob != NULL){
                //in case a field was not being updated/left as null let the current data in the database be stored in var
                $var = User::findOrFail($id);
                if($request->name == NULL){
                    $request->name = $var->name;
                }
                if($request->password == NULL){
                    $request->password = $var->password;
                }
                if($request->email == NULL){
                    $request->email = $var->email;
                }
                if($request->phone == NULL){
                    $request->phone = $var->phone;
                }
                if($request->dob == NULL){
                    $request->dob = $var->dob;
                }

                $var->update([
                        'name' => $request->name,
                        'password' => $request->password,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'dob' => $request->dob,
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
            $var = User::findOrFail($id);
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

    public function addBalance(Request $request, $id){

        try{

            if($request->balance != NULL){
                $var = User::findOrFail($id);
                $var->update([
                        'balance' => $var->balance + $request->balance
                     ]);
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

    public function subBalance(Request $request, $id){

        try{

            if($request->balance != NULL){
                
                $var = User::findOrFail($id);

                if($var->balance < $request->balance){
                    return response([
                        "Insufficient Balance"
                    ]);
                }else{
                    $var->update([
                        'balance' => $var->balance - $request->balance
                     ]);
                    return response([
                        "Successful"
                    ]);
                }
            }

        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }

    }

}
