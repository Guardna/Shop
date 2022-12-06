@extends('layouts.front')

@section('title')
    Home page
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">

          <h1 class="my-4">Our Flowers</h1>
          @isset($users)
          {{-- var_dump($cart) --}}
                <div class="card mb-4"><div class="container">
                        <div class="row">
          @foreach($users as $post)
            {{-- var_dump($post) --}}
          <!-- Blog Post --><div class="col-sm-3" >

            <img class="card-img-top" src="{{ asset('/').$post->putanja }}">
            <div class="card-body">
              <h6 class="card-title">{{ $post->naslov }}</h6>
              <p class="card-text">
                  {{ $post->price }}
              </p>
                @if($post->popust!=Null && $post->popust!=0)
                <p class="card-text">
                    <p class="text-success">Discount {{ $post->popust}}%<p>
                </p>
                @endif
                <a href="#post/{{$post->postId}}" class="btn btn-primary vise" onclick="showpost({{ $post->postId }})">Read More &rarr;</a>
                <div class="btn-group">
                    <button onclick="addToCart({{$post->postId}})" type="button" class="btn btn-secondary">Add To Cart</button>
                </div>
            </div>
            <div class="card-footer text-muted">
              Posted on {{ date("d.m.Y. H:i:s", $post->create) }} by
              <a href="#">{{ $post->korisnicko_ime }}</a>
            </div>

		<!--// Blog Post --></div>
                @endforeach
                @endisset
                        </div>
                    </div>             </div>
          <!-- Pagination -->
         <ul class="pagination justify-content-center mb-4">
           <li class="page-item">
            {{ $users->appends(['search' => request('search')])->links() }}
          </li>
         </ul>
        </div>
		<!--// Sadrzaj -->
@endsection
