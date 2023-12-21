<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use URL;
use Hash;
use Redirect;
use Spatie\Permission\Models\Role;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  //  use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function index(){
        return view('auth.login');
    }

    public function authentication(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'username.required' => 'username is required',
                'password.required' => 'Password is required',
            ]
        );

        $username =$request->input('username');
        $password =$request->input('password');
        $remember =$request->input('remember');

       // return Hash::make('admin@123');

        if (Auth::attempt(['email' => $username, 'password' => $password],$remember)) {
            $user = User::find(auth()->user()->id);
            if ($user->status == "Active") { 

               if ($user->hasRole('Admin') || $user->hasRole('Super Admin') || $user->hasRole('Member')) {
                if ($user->password_change_status == 0) {
                    return response()->json([
                        'success' =>true,
                        'message' =>greeting().' '.$user->name.' Welcome Again at Usk brothers',
                        'url'     =>URL::to('change-password')
                    ]);
                } else {
                    return response()->json([
                        'success' =>true,
                        'message' =>greeting().' '.$user->name.' Welcome Again at Usk brothers',
                        'url'     =>URL::to('dashboard')
                    ]);
                }
                
               
               } else {
                Auth::logout();
                return response()->json([
                    'success' =>false,
                    'errors' =>'You dont have Permission to access this site',
                ],500);
               }
               

            } else {
                Auth::logout();
                return response()->json([
                    'success' =>false,
                    'errors' =>'Your Account has been Deactivated , Contact System Adminstrator to Activate Your Account',
                ],500);
            }
        } else {
            return response()->json([
                'success' =>false,
                'errors' =>'Invalid email/Username or Password',
            ],500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('/');
    }

    public function changePasswordForm(){
        return view('auth.change_password');
    }

    public function changePassword(Request $request){
        $valid =$this->validate($request,[
            'old_password' =>'required',
            'password'     =>['required','confirmed','string','min:6','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/','regex:/[@$!%*#?&]/',
            ],
        ]);

        $user =Auth::user();
        if (!Hash::check($valid['old_password'],$user->password)) {
            return response()->json([
                'success' =>false,
                'errors'  =>"Old Password is not correct",
            ],500);
        }

        $user->password =Hash::make($valid['password']);
        $user->password_change_status =1;
        $user->password_change_date =Carbon::now();
        $user->save();
        
        return response()->json([
            'success' =>true,
            'message' =>greeting().' '.$user->name.' Welcome Again at Usk Brotherhood',
            'url'     =>URL::to('dashboard')
        ]);
    }

}
