@if(!Session('adminverification'))
<script>window.location.replace("/adminpage")</script>
@else
@extends ('layout.header')
@section("success")
<div class="jumbotron">
    <h1 class="display-4">You Are Registered Successfully,</h1>
    <p class="lead">Now please activate your account. An activation code is sent to your email.</p>
    <hr class="my-4">
</div>

<div class="container">
    <form action="/adminverify" method="POST"  class="col-lg-6 col-md-5 col-sm-10 mt-5">
    @csrf
        <div class="form-group" style="display:none;">
            <input name="email"  value="{{ Session('adminverification') }}">
        </div> 
        <div class="form-group">
            <label class="display-4" style="font-size:1.5rem;">Activation code</label>
            <input name="activation_code" class="form-control" id="activation-code" required>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success btn-lg mt-3" value="Activate">
        </div>
        @if(Session('ActivationError'))
        <div class="alert-danger p-1 mt-2" style="font-size:1rem; position:absolute;">{{Session("ActivationError")}}</div>
        @endif
    </form>
</div>
@endsection

@endif