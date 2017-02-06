@extends('templates.default')

@section('content')
<h4><strong>Your search for "{{Request::input('query')}}".</strong></h4>
<hr>
@if(!$users->count())
<p>No results found.</p>
@else

<div class="row">
	<div class="col-lg-12">

		@foreach ($users as $user)
			@include('user/partials/userblock')
		@endforeach

	</div>
</div>
@endif
@stop