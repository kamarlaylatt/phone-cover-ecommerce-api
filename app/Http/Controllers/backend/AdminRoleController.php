<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminRole;
use Validator;
use Illuminate\Support\Facades\Hash;

class AdminRoleController extends Controller
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
        $admin_roles = AdminRole::paginate(10);
        return view('backend.admin_roles.index', compact('admin_roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin_roles.create');
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
            'description' => 'required|string|max:255',
        ]);

        AdminRole::create([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        return redirect()->route('admin_roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin_role = AdminRole::find($id);
        return view('backend.admin_roles.show', compact('admin_role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin_role = AdminRole::find($id);
        return view('backend.admin_roles.edit', compact('admin_role'));
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
        $admin_role = AdminRole::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);         
        
        $admin_role->name = $request['name'];
        $admin_role->description = $request['description'];
        $admin_role->update();

        return redirect()->route('admin_roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin_role = AdminRole::find($id);
        $admin_role->delete();

        return redirect()->route('admin_roles.index')->with('error','Successfully delete admin role');
    }

    public function search(Request $request)
    {
        $search = $request['search'];

        $admin_roles = AdminRole::where('name','like', '%'.$search.'%')
                        ->orwhere('description', 'like', '%'.$search.'%')
                        ->paginate(10);

        return view('backend.admin_roles.index', compact('admin_roles'));
    }
}
