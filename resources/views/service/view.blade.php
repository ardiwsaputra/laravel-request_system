@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Service</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Service > All Service
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(Session::has('alert-success')): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo Session::get('alert-success') ?>.
                                    </div>
                                    <?php endif; ?>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead align="center">
                                        <tr>
                                            <th><center>#</center></th>
                                            <th><center>Service Name</th>
                                            <th width="30%"><center>Status</th>
                                            <th width="25%"><center>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php(
                                            $no = 1 {{-- buat nomor urut --}}
                                            )
                                        {{-- loop all kendaraan --}}
                                        @if ($service->count() > 0)
                                            @foreach ($service as $services)
                                                <tr>
                                                    <td><center>{{ $no++ }}</center></td>
                                                    <td>{{ $services->service_name }}</td>
                                                    <td>
                                                        @if($services->active == 'y')
                                                            {{ 'Active' }}
                                                        @else
                                                            {{ 'Non Active' }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <center>
                                                            @if($services->active == 'y')
                                                                <form method="post" action="{{route('service.nonactive', ['id' => $services->id])}}" class="forms"> {{ csrf_field() }}
                                                                    <button type="submit" class="btn btn-sm btn-raised btn-danger"><small class="fa fa-close"></small></button>
                                                                </form>
                                                            @else
                                                                <form method="post" action="{{route('service.active', ['id' => $services->id])}}" class="forms"> {{ csrf_field() }}
                                                                    <button type="submit" class="btn btn-sm btn-raised btn-info"><small class="	fa fa-check"></small></button>
                                                                </form>
                                                            @endif
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">No Data</td>
                                            </tr>
                                        @endif
                                        {{-- // end loop --}}
                                        </tbody>
                                    </table>
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
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
@endsection