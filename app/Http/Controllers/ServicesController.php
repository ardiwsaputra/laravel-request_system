<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depid = Auth::user()->department_id;
        $service = Service::where('department_id', $depid)->get();
        return view('service.view', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = Service::all();
        return view('service.create', compact('service'));
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
            "service_name"    => "required|min:2",
            "active"             => "required"
        ]);

        $service = Service::create(
            [
                'service_name'      => $request->service_name,
                'active'            => $request->active,
                'department_id'     => Auth::user()->department_id
            ]
        );

        $service = Service::all();
        return redirect()->route('service.index')->with('alert-success', $request->service_name.' Successfully Added');
    }

    public function active($id)
    {

        $data = [
            'active'    => 'y'
        ];

        $service = Service::find($id);
        $service->update($data);
        return redirect()->route('service.index')->with('alert-success', 'Service Successfully Updated');
    }

    public function nonactive($id)
    {

        $data = [
            'active'    => 'n'
        ];

        $service = Service::find($id);
        $service->update($data);
        return redirect()->route('service.index')->with('alert-success', 'Service Successfully Updated');
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
