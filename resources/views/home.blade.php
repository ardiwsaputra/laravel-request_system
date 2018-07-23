@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">
                        @if(!Auth::user())
                            Welcome
                        @elseif(Auth::user()->role=='admin')
                            Welcome, <small class="text-muted">{{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }}</small>
                        @else
                            Welcome, <small class="text-muted">{{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }} ( {{ Auth::user()->department->department_name }} )</small>
                        @endif
                    </h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Home
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if(!Auth::check() || Auth::user()->role == 'admin')
                                        <form action="{{ url()->current() }}">
                                            <div class="col-lg-2">
                                                <h6 align="center"> Search By Entry Date </h6>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="date" class="form-control" name="date1" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="date" class="form-control" name="date2" value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="col-lg-2">
                                                <select name="filter" class="form-control">
                                                    <option value="All"> All </option>
                                                    @foreach($department as $dep)
                                                        <option value="{{$dep->id}}">{{$dep->department_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-1">
                                                <button type="submit" class="btn btn-primary">
                                                    <small class="fa fa-search"></small>
                                                </button>
                                            </div>
                                        </form><br><br><br>
                                    @else
                                        <form action="{{ url()->current() }}">
                                            <div class="col-lg-2">
                                                <h6 align="center"> Search By Entry Date </h6>
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
                                        </form><br><br><br>
                                    @endif
                                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                    <script type="text/javascript">
                                        google.charts.load("current", {packages:["corechart"]});
                                        google.charts.setOnLoadCallback(drawChart);
                                        function drawChart() {
                                            var record={!! json_encode($requests) !!};
                                            console.log(record);
                                            // Create our data table.
                                            var data = new google.visualization.DataTable();
                                            data.addColumn('string', 'Request');
                                            data.addColumn('number', 'Total_Requests');
                                            for(var k in record){
                                                var v = record[k];

                                                data.addRow([k,v]);
                                                console.log(v);
                                            }
                                            var options = {
                                                title: 'Request',
                                                is3D: true,
                                            };
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                                            chart.draw(data, options);
                                        }
                                    </script>

                                    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
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
