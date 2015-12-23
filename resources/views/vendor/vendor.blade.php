@extends('welcome')

@section('content')
	<div class="container">
		<h1>Vendors</h1>

		<hr>

		@foreach($vendors as $vendor)
			<li>{{$vendor->name}} <a href="/vendors/edit/{{$vendor->id}}" class="btn btn-xs btn-success">Edit</a></li>
		@endforeach
	</div>
@stop