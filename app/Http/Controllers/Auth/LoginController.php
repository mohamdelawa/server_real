<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\User;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;
class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public  function  login(){
        if (Auth::check()){

            Auth::logout();
        }
        return view('auth.login');
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function authenticate(Request $request){
       // $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
        if(auth()->attempt(array($fieldType => $request->username, 'password' => $request->password)))
        {

            $user = Auth::guard('web')->user();
            $user->status = "Active";
            $user->save();
            \Illuminate\Support\Facades\Cookie::queue('active_user',60*60*24);

                if( Admin::all()->where('account_id','=',auth::user()->id)->isNotEmpty()){
                    return redirect()->route('admin');
                }elseif (Company::all()->where('account_id','=',auth::user()->id)->isNotEmpty()){
                    return redirect()->route('company');
                }elseif(User::all()->where('account_id','=',auth::user()->id)->isNotEmpty()){
                    return redirect()->route('user');
                }
            return redirect()->route('index');
        }
        return redirect()->back()->withInput()->with('error','البريد الالكنروني أو كلمة السر غير صحيحة');
    }
    public  function  logout(){
        if (Auth::check()){
            $user = Auth::user();
            $user->status = "Inactive";
            $user->save();
            Auth::logout();
        }
        return redirect()->route('login');
    }
}
