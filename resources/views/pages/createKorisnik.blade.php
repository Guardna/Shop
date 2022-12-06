@extends('layouts.front')

@section('title')
    User create
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">
            <h3>Add user</h3>

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

            <form action="{{ (isset($korisnik))? asset('/users/update/'.$korisnik->id)  : asset('/users/store') }}" method="POST" enctype="multipart/form-data">

              {{ csrf_field() }}

              <div class="form-group">
                <label>Username:</label>
                <input type="text" name="korisnickoIme" class="form-control" value="{{ (isset($korisnik))? $korisnik->korisnicko_ime : old('korisnickoIme') }}"/>
              </div>
              <div class="form-group">
                  @if(!isset($korisnik))
                <label>Password:</label>
                  @endif
                  @if(isset($korisnik))
                      <label>Old Password:</label>
                      <input type="password" name="lozinka1" class="form-control" value="{{ (isset($korisnik))? $korisnik->lozinka : old('lozinka1') }}"/>
                      <label>Password Confirmation:</label>
                      @endif
                <input type="password" name="lozinka" class="form-control" value="{{ (isset($korisnik))? old('lozinka') : old('lozinka') }}"/>
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
                @if(session()->has('user'))
                    @if(session()->get('user')[0]->naziv == 'admin')
              <div class="form-group">
                <label>Uloga:</label>
                <select name="ddlUloga">
                  <option value="0">Choose</option>

                  @foreach($uloge as $uloga)
                    <option value="{{ $uloga->id }}" {{ (isset($korisnik) && $korisnik->uloga_id == $uloga->id)? 'selected' : ((old('ddlUloga')==$uloga->id)? 'selected' : '' )}} > {{ $uloga->naziv }} </option>
                  @endforeach

                </select>
              </div>
                    @endif
                @endif
              <div class="form-group">
                <input type="submit" name="addKorisnik" value="{{ (isset($korisnik))? 'Change korisnik' : 'Add korisnik' }} " class="btn btn-default" />
              </div>
            </form>
            @if(session()->has('user'))
                @if(session()->get('user')[0]->naziv == 'admin')
            <table class="table">
                <tr>
                  <td>ID</td>
                  <td>Username</td>
                  <td>Photo</td>
                  <td>Create/Update Date</td>
                  <td>Role</td>
                  <td>Change</td>
                  <td>Delete</td>
                </tr>
                <!-- Prikaz korisnika-->
                @isset($korisnici)
                @foreach($korisnici as $korisnik)
                  <tr>
                    <td> {{ $korisnik->korisnikId }} </td>
                    <td> {{ $korisnik->korisnicko_ime }} </td>
                    <td> <img src="{{ asset($korisnik->slika) }}" width="75" height="75" style="border-radius: 500px; -moz-border-radius: 500px;" /> </td>
                    <td> {{ date("d.m.Y. H:i:s", $korisnik->created_at) }}</br>@if($korisnik->updated_at!=null){{ date("d.m.Y. H:i:s", $korisnik->updated_at) }}@endif </td>
                    <td> {{ $korisnik->naziv }} </td>
                    <td> <a href="{{ asset('/users/'.$korisnik->korisnikId) }}">Change</a> </td>
                    <td> <a href="{{ asset('/users/destroy/'.$korisnik->korisnikId) }}">Delete</a> </td>
                  </tr>
                @endforeach
                @endisset
            </table>
                @endif
                @endif
        </div>
		<!--// Sadrzaj -->
@endsection
