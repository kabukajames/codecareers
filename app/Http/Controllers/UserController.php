<?php

namespace App\Http\Controllers;
use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Hashing\BcryptHasher;

class UserController extends Controller
{
    
//show register or create form 
public function create(){
return view('users.register');





} 
public function store(Request $request){

$formFields = $request->validate([

'name' => ['required','min:3'],
'email' => ['required','email',Rule::unique('users','email')],
'password' => 'required|confirmed|min:6'


]);

// hashpassword
$formFields['password'] = bcrypt($formFields['password']);

//create user 
$user = User::create($formFields);
 
//login 
auth()->login($user);

return redirect('/listings')->with('message' , 'User created and logged in ');
}

//user log out
public function logout(Request $request){
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/listings')->with('message', 'You have been logged out!');


}


//show a login form 
public function login(){



    return view('users.login');
}
  // Authenticate User
  public function authenticate(Request $request) {
    $formFields = $request->validate([
        'email' => ['required', 'email'],
        'password' => 'required'
    ]);

    if(auth()->attempt($formFields)) {
        $request->session()->regenerate();

        return redirect('/listings')->with('message', 'You are now logged in!');
    }

    return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
}



}
