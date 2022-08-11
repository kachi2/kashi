<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\notifications;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function referrals(){
        
        return view('auth.referral');
    }
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     * 
     */
    protected $table = 'users';


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'=> ['required','unique:users', 'regex:/(070|080|081|090)[0-9]/'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone'=> $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function create_user(Request $request){

        $validate = $this->Validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'=> ['required','numeric','unique:users', 'regex:/(070|080|081|090)[0-9]/', 'min:11'],
            'password' => ['required', 'string', 'min:6'],
        ]);
            if(!$validate){
                return back()->withInputErrors();
            }
       $create = User::create([

            'name' => $request->name,
            'email'=> $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request['password']),
        ]);

        if($create){

            $getUser = User::latest()->first();
            $notify = new notifications;
            $notify->user_id = $getUser->id;
            $notify->topic = 'Welcome to payM';
            $notify->message = 'Dear '.$getUser->name. ' '.'You are welcome to payM, we are glad to have you here, do enjoy the best of our services';
            if($notify->save()){
                $notifyCount = $getUser->notifyCount + 1;
                user::where('id', $getUser->id)->update(['notifyCount'=>$notifyCount]);
            }
        }
        Auth::loginUsingId($getUser->id);
        \Session::Flash('welcome','Welcome to payM, We are glad to have you here, Do enjoy our services');
        return redirect()->route('profile');
    }
    
     protected function referral(Request $request){

        $validate = $this->Validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'referral'=>['required'],
            'phone'=> ['required','numeric','unique:users', 'regex:/(070|080|081|090)[0-9]/', 'min:11'],
            'password' => ['required', 'string', 'min:6'],
        ]);
            if(!$validate){
                return back()->withInputErrors();
            }
            $referral = User::where('email', $request->referral)->first();
            if($referral){
                
                $ref = $referral->id;
               
            }else{
                
           \Session::Flash('referrals','Referral Email does not exit');
                return back();
            }
      //  dd($ref);
       $create = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'phone' => $request->phone,
            'referral_id' => $ref,
            'password' => Hash::make($request['password']),
        ]);

        if($create){
            $getUser = User::latest()->first();
            $notify = new notifications;
            $notify->user_id = $getUser->id;
            $notify->topic = 'Welcome to payM';
            $notify->message = 'Dear '.$getUser->name. ' '.'You are welcome to payM, we are glad to have you here, do enjoy the best of our services';
            if($notify->save()){
                $notifyCount = $getUser->notifyCount + 1;
                user::where('id', $getUser->id)->update(['notifyCount'=>$notifyCount]);
            }
        }
        Auth::loginUsingId($getUser->id);
        \Session::Flash('welcome','Welcome to payM, We are glad to have you here, Do enjoy our services');
        return redirect()->route('profile');
    }
}
