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
                    <h3 class="page-header">Request</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Request > Add Request
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
                                        <form method="post" action="{{ route('request.store') }}" class="forms" enctype="multipart/form-data"> {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" placeholder="Enter text" name="name">
                                                <span class="error"><?php echo $errors->first('name') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select id="department_id" name="department_id" class="form-control">
                                                    <option selected disabled> Choose One </option>
                                                    @foreach ($department as $departments => $value)
                                                        <option value="{{ $departments }}"> {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error"><?php echo $errors->first('department_id') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input class="form-control" placeholder="Enter text" name="subject">
                                                <span class="error"><?php echo $errors->first('subject') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label>File</label>
                                                <input class="form-control" placeholder="Enter text" name="filename" type="file">
                                                <span class="error"><?php echo $errors->first('filename') ?></span>
                                            </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" placeholder="Enter text" name="email" type="email">
                                            <span class="error"><?php echo $errors->first('email') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="title">Service</label>
                                            <select id="service_id" name="service_id" class="form-control">
                                                <option selected disabled>-- Select Department First --</option>
                                            </select>
                                            <span class="error"><?php echo $errors->first('service_id') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-1"><br><span id="loader"><small><i class="fa fa-spinner fa-3x fa-spin "></i></small></span></div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" placeholder="Enter text" name="description" rows="5"></textarea>
                                            <span class="error"><?php echo $errors->first('description') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script language="JavaScript" type="text/JavaScript">

        $(document).ready(function() {

            $('select[name="department_id"]').on('change', function(){
                var departmentId = $(this).val();
                if(departmentId) {
                    $.ajax({
                        url: '/request/getService/'+departmentId,
                        type:"GET",
                        dataType:"json",
                        beforeSend: function(){
                            $('#loader').css("visibility", "visible");
                        },

                        success:function(data) {
                            $('select[name="service_id"]').empty();
                            $('select[name="service_id"]').append('<option selected disabled> Choose One </option>');
                            $.each(data, function(key, value){
                                $('select[name="service_id"]').append('<option value="'+ key +'">' + value + '</option>');
                            });
                        },
                        complete: function(){
                            $('#loader').css("visibility", "hidden");
                        }
                    });
                } else {
                    $('select[name="service_id"]').append('<option selected disabled> - </option>');
                }

            });

        });

    </script>
@endsection