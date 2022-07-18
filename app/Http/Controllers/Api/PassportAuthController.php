<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{

    public $successStatus = 200;
	protected $customers, $devicecustomers;
   	public function __construct(User $user)
    {
		$this->user = $user;

	}
     /**
     * Registration Req
     * Narendra Kumar Nagda
     */
    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Laravel9PassportAuth')->accessToken;
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        return response()->json(['success'=>'true','data'=>$user,'token' => $token]);
    }

     /**
     * Login Req
     * * Narendra Kumar Nagda
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'active',
            'status_roles' => '1',
        ];
        if (auth()->attempt($data)) {
            $user = User::where('email',$request->email)->first();
            $status = $user->active;
            $uid = $user->id;
            $mobile = $user->mobile;
            $password = $request->password;
            $token = auth()->user()->createToken('Djinee')->accessToken;
             //return $token = auth()->user();
            return response()->json(['success' => 'True','data'=> $user, 'token' =>$token->token]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

     /**
     * User View Req
     * * Narendra Kumar Nagda
     */
    public function view()
    {
       $data = User::where('id','!=','1')->get();
       return response()->json(['success' => 'true','data'=> $data]);
    }

      /**
     * User update Req
     * * Narendra Kumar Nagda
     */
    public function updateprofile(Request $request)
    {
        try{
    	    $user = $this->user->where('email',$request['email'])
            ->update([
                'name'=>$request->name,
                'mobile'=>$request->mobile,
                'mobile_alt'=>$request->mobile_alt,
                'gender'=>$request->gender,
                'address'=>$request->address,
                'status_roles'=>$request->status_roles,
                'state_name'=>$request->state_name,
                'city_name'=>$request->city_name,
                'pin_code'=>$request->pin_code,
                'country_code'=>$request->country_code,
                'country_name'=>$request->country_name,
            ]);

	       	$userdata = $this->user->where('email',$request['email'])->first();
	       	return response()->json(['status' => 'true','message'=>'Successfully update profile!','data'=>$userdata]);
	    }
	    catch(\Exception $e){
	      return response()->json(['status' => 'false','message'=> $e->getMessage()]);
	    }
    }

    public function userInfo()
    {
     $user = auth()->user();
     return response()->json(['user' => $user], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroys($id)
    {
        try{

           return  $carts = $this->user->where('id',$id)->first();
            if(isset($carts))
            {
           $cartss = $this->user->where('id',$id)->delete();
            return \Response::json(['status' => 'true','message'=>'Your address deleted successfully ']);
            }
            else
          {
           return \Response::json(['status' => 'false','message'=>'User not found ']);
          }
         }
         catch (\Exception $e)
          {
              \Session::flash('danger', $e->getMessage());
              return redirect()->back();
          }
    }

}
