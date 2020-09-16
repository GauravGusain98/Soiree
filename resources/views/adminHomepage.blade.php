@extends ("layout.header")

@section("adminHomepage")
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('http://wordpress.local') }}" target="_blank">
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
                        {{Session('adminSuccess')[0]->name}} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('admin-logout')}}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{route('admin-logout')}}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
@if(Session('Activated'))
<div class="container">
    <div class="text-success" style="font-size:1.5rem">{{Session('Activated')}}</div>
</div>
@endif

<div class="container">
    <button class="btn btn-primary mt-3 ml-2 show-function-btn">Show Functions</button>
    <button class="btn btn-primary mt-3 ml-2" id="show-add-function-btn">Add a Function</button>
    <button class="btn btn-primary mt-3 ml-2" id="show-requests-btn">Invitation Requests</button>
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

<div id="add-function-container" class="container mt-4">
    <form action="" method="post" id="add-function" class="col-lg-6 col-md-8 col-sm-12">
        @csrf
        <div class="form-group">
            <label>Function Name</label>
            <input name="function-name" class="form-control" type='text' required>
        </div>
        <div class="form-group">
            <label>Function date</label>
            <input name="function-date" class="form-control" type='date' required>
        </div>

        <div class="form-group">
            <label>Function time</label>
            <input name="function-time" class="form-control" type='time' required>
        </div>
    </form>
    <input type="submit" id="add-event-btn" class="ml-3 btn btn-light shadow btn-outline-dark" value= "Add an Event">
    <input type="submit" id="save-function-btn" class="ml-2 btn btn-light shadow btn-outline-dark px-4" value="Save">
    <div id="error" class="ml-3 mt-1">Please fill all the fields.</div>
</div>

<div id="show-function-container" class="container mt-4">
</div>


@endsection
