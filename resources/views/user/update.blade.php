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
                            Users > Update User
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                @foreach($user as $u)
                                    <form method="post" action="{{ route('user.update', $u->id) }}" class="forms"> {{ csrf_field() }}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" name="name" value="{{ $u->name }}">
                                                <span class="error"><?php echo $errors->first('name') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" name="email" type="email" value="{{ $u->email }}">
                                                <span class="error"><?php echo $errors->first('email') ?></span>
                                            </div>
                                            @if(Auth::user()->role == 'admin')
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <select class="form-control" name="role">
                                                    @if($u->role == 'admin')
                                                        <option value="admin">Admin</option>
                                                        <option value="operator">Operator</option>
                                                        <option value="agent">Agent</option>
                                                    @elseif($u->role == 'operator')
                                                        <option value="operator">Operator</option>
                                                        <option value="agent">Agent</option>
                                                    @elseif(($u->role == 'agent'))
                                                        <option value="agent">Agent</option>
                                                        <option value="operator">Operator</option>
                                                    @endif
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
                                        </div>
                                        <br>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                        </div>
                                        <!-- /.col-lg-6 (nested) -->
                                    </form>
                                    @endforeach
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