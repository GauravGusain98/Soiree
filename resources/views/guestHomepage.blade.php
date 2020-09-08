@extends ("layout.header")
@if(!Session('guestsuccess'))
<script>window.location.replace("{{route('guest-login')}}")</script>
@endif

@if(Session('guestsuccess'))
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('http://wordpress.local') }}">
                    Soiree
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                               Hello, {{json_decode(Session::get('guestsuccess'))->name}} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('guest-logout')}}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{route('guest-logout')}}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
<div class="container text-center mt-4">
    <h1 style="font-size:3em;">Welcome to {{json_decode(Session::get('guestsuccess'))->function}}  </h1>
</div>
<div class="container col-lg-9 col-md-10 col-sm-11 mt-4">
    <div id="carousel" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 h-50" src="https://dwkujuq9vpuly.cloudfront.net/news/wp-content/uploads/2018/04/Concert-crowd-960x480.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-50" src="https://pbs.twimg.com/media/DL3fw5YW4AAHlDd.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-50 " src="https://st2.depositphotos.com/1000291/5463/i/450/depositphotos_54636593-stock-photo-guest-hand-and-glass-with.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<div class="container col-lg-9 col-md-10 col-sm-11 mt-3">
    <p style="font-size:1.3em;">Get ready for Soiree September 2020. Many ventures and ideas are waiting for you. Get a chance to meet many business tycoons and investors. This is a great chance for transforming your ideas into a great business. This time Soiree is coming up with many new events and functions. So, quickly register to get the invitation of Soiree September 2020.</p>
    <div>
        <h1 style="text-decoration: underline;">Event Schedule:</h1>
        <ul>
            <li><p style="font-size: 1.2em;">Function start : {{json_decode(Session::get('guestsuccess'))->time }} </p></li>
        <?php
            for($i=1;$i<=json_decode(Session::get('guestsuccess'))->count;$i++){
                $event= "event".$i;
                $time= "eventTime".$i;
        ?>
            <li><p style="font-size: 1.2em;">{{json_decode(Session::get('guestsuccess'))->$event }} : {{json_decode(Session::get('guestsuccess'))->$time }}  </p></li>
        <?php
            }
        ?>
        </ul>
    </div>
    <div>
        <h1 style="text-decoration: underline;">Guests:</h1>
        <ul id="guests-list">
            @foreach(App\Guest::where("verified",1)->get('name') as $guest)
                <li><p style="font-size: 1.2em;">{{$guest->name}}</p></li>
            @endforeach
        </ul>
    </div>
</div>

@endif
