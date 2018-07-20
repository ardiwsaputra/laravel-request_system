<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Department::all();
        return view('department.view', compact('department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all();
        return view('department.create', compact('department'));
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
           "department_name"    => "required|min:2",
           "active"             => "required"
        ]);

        $department = Department::create(
        [
            'department_name'   => $request->department_name,
            'active'            => $request->active
        ]);

        $department = Department::all();
        return redirect()->route('department.index')->with('alert-success', $request->department_name.' Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {

        $data = [
            'active'    => 'y'
        ];

        $departments = Department::find($id);
        $departments->update($data);
        return redirect()->route('department.index')->with('alert-success', 'Department Successfully Updated');
    }

    public function nonactive($id){

        $data = [
            'active'    => 'n'
        ];

        $departments = Department::find($id);
        $departments->update($data);
        return redirect()->route('department.index')->with('alert-success', 'Department Successfully Updated');
    }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
