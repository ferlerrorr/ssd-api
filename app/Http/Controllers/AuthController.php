<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Providers\Auth\Illuminate;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    
    /**
     * ! Auth Middleware.
     * * Middleware for checking the Authentication of user.
    */
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['token','register']]);
    }

    /**
    * ! Register Controller.
    * * Register a user.
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $validator = Validator::Make($request->all(),[
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed|min:6'

        ]);

        if($validator->fails()){

            $invalid_fields = array_values($validator->errors()->toArray());
        
            return response($invalid_fields,400);
				
			//will return 200 ok if flushed
        }

        //$user unused 
        //add the token for input and monitoring and to unsigned
        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
         ));

		ob_flush();
		flush();
		// if you're using sessions, this prevents subsequent requests
		// from hanging while the background process executes
		if (session_id()) {session_write_close();}


         return response()->json([
            ['User Successfully Created']
         ]);

    }

   /**
    * ! Login Controller.
    * * Log a user.
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
   */
   public function token(Request $request)
   {  
 

    $validator = Validator::Make($request->all(),[
        'email' => 'required|email',
        'password' => 'required|string|min:6'
    ]);
         
   
    if($validator->fails()){
        // return response()->json($validator->errors()->toJson(),422);
        $invalid_fields = array_values($validator->errors()->toArray());
        return response($invalid_fields,400);
		//will return 200 ok if flushed
    }
      
  

    if(!$token=auth()->attempt($validator->validated())){
        return response()->json(['error'=>'Unauthorized'],401);
		//will return 200 ok if flushed
    }
          
   
    $auth_id = auth()->user()->id;
    $user = User::where('id' , $auth_id);

 
    $data = $this->createNewToken($token);

    $tok = $data['access_token'];

    $user->update([
        'active_token' => $tok
    ]);

		ob_flush();
		flush();
		// if you're using sessions, this prevents subsequent requests
		// from hanging while the background process executes
		if (session_id()) {session_write_close();}

	if($token=auth() == true){
        auth()->logout();
    }

    $validator = Validator::Make($request->all(),[
        'email' => 'required|email',
        'password' => 'required|string|min:6'
    ]);
         
   
    if($validator->fails()){
        // return response()->json($validator->errors()->toJson(),422);
        $invalid_fields = array_values($validator->errors()->toArray());
        return response($invalid_fields,400);
		//will return 200 ok if flushed
    }
      
  

    if(!$token=auth()->attempt($validator->validated())){
        return response()->json(['error'=>'Unauthorized'],401);
		//will return 200 ok if flushed
    }
          
   
    $auth_id = auth()->user()->id;
    $user = User::where('id' , $auth_id);

 
    $data = $this->createNewToken($token);

    $tok = $data['access_token'];

    $user->update([
        'active_token' => $tok
    ]);

		ob_flush();
		flush();
		// if you're using sessions, this prevents subsequent requests
		// from hanging while the background process executes
		if (session_id()) {session_write_close();}

    return response()->json($data);
    }

    /**
    * ! Create New Token Function.
    * * Asign a JWT Token and display the specific user details.
    * @param  $token
    * @return \Illuminate\Http\Response
   */
    public function createNewToken($token){
        // auth()->user();
        // return response()->json([
        //    'access_token'=>$token,
        //    'token_type'=>'bearer',
        //    'name'=>auth()->user()->name,
        //    'email'=>auth()->user()->email
        // ]);
       

        return (["access_token" => $token]);



    }
    /**
    * ! Profile Function.
    * * Display the specific user details.
    * @param  $token
    * @return \Illuminate\Http\Response
   */
    public function profile(){
        return response()->json(auth()->user());
    }


    /**
    * ! Logout Function.
    * * Remove a specific Token Details.
    * @param  $token
    * @return \Illuminate\Http\Response
   */
    public function logout(){
        $auth_id = auth()->user()->id;
        $user = User::where('id' , $auth_id);
        $user->update([
            'active_token' => null
        ]);
        auth()->logout();
        return response()->json([
            'msg' => 'User Logout'
         ]);
    }


}
