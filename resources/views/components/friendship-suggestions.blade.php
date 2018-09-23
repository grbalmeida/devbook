<div class="card col-3 mt-2 ml-3 h-100">
	<div class="card-body" data-friendship-suggestions>
		<div class="h5">Sugestões de amizade</div>
		<div class="w-100"></div>
		@foreach($friendshipSuggestions as $friendshipSuggestion)
		<div class="row">
			<a href="{{ route('profile.index', $friendshipSuggestion->slug) }}">
				<img src="{{ url('images/cover_photo_user')}}/{{ $friendshipSuggestion->cover_photo }}" height="40" class="rounded-circle">
				<span class="db-block ml-3">{{ $friendshipSuggestion->first_name.' '.$friendshipSuggestion->last_name }}</span>
			</a>
			<i class="fas fa-times d-block pt-2 ml-5" style="font-size: 20px; cursor: pointer;" data-cancel-friendship-suggestion="{{ $friendshipSuggestion->id }}"></i>
			<div class="w-100"></div>
			<button class="btn btn-primary mb-3 mt-3" data-user-suggestion-id="{{ $friendshipSuggestion->id }}">Adicionar</button>
		</div>
		@endforeach
	</div>
</div>