<?php

namespace App\Http\Controllers;

use App\Department;
use App\Mail\CreateRequest;
use App\Mail\OpenRequest;
use App\Mail\UpdateRequest;
use App\Service;
use App\Req;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon;
use Excel;



class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::check()){
            $this->validate($request, [
                'limit' => 'integer',
            ]);
            if (request()->has('filter')){
                $req = Req::orderBy($request->filter, $request->sort)
                    ->join('departments', 'requests.department_id', '=', 'id')
                    ->when($request->keyword, function ($query) use ($request) {
                        $query->where('request_no', 'like', "{$request->keyword}") // search by email
                        ->orWhere('name', 'like', "{$request->keyword}%") // or by name
                        ->orWhere('created_at', 'like', "%{$request->keyword}%")
                        ->orWhere('department_name', 'like', "{$request->keyword}");
                    })
                    ->paginate($request->limit ? $request->limit : 10);
                $req->appends($request->only('filter'));
            } else {
                $req = Req::orderBy('request_no', 'desc')
                    ->join('departments', 'requests.department_id', '=', 'id')
                    ->when($request->keyword, function ($query) use ($request) {
                        $query->where('request_no', 'like', "{$request->keyword}") // search by email
                        ->orWhere('name', 'like', "{$request->keyword}%") // or by name
                        ->orWhere('created_at', 'like', "%{$request->keyword}%")
                        ->orWhere('department_name', 'like', "{$request->keyword}");
                    })
                    ->paginate($request->limit ? $request->limit : 10);
                $req->appends($request->only('keyword'));
            }
        } else {
            $this->validate($request, [
                'limit' => 'integer',
            ]);

            if (request()->has('filter')){
                $req = Req::where('department_id', Auth::user()->department_id)
                    ->join('departments', 'requests.department_id', '=', 'id')
                    ->orderBy($request->filter, $request->sort)
                    ->when($request->keyword, function ($query) use ($request) {
                        $query->where('request_no', 'like', "{$request->keyword}") // search by email
                        ->orWhere('name', 'like', "{$request->keyword}%") // or by name
                        ->orWhere('created_at', 'like', "%{$request->keyword}%")
                        ->orWhere('department_name', 'like', "{$request->keyword}")
                        ->where('department_id', Auth::user()->department_id);
                    })
                    ->paginate($request->limit ? $request->limit : 10);
                $req->appends($request->only('filter'));
            } else {
                $req = Req::where('department_id', Auth::user()->department_id)
                    ->join('departments', 'requests.department_id', '=', 'id')
                    ->orderBy('request_no', 'desc')
                    ->when($request->keyword, function ($query) use ($request) {
                        $query  ->where('request_no', 'like', "{$request->keyword}") // search by email
                        ->orWhere('name', 'like', "{$request->keyword}%") // or by name
                        ->orWhere('created_at', 'like', "%{$request->keyword}%")
                        ->orWhere('department_name', 'like', "{$request->keyword}")
                        ->where('department_id', Auth::user()->department_id);
                    })->paginate($request->limit ? $request->limit : 10);
                $req->appends($request->only('keyword'));
            }
        }
        return view('request.view', compact('req'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::where('active', 'y')->pluck("department_name","id");
        return view('request.create', compact('department'));
    }

    public function reqChart(Request $request){
        $department = Department::all();
        if (!Auth::check()){
            if (request()->has('filter')){
                if($request->filter == 'All'){
                    $req = Req::selectRaw('count(status) as count,status')->groupBy('status')->get();
                    $requests=array();
                    foreach ($req as $result) {
                        $requests[ucfirst($result->status)]=(int)$result->count;
                    }
                } else {
                    $req = Req::selectRaw('count(status) as count,status')->where('department_id', $request->filter)
                        ->groupBy('status')->get();
                    $requests=array();
                    foreach ($req as $result) {
                        $requests[ucfirst($result->status)]=(int)$result->count;
                    }
                }
            } else {
                $req = Req::selectRaw('count(status) as count,status')->groupBy('status')->get();
                $requests=array();
                foreach ($req as $result) {
                    $requests[ucfirst($result->status)]=(int)$result->count;
                }
            }

        } else if(Auth::user()->role == 'admin'){
            $req = Req::selectRaw('count(status) as count,status')->groupBy('status')->get();
            $requests=array();
            foreach ($req as $result) {
                $requests[ucfirst($result->status)]=(int)$result->count;
            }
        } else {
            $req = Req::selectRaw('count(status) as count,status')->where('department_id', Auth::user()->department_id)
                ->groupBy('status')->get();
            $requests=array();
            foreach ($req as $result) {
                $requests[ucfirst($result->status)]=(int)$result->count;
            }
        }
        return view('home',compact('requests', 'department'));
    }

    public function getService($id)
    {
        $service_id = Service::where("department_id",$id)->where('active','y')->pluck("service_name","id");
        return json_encode($service_id);
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
            "name"             => "required|min:2",
            "email"            => "required|email",
            "subject"          => "required|min:2",
            "description"      => "required",
            "department_id"    => "required",
            "service_id"       => "required"
        ]);


        if($request->hasFile('filename')){
            $file = $request->file('filename');
            $filename = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis')."_".$filename.".".$ext;
            $upload_path = base_path('/public/file/');
            $request->file('filename')->move($upload_path,$filename);
            $req = Req::create(
                [
                    "name"             => $request->name,
                    "email"            => $request->email,
                    "subject"          => $request->subject,
                    "description"      => $request->description,
                    "feedback"         => '',
                    "file"             => $filename,
                    "status"           => 'open',
                    "created_at"         => Carbon\Carbon::now(),
                    "updated_at"         => Carbon\Carbon::now(),
                    "department_id"    => $request->department_id,
                    "service_id"       => $request->service_id
                ]
            );
        } else {
            $req = Req::create(
                [
                    "name"             => $request->name,
                    "email"            => $request->email,
                    "subject"          => $request->subject,
                    "description"      => $request->description,
                    "feedback"         => '',
                    "file"             => '',
                    "status"           => 'open',
                    "created_at"         => Carbon\Carbon::now(),
                    "updated_at"         => Carbon\Carbon::now(),
                    "department_id"    => $request->department_id,
                    "service_id"       => $request->service_id
                ]
            );
        }
        $agent = User::where('department_id', $req->department_id)
                        ->where('role', 'agent')->get();
        foreach ($agent as $agents){
            Mail::send(new OpenRequest($agents, $req));
        }
        Mail::send(new CreateRequest($req));
        return redirect()->route('request.index')->with('alert-success', 'Request : '.$request->subject.' Successfully Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $req = Req::where('request_no', $id)->get();
        return view('request.update', compact('req'));
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
        $this->validate($request, [
            'status'    => 'required',
            'feedback'  => 'required'
        ]);

        if($request->hasFile('filename')) {
            $file = $request->file('filename');
            $filename = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $filename = date('YmdHis')."_".$filename.".".$ext;
            $upload_path = base_path('/public/file/');
            $request->file('filename')->move($upload_path,$filename);
            $data = [
                'feedback' => $request->feedback,
                'status' => $request->status,
                'file' => $filename,
                "updated_at" => Carbon\Carbon::now(),
                'user_id' => Auth::user()->id
            ];
        } else {
            $data = [
                'feedback' => $request->feedback,
                'status' => $request->status,
                "updated_at" => Carbon\Carbon::now(),
                'user_id' => Auth::user()->id
            ];
        }
        $req = Req::where('request_no', $id)->update($data);
        $req = Req::where('request_no', $id)->first();
        Mail::send(new UpdateRequest($req));
        return redirect()->route('request.index')->with('alert-success', 'Request : '.$req->subject.' Successfully Updated');

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

    public function export(){
        $req =  Req::where('requests.department_id', Auth::user()->department_id)
            ->join('departments', 'requests.department_id', '=', 'departments.id')
            ->join('services', 'requests.service_id', '=', 'services.id')
            //->join('users', 'requests.user_id', '=', 'users.id')
            //->whereNull('requests.user_id')
            //->orwhereNotNull('requests.user_id')
            ->select('request_no','requests.name','requests.subject','requests.description','requests.feedback','requests.status','requests.created_at', 'requests.updated_at', 'departments.department_name', 'services.service_name')
            ->get()->toArray();
        //return Excel::download($req);
        return Excel::create('request_'.date('YmdHis'),  function($excel) use($req){
            $excel->sheet('mysheet',  function($sheet) use($req){
                $sheet->fromArray($req);
            });
        })->download('xls');
    }
}
