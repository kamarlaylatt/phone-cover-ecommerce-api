<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Validator;
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
        return view('backend.admins.create');
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
            'role' => $request['role'],
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
        return view('backend.admins.edit', compact('admin'));
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
            $admin->role = $request['role'];
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
            $admin->role = $request['role'];
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
}
