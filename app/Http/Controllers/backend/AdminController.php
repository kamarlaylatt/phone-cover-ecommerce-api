<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\AdminRole;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('backend.welcome');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('backend.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = AdminRole::all();
        return view('backend.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|same:confirm_password',            
            'confirm_password' => 'required|string|min:8',
        ]);

        Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'admin_role_id' => $request['role'],
        ]);

        return redirect()->route('admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        return view('backend.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        $roles = AdminRole::all();
        return view('backend.admins.edit', compact('admin','roles'));
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
        $admin = Admin::find($id);


        if($request['password'] == null && $request['confirm_password'] == null)
        {  
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);         
            
            $admin->name = $request['name'];
            $admin->email = $request['email'];
            $admin->admin_role_id = $request['role'];
            $admin->update();

            return redirect()->route('admins.index');
        }
        else
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|same:confirm_password',            
                'confirm_password' => 'required|string|min:8',
            ]);

            $admin->name = $request['name'];
            $admin->email = $request['email'];
            $admin->admin_role_id = $request['role'];
            $admin->password = Hash::make($request['password']);
            $admin->update();

            return redirect()->route('admins.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $admins = Admin::where('name','like', '%'.$search.'%')
                        ->orwhere('email', 'like', '%'.$search.'%')
                        ->paginate(10);

        return view('backend.admins.index', compact('admins'));
    }

    public function profile()
    {
        $roles = AdminRole::all();
        $admin = Auth::user();
        return view('auth.admin_profile', compact('roles','admin'));
    }

    public function profileUpdate(Request $request)
    {
        $admin = Admin::find(Auth::user()->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);         
        
        $admin->name = $request['name'];
        $admin->email = $request['email'];

        if(Auth::user()->admin_role_id == 1)
        {
            $admin->admin_role_id = $request['role'];
        }
        $admin->update();

        return redirect()->route('admins.profile')->with('success','Successfully update your profile.');
        
    }

    public function editPassword()
    {
        return view('auth.edit_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|same:confirm_password',
            'confirm_password' => 'required',
        ]);    
        $oldPassword = $request['old_password'];
		$newPassword = $request['new_password'];
		$confirmPassword = $request['confirm_password'];

		$user = Auth::user();
		$userPassword = $user->password;

		if($oldPassword == $newPassword)
		{
            return redirect()->route('admins.edit.password')->with('error','Your new password cannot be the same as your current password, please try again.');
		}


		if(Hash::check($request->old_password, $user->password))
		{
			$user->password = Hash::make($newPassword);
			$user->save();

			$responseBody = [
				'userId' => Auth::user()->id,
				'userName' => Auth::user()->name,
				'userPhone' => Auth::user()->phone,
				'status' => 'Successfully update password.',
			];
            return redirect()->route('admins.edit.password')->with('success','Successfully update password.');
            
		}
		else{
            return redirect()->route('admins.edit.password')->with('error','Your old password not match, please try again');
        }
    }
}
