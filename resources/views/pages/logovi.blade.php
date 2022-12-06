@extends('layouts.front')

@section('title')
    Logovi
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
<!-- Sadrzaj -->
        <div class="col-md-8" id="rezultati">
            <h3>Log Activity Lists</h3>

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

             <br />
            <div class="row input-daterange">
                <form action="{{ asset('/flogs') }}" method="GET">
                    <label>Date from:</label>
                    <input type="date" id="from_date" name="fromdate">
                    <label>Date to:</label>
                    <input type="date" id="to_date" name="todate">
                    <input type="submit" class="btn btn-primary" value="Filter">
                </form>
            </div>
            <br />

            <table class="table table-bordered">
		<tr>
			<th>Id</th>
			<th>User</th>
			<th>Action</th>
			<th>Date</th>
		</tr>
            @isset($logovi)
            @foreach($logovi as $log)
			<tr>
				<td>{{ $log->id }}</td>
				<td>{{ $log->user }}</td>
				<td class="text-success">{{ $log->action }}</td>
                <td class="text-success">{{ date("d.m.Y. H:i:s", $log->time) }}</td>
			</tr>
            @endforeach
            @endisset

	</table>
        </div>
		<!--// Sadrzaj -->
@endsection
