<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class AuthController extends Controller
{

  //return admin login page
  public function admin(){
    return view('admin.login');
  }

    //return admin users page
  public function user(){
    return view('user.login');
  }

  //Authenticate Admin or User
  public function auth(Request $request)
  {
  
    //check if it's a user request
    if($request->path()=='validate_user'){

      //validate the input by the rules
        $formfields  =$request->validate([
            'username' => ['required'],
            'password' => ['required']
           ]);

           //convert the formfields key to variable and check if record(username and password) exist in the user table
           extract($formfields);
           $user =User::where('email',$username)->orwhere('username', $username)->first();
           
           // if user is valid, redirect to home
           if($user && Hash::check($password, $user->password)){
            session(['role'=>'user']);
            return redirect('/home')->with("Pal, you're logged In");
           }
           //else return the line below
            return ("Incorect username and password <a href='/'>try again</a>");
            
    }
    
    else
        //else if it it's an admin request
    $formfields  =$request->validate([
        'username' => ['required'],
        'password' => ['required']
       ]);
       extract($formfields);

//validate admin with the admin table
       $user =Admin::where('email',$username)->orwhere('username', $username)->first();

       if($user && Hash::check($password, $user->password)){
       session(['role'=>'admin']);
        return redirect('/admin_home')->with("Pal, you're logged In");
    }

    return ("Incorect username and password <a href='/admin'>try again</a>");
  }

  //return user homepage
  public function home(){
    return view('home');        
  }
}
