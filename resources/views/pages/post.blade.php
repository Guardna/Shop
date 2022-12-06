@extends('layouts.front')

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection
@section('content')

@isset($singlePost)
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">


          <!-- Title -->
          <h1 class="mt-4">{{ $singlePost->naslov }}</h1>

          <!-- Author -->
          <p class="lead">
            by
            <a href="#">{{ $singlePost->postKorisnik }}</a>
          </p>

          <hr>

          <!-- Date/Time -->
          <p>Posted on {{ date("d.m.Y. H:i:s", $singlePost->create) }}</p>

          <hr>

          <!-- Preview Image -->
          <img class="img-fluid rounded" src="{{ asset('/'.$singlePost->putanja)}}">

          <hr>

          <!-- Post Content -->
          <p> {{ $singlePost->sadrzaj }}</p>

		  <hr>
            <p> {{ $singlePost->price }}</p>

            <hr>
            @if($singlePost->popust!=Null && $singlePost->popust!=0)
                <p class="card-text">
                <p class="text-success">Discount {{ $singlePost->popust}}%<p>
                </p>
            @endif
          <!-- Comments Form -->
          @if(session()->get('user'))


          <div class="card my-4">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
                <form action="#" method="get">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea class="form-control" id="psalji" rows="3" name="content"></textarea>
                    </div>
                    <button name="akcija" value="post" onclick="salji({{$singlePost->postId}})" class="btn btn-primary salji">Submit</button>
                </form>

                <br>
                @if(session('success'))
                    <div class="alert alert-success">
                    {{ session('success') }}
                    </div>
                @endif
                @if(session('warning'))
                    <div class="alert alert-warning">
                    {{ session('warning') }}
                    </div>
                @endif
            </div>
          </div>
          @else
          <h4>Da bi komentarisali morate da se ulogujete.</h4>
          @endif
          <div hidden>
          <form id="pform" action="{{ route("editComment", ['postId' => $singlePost->postId],['commentId' =>"2"]) }}" method="post">
                  {{ csrf_field() }}
                <div class="form-group">
                  <textarea class="form-control" id="txta" rows="3" name="content1"></textarea>
                </div>
                <button type="submit" name="akcija" value="edit" class="btn btn-primary">Update</button>
              </form>
          </div>
		  <!--// Comments Form -->

          <!-- Single Comment -->

               @isset($comments)
                @include('components.comments')
               @endisset



		<!--// Single Comment -->

        </div>
		<!--// Sadrzaj -->
@endisset
@endsection
