@include('layouts.app')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong><h3>Login</h3></strong></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ action('LoginController@doLogin') }}">
                        {{ csrf_field() }}

                        <div class="form-group {{$errors->has('teamName')? ' has-error':''}}">
                            <label for="teamName" class="col-md-4 control-label">Team Name</label>

                            <div class="col-md-6">
                                <input id="teamName" name="teamName" class="form-control" value="{{old('teamName')}}">
                            </div>

                            @if ($errors->has('teamName'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('teamName') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group {{$errors->has('password')? ' has-error':''}}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" name="password" class="form-control" type="password">
                            </div>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>

                        @if(count($errors))
                            <div class="form-group-sm">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>