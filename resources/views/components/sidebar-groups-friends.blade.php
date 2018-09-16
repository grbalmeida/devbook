<div class="card col-3 mt-2 ml-3 mr-4">
	<div class="card-body">
		<div class="w-100">
			<a href="{{ route('profile.index', $user->slug) }}" class="text-dark">
				<img src="{{ url('/images/default.jpg') }}" width="70" class="rounded-circle"> {{ $user->first_name.' '.$user->last_name }}
			</a>
		</div>
		<div class="w-100 mt-3"></div>
		<a href="">Editar Perfil</a>
		<div class="w-100 mt-3"></div>
		<div class="h5">Amigos</div>
		<div class="">
			@foreach($friends as $friend)
			<a href="{{ route('profile.index', $friend->slug) }}" class="text-dark">
				<img src="{{ url('/images/default.jpg') }}" class="mb-2" width="60" style="">
			</a>
			@endforeach
		</div>
		<div class="w-100"></div>
		<div class="h5 mt-2">Grupos</div>
		<div class="">
			@foreach($groups as $group)
			<div class="w-100">
				<a href="{{ route('groups.index', $group->id) }}" class="text-dark">
					<img src="{{ url('/images/default.jpg') }}" class="mb-2" width="50"> {{ $group->name }}
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>
