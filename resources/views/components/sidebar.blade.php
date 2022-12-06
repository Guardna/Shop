<!-- Desna strana -->
        <div class="col-md-4">
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
            <form method="GET" action="{{ route("searchs") }}" class="form-inline my-2 my-lg-0">
                <div>
                    <label>Sort:</label>
                    <div class="">
                        <select name="sortBy" class="form-control">
                            <option value="0">Choose...</option>
                            <option value="Price-asc">Price ASC</option>
                            <option value="Price-desc">Price DESC</option>
                            <option value="Naslov-asc">Name ASC</option>
                            <option value="Naslov-desc">Name DESC</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Color:</label>
                    <div class="">
                        <select class="form-control" name="boje">
                            <option value="0">Choose...</option>
                            @foreach($colors as $c)

                                    <option value="{{ $c->ColorId }}">{{ $c->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label>Category:</label>
                    <div class="">
                        <select class="form-control" name="kategorije">
                            <option value="0">Choose...</option>
                            @foreach($categories as $t)

                                <option value="{{ $t->CategoryId }}">{{ $t->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <input class="form-control mr-sm-2 mt-3" name="keyword" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success mt-3" type="submit">Search</button>
            </form>
                    </div>
                </div>
            </div>
            @if(!session()->has('user'))
          <div class="card my-4">
            <h5 class="card-header">Login</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <!-- LOGIN FORM -->

                  <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" id="imeprezime" name="tbKorisnickoIme" class="form-control" onkeyup="proveraKontakt()"/>
                    </div>

                    <div class="form-group">
                      <label>Password:</label>
                      <input type="password" id="sifra" name="tbLozinka" class="form-control" onkeyup="proveraKontakt()"/>
                    </div>

                    <input type="submit" name="btnLogin" value="Login" class="btn btn-primary"/>
                  <a href="{{ asset('register') }}" class="btn btn-warning">Register</a>
                  </form>

                  <!--// LOGIN FORM -->

                </div>
              </div>
            </div>
          </div>
            @endif
          @if(session()->has('user'))
                @if(session()->get('user')[0]->naziv == 'admin')
          <div class="card my-4">
            <h5 class="card-header">Panel</h5>
            <div class="card-body">
              <p>
                <a href="{{ asset('/posts') }}" class="btn btn-warning">Create/Change post</a>
                <br/> <br/>
                <a href="{{ asset('/users') }}" class="btn btn-warning">User Control</a>
                <br/> <br/>
                <a href="{{ asset('/logs') }}" class="btn btn-warning">Logs</a>
                @endif
                @if(session()->get('user')[0]->naziv != 'admin')
                    <div class="card my-4">
                        <h5 class="card-header">Panel</h5>
                        <div class="card-body">
                            <p>
                            <td> <a href="{{ asset('/users/'.session()->get('user')[0]->id) }}" class="btn btn-warning">Edit Profile</a> </td>
                                @endif
              </p>
            </div>
          </div>
          @endif
        </div>
		<!--// Desna strana -->
