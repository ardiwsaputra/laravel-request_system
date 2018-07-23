@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Request</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Request > All Request
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(Session::has('alert-success')): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo Session::get('alert-success') ?>.
                                    </div>
                                    <?php endif; ?>
                                    @if(!Auth::check() || Auth::user()->role == 'admin')
                                        <form action="{{ url()->current() }}">
                                            <div class="col-lg-3">
                                                <input type="text" name="keyword" class="form-control" placeholder="ID or Name . . .">
                                            </div>
                                            <div class="col-lg-2">
                                                <select name="department" class="form-control">
                                                    <option value="All"> All </option>
                                                    @foreach($department as $dep)
                                                        <option value="{{$dep->id}}">{{$dep->department_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="date" class="form-control" name="date1" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="date" class="form-control" name="date2" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="submit" class="btn btn-primary">
                                                    <small class="fa fa-search"></small>
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ url()->current() }}">
                                            <div class="col-lg-4">
                                                <input type="text" name="keyword" class="form-control" placeholder="ID or Name . . .">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="date" class="form-control" name="date1" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="date" class="form-control" name="date2" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="submit" class="btn btn-primary">
                                                    <small class="fa fa-search"></small>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="{{ url()->current() }}">
                                        <div class="col-lg-2">
                                            <select name="filter" class="form-control">
                                                <option value="request_no"> ID </option>
                                                <option value="created_at"> DATE </option>
                                                <option value="status"> STATUS </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select name="sort" class="form-control">
                                                <option value="asc">ASC</small></option>
                                                <option value="desc">DESC</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="submit" class="btn btn-primary">
                                                <small class="fa fa-sort"></small>
                                            </button>
                                        </div>
                                    </form>
                                    @if(Auth::check())
                                        <div class="col-lg-2">
                                            <?php
                                                $qs = url()->full();
                                                if (strpos($qs,'?')){
                                                    $qs = explode('?', $qs);
                                                    $qs = $qs[1];
                                                } else {
                                                    $qs = '';
                                                }
                                            ?>
                                            <a href="{{ "request/export?".$qs }}" target="_blank" class="btn btn-success">Export</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example23" width="100%" class="table table-striped table-bordered table-hover">
                                        <thead align="center">
                                        <tr>
                                            <th width="3%"><center>#</center></th>
                                            <th width="3%"><center> ID </th>
                                            <th><center> Name </center></th>
                                            <th><center> Subject </center></th>
                                            <th><center> Department </center></th>
                                            <th width="10%"><center> Created </center></th>
                                            <th width="10%"><center> Updated </center></th>
                                            <th width="5%"><center> File </center></th>
                                            <th width="5%"><center> Status </center></th>
                                            @if(Auth::check())
                                                @if(Auth::user()->role == 'agent')
                                                    <th width="10%"><center> Agent </center></th>
                                                    <th width="5%"><center> Action </center></th>
                                                @else
                                                    <th width="10%"><center> Agent </center></th>
                                                @endif
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php(
                                            $no = 1 {{-- buat nomor urut --}}
                                            )
                                        {{-- loop all kendaraan --}}
                                        @if ($req->count() > 0)
                                            @foreach ($req as $request)
                                                <tr>
                                                    <td><center><b>{{ $no++ }}</b></center></td>
                                                    <td><center>{{ $request->request_no }}</center></td>
                                                    <td>{{ $request->name }}</td>
                                                    <td>{{ $request->subject }}</td>
                                                    <td>{{ $request->department->department_name }}</td>
                                                    <td width="10%"><center>{{ $request->created_at }}</center></td>
                                                    <td width="10%"><center>{{ $request->updated_at }}</center></td>
                                                    <td>
                                                        <center>
                                                            @if($request->file == '')
                                                                No
                                                            @else
                                                                @if(!Auth::check())
                                                                    Yes
                                                                @else
                                                                    <a href="{{ URL::to('file/'.$request->file) }}" target="_blank" class="button btn-sm btn-default">Download</a>
                                                                @endif
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td width="10%">
                                                        <center>
                                                            @if($request->status == 'open')
                                                                <small class="button btn-sm btn-raised btn-danger"> Open </small>
                                                            @elseif($request->status == 'in progress')
                                                                <small class="button btn-sm btn-raised btn-warning"> In Progress </small>
                                                            @elseif($request->status == '3rd party')
                                                                <small class="button btn-sm btn-raised btn-info"> 3rd Party </small>
                                                            @elseif($request->status == 'closed')
                                                                <small class="button btn-sm btn-raised btn-success"> Closed </small>
                                                            @elseif($request->status == 'cancel')
                                                                <small class="button btn-sm btn-raised btn-success"> Cancel </small>
                                                            @endif
                                                        </center>
                                                    </td>
                                                    @if(Auth::check())
                                                        @if(Auth::user()->role == 'agent')
                                                            <td>
                                                                @if($request->user_id == '')
                                                                    -
                                                                @else
                                                                    {{ $request->user->name }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    @if($request->status == 'closed' || $request->status == 'cancel')
                                                                        <a class="btn btn-sm btn-raised btn-info"><small class="fa fa-edit"></small></a>
                                                                    @else
                                                                        <a href="{{action('RequestsController@show', $request['request_no'])}}" class="btn btn-sm btn-raised btn-info"><small class="fa fa-edit"></small></a>
                                                                    @endif
                                                                </center>
                                                            </td>
                                                        @else
                                                            <td>
                                                                @if($request->user_id == '')
                                                                    -
                                                                @else
                                                                    {{ $request->user->name }}
                                                                @endif
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr>
                                                @if(!Auth::check())
                                                    <td colspan="9" align="right">Total Request : {{ \App\Req::count() }}</td>
                                                @else
                                                    <td colspan="11" align="right">Total Request : {{ \App\Req::where('department_id', Auth::user()->department_id)->count() }}</td>
                                                @endif
                                            </tr>
                                        @else
                                            <tr>
                                                @if(!Auth::check())
                                                    <td colspan="9">No Data</td>
                                                @else
                                                    <td colspan="11">No Data</td>
                                                @endif
                                            </tr>
                                        @endif
                                        {{-- // end loop --}}
                                        </tbody>
                                    </table>
                                    <center>{!! $req->links() !!}</center>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <!-- Metis Menu Plugin JavaScript -->
    <script src=" {{ asset('/vendor/metisMenu/metisMenu.min.js') }}"></script>

    <!-- DataTables JavaScript -->
    <script src=" {{ asset('/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src=" {{ asset('/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src=" {{ asset('/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>


    <!-- Custom Theme JavaScript -->
    <script src=" {{ asset('/dist/js/sb-admin-2.js') }}"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

@endsection