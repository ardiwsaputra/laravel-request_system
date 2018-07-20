@extends('layouts.app')
@section('content')
    <style>
        #loader{
            visibility:hidden;
        }
    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Department</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Department > Add Department
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(Session::has('alert-success')): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo Session::get('alert-success') ?>.
                                    </div>
                                    <?php endif; ?>
                                    <div class="col-lg-6">
                                        <form method="post" action="{{ route('department.store') }}" class="forms"> {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Department Name</label>
                                                <input class="form-control" placeholder="Enter text" name="department_name">
                                                <span class="error"><?php echo $errors->first('department_name') ?></span>
                                            </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Active</label>
                                            <select class="form-control" name="active">
                                                <option selected disabled>Choose one</option>
                                                <option value="y">Yes</option>
                                                <option value="n">No</option>
                                            </select>
                                            <span class="error"><?php echo $errors->first('active') ?></span>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
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