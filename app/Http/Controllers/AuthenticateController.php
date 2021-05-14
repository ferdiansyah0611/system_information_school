<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class AuthenticateController extends Controller
{
    public $successStatus = 200;
    
    public function login()
    {
        if(Auth::attempt(['nisn' => request('nisn'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json(['success' => $success, 'user' => request()->user()], $this->successStatus);
        }
        else{ 
            return response()->json(['error'=>bcrypt('ferdiansyah')], 401); 
        } 
    }
    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'verify_password' => 'required|same:password',
            'location' => 'required',
            'languange' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success' => $success, 'user' => request()->user()], $this->successStatus);
    }
}
