<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin') {
            $user = User::all();
        } else {
            $user = User::where('department_id', Auth::user()->department_id)
                ->where('role', 'agent')
                ->get();
        }
        return view('user.view', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all();
        return view('user.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == 'admin') {
            $this->validate($request,[
                "name"      => "required|min:2",
                "email"     =>  "required|email|unique:users",
                "role"      =>  "required|min:4",
                "password"  =>  "required"
            ]);

            $user = User::create(
                [
                    "name"      =>  $request->name,
                    "email"     =>  $request->email,
                    "role"      =>  $request->role,
                    "password"  =>  Hash::make($request->password),
                    "department_id" =>  $request->department_id
                ]
            );
            $user = User::all();
        } else {
            $this->validate($request,[
                "name"      => "required|min:2",
                "email"     =>  "required|email|unique:users",
                "password"  =>  "required"
            ]);

            $user = User::create(
                [
                    "name"      =>  $request->name,
                    "email"     =>  $request->email,
                    "role"      =>  'agent',
                    "password"  =>  Hash::make($request->password),
                    "department_id" =>  Auth::user()->department_id
                ]
            );
            $user = User::where('department_id', Auth::user()->department_id)
                        ->orwhere('role', 'agent');
        }
        return redirect()->route('user.index')->with('alert-success', $request->name.' Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->get();
        return view('user.update', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->status == 'admin'){
            $this->validate($request, [
                'name'      => 'required',
                'email'     => 'required',
                'password'  => 'required',
                'role'      => 'required',
            ]);
            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => hash::make($request->password),
                'role'      => $request->role
            ];
        } else {
            $this->validate($request, [
                'name'      => 'required',
                'email'     => 'required',
                'password'  => 'required'
            ]);
            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => hash::make($request->password)
            ];
        }

        $user = User::where('id', $id)->update($data);
        return redirect()->route('user.index')->with('alert-success', 'User Successfully Updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        return redirect()->route('user.index')->with('alert-danger','User has been Deleted!');
    }
}
