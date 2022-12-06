@extends('layouts.front')

@section('title')
    Contact
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">
            <h3>Contact Us</h3>

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
            <form action="{{ url('contact-us')}}" method="POST">
              {{ csrf_field() }}
              <div class="form-group">
              <label>Name</label>
                <input type="text" name="name" class="form-control">
              </div>
              <div class="form-group">
              <label>E-mail</label>
                <input type="email" name="email" class="form-control">
              </div>
              <div class="form-group">
              <label>Message</label>
                <textarea name="message_body" class="form-control"></textarea>
              </div>
              <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
        </div>
		<!--// Sadrzaj -->
@endsection
