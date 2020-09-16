@extends ('layout.header')



@section('guestlogin')
<div class="navbar text-light bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand display-4" href="http://wordpress.local" style="font-size:1.5rem;">  Soiree    </a>
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
    <span class="navbar-toggler-icon"></span>
    </button> -->

    <!-- <div class="collapse navbar-collapse"> -->
        <a  href="http://wordpress.local" class="nav-link display-4" style="font-size:1.5rem;">  Register   </a>
    <!-- </div> -->
    </div>
</div>
<br><br>
<div class="container">
        <p class="display-4" style="font-size:2rem;"> Kindly login to see the details of event.</p><hr class="my-4">
</div>


<div class="container" id="guest-login">
        <form action="{{route('guest_login')}}" method="post" class="col-sm-10 col-lg-6">
        @csrf
            <div class="form-group">
                <label>Email: </label>
                <input class="form-control shadow" type="email" name="guestEmail" required>
            </div>
            <div class="form-group">
                <label>Password: </label>
                <input name="password" class="form-control shadow" type="password" required>
            </div>
            <input id="guest-login-submit"class="btn btn-success shadow" type="submit" value="Login" >
        </form>
        @if(Session('error'))     <!--error condition method 1-->
        <h6 style="color:red;" class="mx-4">{{Session('error')}}</h6>
        @endif
</div>

@endsection
