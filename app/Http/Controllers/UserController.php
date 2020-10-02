<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = 50;
        $page_name = "Employee Management";
        $user_all = DB::table('users')->where('user_type','=','2')->orderBy('id','desc')->paginate($items);
        return view('admin.user.user_manage',compact('page_name','user_all','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_name = "Employee Create";
        return view('admin.user.user_create',compact('page_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required',
            'email'=>'required|email|unique:users,email',
            'mobile'=> 'required|numeric|unique:users,mobile|min:11',
            'address'=>'required',
            'password' => 'required|min:8',
            'confirmPassword' => 'required_with:password|same:password',
        ],[
            'first_name.required'=>"First name is required",
            'email.required'=>"Email is required",
            'email.email'=>"Invalid email. Please, try a valid email address",
            'email.unique'=>"User email already exists",
            'mobile.required'=>"Mobile number is required",
            'mobile.unique'=>"This mobile number is already exists",
            'address.required'=>"Address is required",
            'password.required'=>"Password is required",
            'password.min'=>"Password must be at least 8 characters long",
            'confirmPassword.same'=>"Password mismatch",
        ]);

        $user = new User();

        if($request->image!=null){
            $profileImage = $request->file('image');
            $profileImageSaveAsName = "ProfilePictureOfId_". $request->first_name.".". $profileImage->getClientOriginalExtension();
            $upload_path = 'profile_images/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);
            $user->image = $profile_image_url;
        }


        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->user_type = 2;
        $user->save();
        return redirect()->route('user.index')->with('success',"Employee created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_name = "Edit Employee";
        $user = User::find($id);
        return view('admin.user.user_edit',compact('page_name','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'first_name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'mobile'=> 'required|numeric||min:11|unique:users,mobile,'.$id,
            'address'=>'required',
            'password' => 'nullable|min:8',
            'confirmPassword' => 'nullable|required_with:password|same:password',
        ],[
            'first_name.required'=>"First name field is required",
            'email.required'=>"Email is required",
            'email.email'=>"Invalid email. Please, try a valid email address",
            'email.unique'=>"User email already exists",
            'mobile.required'=>"Mobile number is required",
            'mobile.unique'=>"This mobile number is already exists",
            'address.required'=>"Address is required",
            'password.required'=>"Password is required",
            'password.min'=>"Password must be at least 8 characters long",
            'confirmPassword.same'=>"Password mismatch",
        ]);

        $user = User::find($id);

        if($request->image!=null){
            $profileImage = $request->file('image');
            $profileImageSaveAsName = "ProfilePictureOfId_". $request->first_name.".". $profileImage->getClientOriginalExtension();
            $upload_path = 'profile_images/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);
            $user->image = $profile_image_url;
        }


        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->address = $request->address;
        $user->user_type = 2;
        $user->save();
        return redirect()->route('user.index')->with('success',"Employee updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')->with('success',"Employee deleted successfully");
    }
}
