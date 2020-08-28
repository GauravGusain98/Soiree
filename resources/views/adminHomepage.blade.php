@extends ("layout.header")
@if(!Session('adminsuccess'))
<script>window.location.replace("http://soiree.test/adminpage")</script>
@endif


@section("adminHomepage")
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/admin/home') }}">
            Soiree
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{Session('adminsuccess')}} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/adminlogout"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="/adminlogout" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
@if(Session('AdminVerified'))
<div class="container">
    <div class="text-success" style="font-size:1.5rem">{{Session('AdminVerified')}}</div>
</div>
@endif

<div class="container">
    <button class="btn btn-primary mt-3" id="show-requests-btn">Invitation Requests</button>
    <button class="btn btn-primary mt-3 ml-2" id="show-guests-btn">Guests</button>
    <button class="btn btn-primary mt-3 ml-2" id="show-cancelled-btn">Cancelled Requests</button>
</div>

<div class="container mt-4">
<table id="requests-table" class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="table-data">

    </tbody>
</table>
</div>

<div class="container mt-4 " >
<table id="guests-table" class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody id="guests-data">
    </tbody>
</table>
</div>

<div class="container mt-4 " >
<table id="cancelled-requests-table" class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>change the status</th>
        </tr>
    </thead>
    <tbody id="cancelled-requests-data">
    </tbody>
</table>
</div>

@endsection