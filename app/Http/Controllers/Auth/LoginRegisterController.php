<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
					'first_name' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z]+$/'],
					'last_name' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-z]+$/'],
					'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
					'password' => [
							'required',
							'string',
							'min:8',
							'max:20',
							'regex:/[A-Z]/',
							'regex:/[a-z]/',
							'regex:/[!@#$%^&*]/',
							'confirmed'
					],'mobile_number' => ['required', 'string', 'size:10', 'unique:users'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:200'],
						'profile_image' => ['min:100','max:1024']
        ]);

			
       if ($request->file('profile_image') == null) {
				$path = null;
}else{
 $path = $request->file('profile_image')->store('profile_images', 'public'); 
		

}





				
   User::create([
					'first_name' => $request->first_name,
					'last_name' => $request->last_name,
					'email' => $request->email,
					'password' => Hash::make($request->password),
					'mobile_number' => $request->mobile_number,
					'date_of_birth' => $request->date_of_birth,
					'gender' => $request->gender,
					'address' => $request->address,
					'profile_image' =>  $path

						
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
   return redirect()->route('dashboard')
     ->withSuccess('You have successfully registered & logged in!');
    }

	



    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    } 
    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::check())
        {
            return view('auth.dashboard');
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }    
    


}