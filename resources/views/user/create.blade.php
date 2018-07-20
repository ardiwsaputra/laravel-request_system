@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Users</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Users > Add User
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(Session::has('alert-success')): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo Session::get('alert-success') ?>.
                                    </div>
                                    <?php endif; ?>
                                    <form method="post" action="{{ route('user.store') }}" class="forms"> {{ csrf_field() }}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" placeholder="Enter text" name="name">
                                                <span class="error"><?php echo $errors->first('name') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" placeholder="Enter text" name="email" type="email">
                                                <span class="error"><?php echo $errors->first('email') ?></span>
                                            </div>
                                            @if(Auth::user()->role == 'admin')
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select class="form-control" name="role">
                                                    <option selected disabled>Choose one</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="operator">Operator</option>
                                                    <option value="agent">Agent</option>
                                                </select>
                                                <span class="error"><?php echo $errors->first('role') ?></span>
                                            </div>
                                            @endif
                                        </div>
                                        <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" placeholder="Enter text" name="password" type="password">
                                            <span class="error"><?php echo $errors->first('password') ?></span>
                                        </div>
                                        @if(Auth::user()->role == 'admin')
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control" name="department_id">
                                                <option selected disabled>Choose one</option>
                                                @foreach($department as $departments)
                                                    <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                                @endforeach
                                                <option value=""> - </option>
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <!-- /.col-lg-6 (nested) -->
                                </form>
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
@endsection