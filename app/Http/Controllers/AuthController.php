<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

class AuthController extends Controller
{
	public function register(Request $request){
		$credentials = $request->only('name', 'email', 'password', 'phone', 'dob');
        
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required',
            'phone' => 'required|numeric',
            'dob' => 'required|date'
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $phone = $request->phone;
        $dob = $request->dob;
        // return response()->json(Hash::make($password));
        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'phone' => $phone, 'dob' => $dob]);
        // $verification_code = str_random(30); //Generate verification code for email
        // DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);
        // $subject = "Please verify your email address.";
        // Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
        //     function($mail) use ($email, $name, $subject){
        //         $mail->from(getenv('FROM_EMAIL_ADDRESS'), "From User/Company Name Goes Here");
        //         $mail->to($email, $name);
        //         $mail->subject($subject);
        //     });
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up!']);
	}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }

        try{
            $var = User::all()->where('email', $request->email);

            // all good so return the token
            return response()->json(['success' => true, 'data'=> [ 'token' => $token, 'user' => $var ]]);
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
    	//$this->validate($request, ['token' => 'required']); //this is for putting the token in the url instead of header
        
        try {
            JWTAuth::invalidate();
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }
}
