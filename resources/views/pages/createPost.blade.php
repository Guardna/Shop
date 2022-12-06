@extends('layouts.front')

@section('title')
    Post create
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">
            <h3>Add post</h3>

            @isset($errors)
              @if($errors->any())
                @foreach($errors->all() as $error)
                  <div class="alert alert-danger"> {{ $error }} </div>
                @endforeach
              @endif
            @endisset
            <form action="{{ (isset($post))? asset('/posts/update/'.$post->postId) : asset('/posts/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" value="{{ (isset($post))? $post->naslov : old('naslov') }}"/>
              </div>
              <div class="form-group">
                <label>Body:</label>
                <textarea name="body" class="form-control" rows="7">{{ (isset($post))? $post->sadrzaj : old('sadrzaj') }}</textarea>
              </div>
                <div class="form-group">
                    <div>
                        <label>Color:</label>
                        <div class="">
                            <select class="form-control" name="pboje">
                                <option value="">Choose...</option>
                                @foreach($colors as $c)
                                    <option value="{{ $c->ColorId}}" {{ (isset($post) && $post->ColorId == $c->ColorId)? 'selected' : ((old('pboje')==$c->ColorId)? 'selected' : '' )}} > {{ $c->Name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label>Category:</label>
                        <div class="">
                            <select class="form-control" name="pkategorije">
                                <option value="">Choose...</option>
                                @foreach($categories as $t)
                                    <option value="{{ $t->CategoryId}}" {{ (isset($post) && $post->CategoryId == $t->CategoryId)? 'selected' : ((old('pkategorije')==$t->CategoryId)? 'selected' : '' )}} > {{ $t->Name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input type="text" name="cena" class="form-control" value="{{ (isset($post))? $post->price : old('price') }}"/>
                </div>
                @isset($post)
                <div class="form-group">
                    <label>Discount: </label>
                    <input type="text" name="popust" class="form-control" value="{{ (isset($post))? $post->popust : old('price') }}"/>
                </div>
                @endisset
              <div class="form-group">
                <label>Photo:
                    @isset($post)
                    @endisset
                </label>
                @isset($post)
                <img src="{{ asset($post->putanja) }}" width="35" height="35"/>
                @endisset
                <input type="file" name="photo" class="form-control"  />
              </div>
              <div class="form-group">
                <input type="submit" name="addPost" value="{{ (isset($post))? 'Change post' : 'Add post' }}" class="btn btn-default" />
              </div>
            </form>

            <table class="table">
                <tr>
                  <td>ID</td>
                  <td>Username</td>
                  <td>Title</td>
                  <td>Photo</td>
                    <td>Price</td>
                  <td>Create/Update Date</td>
                  <td>Role</td>
                  <td>Change</td>
                  <td>Delete</td>
                </tr>
                <!-- Prikaz postova-->
                @isset($postovi)
                @if(session()->get('user')[0]->naziv == 'admin')
                @foreach($postovi as $post)
                  <tr>
                    <td> {{ $post->postId }} </td>
                    <td> {{ $post->korisnicko_ime }} </td>
                    <td> {{ $post->naslov }} </td>
                    <td> <img src="{{ asset($post->putanja) }}" width="50" height="50" /> </td>
                      <td> {{ $post->price }} </td>
                    <td> {{ date("d.m.Y. H:i:s", $post->create) }}</br>@if($post->update!=null){{ date("d.m.Y. H:i:s", $post->update) }}@endif </td>
                    <td> {{ $post->naziv }} </td>
                    <td> <a href="{{ asset('/posts/'.$post->postId) }}">Change</a> </td>
                    <td> <a href="{{ asset('/posts/destroy/'.$post->postId) }}">Delete</a> </td>
                  </tr>
                @endforeach
                @endif
                @if(session()->get('user')[0]->naziv != 'admin')
                @foreach($postovi->where("korisnik_id", "=", session()->get('user')[0]->id) as $post)
                  <tr>
                    <td> {{ $post->postId }} </td>
                    <td> {{ $post->korisnicko_ime }} </td>
                    <td> {{ $post->naslov }} </td>
                    <td> <img src="{{ asset($post->putanja) }}" width="50" height="50" /> </td>
                      <td> {{ $post->price }} </td>
                    <td> {{ date("d.m.Y. H:i:s", $post->create) }}</br>@if($post->update!=null){{ date("d.m.Y. H:i:s", $post->update) }}@endif </td>
                    <td> {{ $post->naziv }} </td>
                    <td> <a href="{{ asset('/posts/'.$post->postId) }}">Change</a> </td>
                    <td> <a href="{{ asset('/posts/destroy/'.$post->postId) }}">Delete</a> </td>
                  </tr>
                @endforeach
                @endif
                @endisset
            </table>

        </div>
		<!--// Sadrzaj -->
@endsection
