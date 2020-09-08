@extends('layout.header')

@if(Session("adminsuccess"))
<script>window.location.replace("/admin/home")</script>
@endif

<div class="navbar text-light bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand display-4" href="http://wordpress.local" style="font-size:1.5rem;">  Soiree    </a>
    </div>
</div>  
<br>

@section ('adminButtons')
    <div class="container">
        <br><br>
        <p class="display-4">Hello Admin,</p> 
        <h4> Please login to Enter the Admin panel of Soiree.<h4>
        <hr>
        <br>
        <button class="btn btn-outline-primary" id="admin-login-btn">Login</button>
        <button class="btn btn-outline-dark" id="admin-register-btn">Register</button>
        <br>
        @if($errors->any())     <!--error condition method 1-->
        <div class="alert-danger p-1 mt-2" style="font-size:1rem; position:absolute;">There are errors in the form.</div>
        @endif
        @if(Session('error'))     <!--error condition method 1-->
        <span class="alert-danger p-1 mt-2" style="font-size:1rem; position:absolute;">Wrong Login Credentials.</span>
        @endif


    </div>
@endsection

@section ("adminLogin")
    <div class="container" id="admin-login">
        <form action="{{ route('admin-login') }}" method="get" class="col-sm-10 col-lg-6">
        @csrf
            <div class="form-group">
                <label>Email: </label>
                <div class="input-group">   
                    <input class="form-control shadow @error('loginEmail') border-danger @enderror" type="text" name="loginEmail" value="{{old('loginEmail')}}" placeholder="Anything after @ will be ignored" required>
                    <span class="input-group-append input-group-text">@company.com</span>
                </div>
            </div>
            <div class="form-group">
                <label>Password: </label>
                <input name="password" class="form-control shadow @error('password') border-danger @enderror" type="password" required>
            </div>
            <input id="admin-login-submit"class="btn btn-success shadow" type="submit" value="Login"> 
        </form>
    </div>
@endsection

@section ("adminRegister")
    <div class="container" id="admin-register">
        <form action="{{ route('admin-registration') }}" method="post" class="col-sm-10 col-lg-6">
        @csrf
            <div class="form-group">
                <label>Name: </label>
                <input class="form-control shadow @error('name') border-danger @enderror" type="text" name="name" value="{{old('name')}}" required>
                @error('name')
                <p style="color:red;">{{$errors->first('name')}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Email: </label>
                <div class="input-group">
                    <input class="form-control shadow @error('email') border-danger @enderror" type="text" name="email" value="{{old('email')}}" placeholder="Anything after @ will be ignored" required>
                    <span class="input-group-append input-group-text">@company.com</span>
                </div>
                @error('email')
                <p style="color:red;">{{$errors->first('email')}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Password: </label>
                <input class="form-control shadow @error('password1') border-danger @enderror" type="password" name="password1" required>
                @if($errors->has('password1'))
                <p style="color:red;">{{$errors->first('password1')}}</p>
                @endif
            </div>
            <div class="form-group">
                <label>Retype Password: </label>
                <input class="form-control shadow @error('password2') border-danger @enderror" type="password" name="password2" required>
                @if($errors->has('password2'))
                <p style="color:red;">{{$errors->first('password2')}}</p>
                @endif
            </div>
            <input id="admin-register-submit" class="btn btn-success shadow" type="submit" value="Register"> 
        </form>
    </div>
@endsection     