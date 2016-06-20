@extends('admin.layout.master')

@section('content')


    @if(count($errors) > 0)
        <section class="info-box fail">
            {{$errors}}
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    @if( Session::has('fail'))
        <section class="info-box fail">
            {{$errors}}
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ Session::get('fail') }}</li>
                @endforeach
            </ul>
        </section>
    @endif



    <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="text-center">Login</h1>
            </div>
            <div class="modal-body">
                {{--<form class="form col-md-12 center-block">--}}

                    {!! Form::open(['name' => 'frm_admin_login',
         'class' => 'form col-md-12 center-block']) !!}


                    <div class="form-group">
                        {{--<input type="text" class="form-control input-lg" placeholder="Email">--}}

                        {!! Form::text('name', null, [
                                'id'    => 'name',
                                'class' => 'form-control input-lg',
                                'placeholder' => 'your name'
                                ]) !!}

                @if ($errors->has('name'))
                    <p class="help-block alert alert-danger">{{ $errors->first('name') }}</p>
                @endif
                    </div>
                    <div class="form-group">
                        {{--<input type="password" class="form-control input-lg" placeholder="Password">--}}
                    {{--</div>--}}

                {!! Form::password('password', [
                                'class'=>'form-control input-lg',
                                'placeholder'=>'your password'
                                ]) !!}

                        {{--<input type="password" class="form-control input-lg" placeholder="Password">--}}
                @if ($errors->has('password'))
                    <p class="help-block alert alert-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>



                    <div class="form-group">
                        {{--<button class="btn btn-primary btn-lg btn-block">Sign In</button>--}}


                        {!! Form::submit('Login', ['class' => 'btn btn-primary btn-lg btn-block']) !!}



                    </div>
                {{--</form>--}}
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {{--<div class="col-md-12">--}}
                    {{--<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    </div>
    <!-- script references -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
@endsection