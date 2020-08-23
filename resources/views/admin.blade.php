@extends('layout.header')

@section ('adminButtons')
    <div class="container">
        <br><br>
        <p class="display-4">Hello Admin,</p> 
        <h4> Please login to Enter the Admin panel of Soiree.<h4>
        <hr>
        <br>
        <button class="btn btn-outline-primary" id="admin-login-btn">Login</button>
        <button class="btn btn-outline-dark" id="admin-register-btn">Register</button>
        @if($errors->any())
        <h6 style="color:red;">There are errors in the form.</h6>
        @endif
    </div>
@endsection

@section ("adminLogin")
    <div action="/admin" method="get" class="container" id="admin-login">
        <form class="col-sm-10 col-lg-6">
        @csrf
            <div class="form-group">
                <label>Email: </label>
                <div class="input-group">
                    <input class="form-control shadow" type="text" name="email">
                    <span class="input-group-append input-group-text">@company.com</span>
                </div>
            </div>
            <div class="form-group">
                <label>Password: </label>
                <input class="form-control shadow" type="password">
            </div>
            <input class="btn btn-success shadow" type="submit" value="Login"> 
        </form>
    </div>
@endsection

@section ("adminRegister")
    <div class="container" id="admin-register">
        <form action="/admin" method="post" class="col-sm-10 col-lg-6">
        @csrf
            <div class="form-group">
                <label>Name: </label>
                <input class="form-control shadow" type="text" name="name">
                <p style="color:red;">{{$errors->first('name')}}</p>
            </div>
            <div class="form-group">
                <label>Email: </label>
                <div class="input-group">
                    <input class="form-control shadow" type="text" name="email">
                    <span class="input-group-append input-group-text">@company.com</span>
                </div>
                <p style="color:red;">{{$errors->first('email')}}</p>
            </div>
            <div class="form-group">
                <label>Password: </label>{{$errors->first('password')}}
                <input class="form-control shadow" type="password" name="password1">
                <p style="color:red;">{{$errors->first('password1')}}</p>
            </div>
            <div class="form-group">
                <label>Retype Password: </label>
                <input class="form-control shadow" type="password" name="password2">
                <p style="color:red;">{{$errors->first('password2')}}</p>
            </div>
            <input class="btn btn-success shadow" type="submit" value="Register"> 
        </form>
    </div>
@endsection