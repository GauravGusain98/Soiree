@extends ('layout.header')

@section ("success")
<div class="jumbotron">
    <h1 class="display-4">Registered Successfully,</h1>
    <p class="lead">A activation link is sent to your email. Please activate your account from the link.</p>
    <hr class="my-4">
    <p>After activating your account, Login from here</p>
    <button id="login-btn" class="btn btn-success btn-lg">Login</button>
</div>

@endsection