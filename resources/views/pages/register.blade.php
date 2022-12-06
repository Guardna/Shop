@extends('layouts.front')

@section('title')
    Korisnik create
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">
            <h3>Register</h3>

            @empty(!session('message'))
              {{ session('message') }}
            @endempty

            @isset($errors)
              @if($errors->any())
                @foreach($errors->all() as $error)
                  <div class="alert alert-danger"> {{ $error }} </div>
                @endforeach
              @endif
            @endisset

            <form action="{{ asset('/register/store') }}" method="POST" enctype="multipart/form-data">

              {{ csrf_field() }}

              <div class="form-group">
                <label>Username:</label>
                <input type="text" name="korisnickoIme" class="form-control" value="{{ (isset($korisnik))? $korisnik->korisnicko_ime : old('korisnickoIme') }}"/>
              </div>
              <div class="form-group">
                <label>Password:</label>
                <input type="password" name="lozinka" class="form-control" value="{{ (isset($korisnik))? $korisnik->lozinka : old('lozinka') }}"/>
              </div>
                <div class="form-group">
                    <label>Name and Surname:</label>
                    <input type="text" name="imeprezime" class="form-control" value="{{ (isset($korisnik))? $korisnik->ImePrezime : old('imeprezime') }}"/>
                </div>
                <div class="form-group">
                    <label>Address:</label>
                    <input type="text" name="adresa" class="form-control" value="{{ (isset($korisnik))? $korisnik->BillingAddress : old('adresa') }}"/>
                </div>
                <div class="form-group">
                    <label>City:</label>
                    <input type="text" name="grad" class="form-control" value="{{ (isset($korisnik))? $korisnik->BillingCity : old('grad') }}"/>
                </div>
                <div class="form-group">
                    <label>State:</label>
                    <input type="text" name="opstina" class="form-control" value="{{ (isset($korisnik))? $korisnik->BillingState : old('opstina') }}"/>
                </div>
                <div class="form-group">
                    <label>Postal Code:</label>
                    <input type="text" name="postanski" class="form-control" value="{{ (isset($korisnik))? $korisnik->BillingPostalCode : old('postanski') }}"/>
                </div>
                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" name="telefon" class="form-control" value="{{ (isset($korisnik))? $korisnik->Phone : old('telefon') }}"/>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="email" class="form-control" value="{{ (isset($korisnik))? $korisnik->email : old('email') }}"/>
                </div>
              <div class="form-group">
                <label>Photo:</label>


            @isset($korisnik)
                  <img src="{{ asset($korisnik->slika) }}" width="35" height="35" style="border-radius: 500px; -moz-border-radius: 500px; margin-top: 2px;"/>
                @endisset


                <input type="file" name="slika" class="form-control"  />

              </div>
              <div class="form-group">
                <input type="submit" name="addKorisnik" value="Register" class="btn btn-default" />
              </div>
            </form>
        </div>
		<!--// Sadrzaj -->
@endsection
