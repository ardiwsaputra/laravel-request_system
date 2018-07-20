@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">User</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User > All User
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="{{ url()->current() }}">
                                        <div class="col-lg-10">
                                            <input type="text" name="keyword" class="form-control" placeholder="Email or Name . . .">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-primary">
                                                <small class="fa fa-search"> Search </small>
                                            </button>
                                        </div>
                                    </form>
                                </div><br><br><br>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(Session::has('alert-success')): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo Session::get('alert-success') ?>.
                                    </div>
                                    <?php elseif(Session::has('alert-danger')): ?>
                                        <div class="alert alert-danger">
                                            <strong>Success!</strong> <?php echo Session::get('alert-danger') ?>.
                                        </div>
                                    <?php endif; ?>
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead align="center">
                                        <tr>
                                            <th><center>#</center></th>
                                            <th><center>Name</th>
                                            <th><center>Email</th>
                                            <th><center>Role</th>
                                            <th><center>Department</th>
                                            <th width="5%" colspan="2"><center>Action</center></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php(
                                            $no = 1 {{-- buat nomor urut --}}
                                            )
                                        {{-- loop all kendaraan --}}
                                        @if ($user->count() > 0)
                                            @foreach ($user as $users)
                                                <tr>
                                                    <td><center>{{ $no++ }}</center></td>
                                                    <td>{{ $users->name }}</td>
                                                    <td>{{ $users->email }}</td>
                                                    <td>{{ ucfirst($users->role) }}</td>
                                                    <td>
                                                        @if($users->role == 'admin')
                                                            <center> {{' - '}} </center>
                                                        @else
                                                           {{ $users->department->department_name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <a href="{{action('UsersController@show', $users['id'])}}" class="btn btn-sm btn-raised btn-info"><small class="fa fa-edit"></small></a>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center
                                                        <form method="post" action="{{route('user.destroy', ['id' => $users->id])}}" class="forms"> {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-sm btn-raised btn-danger"><small class="fa fa-trash"></small></button>
                                                        </form>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">No Data</td>
                                            </tr>
                                        @endif
                                        {{-- // end loop --}}
                                        </tbody>
                                    </table>
                                    <center>{!! $user->links() !!}</center>
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