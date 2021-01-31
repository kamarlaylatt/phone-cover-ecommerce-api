<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::where('active_status', 1)->paginate(10);
        return view('backend.users.index', compact('users'));
    }

    public function block_list()
    {
        $users = User::where('active_status', 0)->paginate(10);
        return view('backend.users.block_list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
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

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('users.index')->with('success','Successfully Create User');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.users.edit', compact('user'));
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
        $user = User::find($id);


        if($request['password'] == null && $request['confirm_password'] == null)
        {  
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);         
            
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->update();

            return redirect()->route('users.index')->with('success','Successfully Update User');
        }
        else
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|same:confirm_password',            
                'confirm_password' => 'required|string|min:8',
            ]);

            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->update();

            return redirect()->route('users.index')->with('success','Successfully Update User');
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
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success','Successfully Delete User');
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->active_status = false;
        $user->save();
        return redirect()->back();
    }

    public function unblock($id)
    {
        $user = User::find($id);
        $user->active_status = true;
        $user->save();
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $users = User::where('name','like', '%'.$search.'%')
                        ->orwhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->where('active_status',1)
                        ->paginate(10);

        return view('backend.users.index', compact('users'));
    }

    public function block_search(Request $request)
    {
        $search = $request['search'];

        $users = User::where('name','like', '%'.$search.'%')
                        ->orwhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->where('active_status',0)
                        ->paginate(10);
        $users->appends(['search'=> $request->search]);      

        return view('backend.users.block_list', compact('users'));
    }
}
