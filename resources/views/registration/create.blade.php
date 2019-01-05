@include('layouts.app')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong><h3>Register</h3></strong></div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ action('RegistrationController@create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('teamName') ? ' has-error' : '' }}">
                            <label for="teamName" class="col-md-4 control-label">Team Name</label>

                            <div class="col-md-6">
                                <input id="teamName" type="text" class="form-control" placeholder="Input your team name" name="teamName" value="{{ old('teamName') }}" required autofocus>

                                {{--check if there's an error when receiving the input--}}
                                @if ($errors->has('teamName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('teamName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('emailOne') ? ' has-error' : '' }}">
                            <label for="emailOne" class="col-md-4 control-label">E-Mail Address 1</label>

                            <div class="col-md-6">
                                <input id="emailOne" type="email" class="form-control" name="emailOne" value="{{ old('emailOne') }}" placeholder="Input email of 1st member" required>

                                @if ($errors->has('emailOne'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailOne') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('emailTwo') ? ' has-error' : '' }}">
                            <label for="emailTwo" class="col-md-4 control-label">E-Mail Address 2</label>

                            <div class="col-md-6">
                                <input id="emailTwo" type="email" class="form-control" name="emailTwo" placeholder="Leave blank if only one member" value="{{ old('emailTwo') }}">

                                @if ($errors->has('emailTwo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailTwo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('emailThree') ? ' has-error' : '' }}">
                            <label for="emailThree" class="col-md-4 control-label">E-Mail Address 3</label>

                            <div class="col-md-6">
                                <input id="emailThree" type="email" class="form-control" name="emailThree" placeholder="Leave blank if only one member" value="{{ old('emailThree') }}">

                                @if ($errors->has('emailThree'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailThree') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contactNumber') ? ' has-error' : '' }}">
                            <label for="contactNumber" class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input id="contactNumber" type="" class="form-control" name="contactNumber" value="{{ old('contactNumber') }}" placeholder="Input your contact number" required>

                                @if ($errors->has('contactNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contactNumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>

                    </form>

                    <div id="app">
                        <example></example>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
