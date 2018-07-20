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
                            Request > Update Request
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(Session::has('alert-success')): ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo Session::get('alert-success') ?>.
                                    </div>
                                    <?php endif; ?>
                                    @foreach($req as $request)
                                    <div class="col-lg-6">
                                        <form method="post" action="{{ route('request.update', $request->request_no) }}" class="forms" enctype="multipart/form-data"> {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" placeholder="Enter text" name="name" value="{{$request->name}}" disabled>
                                                <span class="error"><?php echo $errors->first('name') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select id="status" name="status" class="form-control">
                                                    <option selected disabled> Choose One </option>
                                                    @if($request->status == 'open')
                                                        <option value="in progress"> In Progress </option>
                                                        <option value="3rd party"> 3rd Party </option>
                                                        <option value="closed"> Closed </option>
                                                        <option value="cancel"> Cancel </option>
                                                    @elseif($request->status == 'in progress')
                                                        <option value="3rd party"> 3rd Party </option>
                                                        <option value="closed"> Closed </option>
                                                        <option value="cancel"> Cancel </option>
                                                    @elseif($request->status == '3rd party')
                                                        <option value="in progress"> In Progress </option>
                                                        <option value="closed"> Closed </option>
                                                        <option value="cancel"> Cancel </option>
                                                    @endif
                                                </select>
                                                <span class="error"><?php echo $errors->first('status') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input class="form-control" placeholder="Enter text" name="subject" value="{{ $request->subject }}" disabled>
                                                <span class="error"><?php echo $errors->first('subject') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label>File</label><br>
                                                @if($request->file == '')
                                                    No File
                                                @else
                                                    <a href="{{ URL::to('file/'.$request->file) }}" target="_blank" class="button btn-md btn-default">Download</a>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Feedback</label>
                                                <textarea class="form-control" name="feedback" rows="5" value="{{ $request->description }}"></textarea>
                                                <span class="error"><?php echo $errors->first('feedback') ?></span>
                                            </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" placeholder="Enter text" name="email" type="email" value="{{ $request->email }}" disabled>
                                            <span class="error"><?php echo $errors->first('email') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="title">Service</label>
                                            <select id="service_id" name="service_id" class="form-control">
                                                <option selected disabled value="{{ $request->service_id }}"> {{ $request->service->service_name }} </option>
                                            </select>
                                            <span class="error"><?php echo $errors->first('service_id') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-1"><br><span id="loader"><small><i class="fa fa-spinner fa-3x fa-spin "></i></small></span></div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" placeholder="{{ $request->description }}" name="description" rows="5" value="{{ $request->description }}"></textarea>
                                            <span class="error"><?php echo $errors->first('description') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                    </form>
                                </div>
                                @endforeach
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
@endsection