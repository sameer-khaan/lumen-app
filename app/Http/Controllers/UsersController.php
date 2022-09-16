<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Mail\WelcomeUser;

class UsersController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(){
        $users = Users::all();
        return response()->json(['data' => $users]);
    }

    public function show($id){
        $user = Users::find($id);
        if(!$user){
            return response()->json(['status' => 'fail','message' => 'User not found']);
        }

        return response()->json(['data' => $user]);
    }

    public function create(Request $request){

        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'username' => 'required|unique:users',
            'password' => 'required|min:6'
        );

        // validate against the inputs
        $validator = \Validator::make($request->all(), $rules);

        // check if the validator failed
        if ($validator->fails()) {
            // return the error from the validator
            return response()->json(['status' => 'fail','message' => $validator->errors()]);
        }

        if($user = Users::create($request->all())){
            $mail = new WelcomeUser($user);
            //Mail::to($user->email)->send($mail); //sync
            Mail::to($user->email)->queue($mail); //async
            return response()->json(['status' => 'success','message' => 'Created successfully', 'data' => $user]);
        }
        
        return response()->json(['status' => 'fail','message' => 'Something went wrong']);
    }

    public function delete($id){
        $user = Users::find($id);
        if(!$user){
            return response()->json(['status' => 'fail','message' => 'User not found']);
        }

        $user->destroy();
        return response()->json(['status' => 'success','message' => 'Deleted successfully']);
    }
}    
?>