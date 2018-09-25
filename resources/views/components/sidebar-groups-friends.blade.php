<div class="card col-3 mt-2 h-100">
	<div class="card-body">
		<div class="w-100">
			<a href="{{ route('profile.index', $user->slug) }}" class="text-dark">
				<img src="{{ url('/images/cover_photo_user')}}/{{ $user->cover_photo }}" width="70" class="rounded-circle"> {{ $user->first_name.' '.$user->last_name }}
			</a>
		</div>
		<div class="w-100 mt-3"></div>
		<a href="">Editar Perfil</a>
		<div class="w-100 mt-3"></div>
		<div class="h5">Amigos</div>
		<div class="">
			@foreach($friends as $friend)
			<a href="{{ route('profile.index', $friend->slug) }}" class="text-dark" style="text-decoration: none;">
				<img src="{{ url('/images/cover_photo_user')}}/{{ $friend->cover_photo }}" class="mb-2" width="57" 
				title="{{ $friend->first_name.' '.$friend->last_name }}">
			</a>
			@endforeach
		</div>
		<div class="w-100"></div>
		<div class="h5 mt-2">Grupos</div>
		<div class="">
			@foreach($groups as $group)
			<div class="w-100">
				<a href="{{ route('groups.index', $group->id) }}" class="text-dark">
					<img src="{{ url('/images/default.jpg') }}" class="mb-2" width="40"> {{ $group->name }}
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>
