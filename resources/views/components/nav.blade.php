<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<div class="container-fluid">
	<nav class="navbar navbar-dark bg-primary">
		<div class="col-1">
			<a href="{{ route('homepage.index') }}">
				<i class="fab fa-dyalog text-primary" style="font-size: 30px; background-color: white; padding: 5px;"></i>
			</a>
		</div>
		<div class="col-5">
			<input type="text" name="" placeholder="Buscar" class="form-control col-9">
		</div>
		<div class="col-6">
			<div class="row">
				<div class="col-6">
					<a href="{{ route('profile.index', $user->slug) }}" class="text-dark">
						<img src="{{ url('/images/profile_picture')}}/{{$user->profile_picture}}" width="50" class="rounded-circle"> |
						<span>{{ $user->first_name.' '.$user->last_name }}</span>
					</a>
				</div>
				<div class="col-6 mt-2">
					<div class="btn-group">
					  	<button type="button" class="btn btn-primary" data-toggle="dropdown" aria-expanded="false">
					  		<i class="fas fa-user-friends mr-2 {{ $count > 0 ? 'text-danger' : 'text-dark' }}" style="font-size: 25px;"></i>
					  	</button>
					  	<div class="dropdown-menu" data-friends-request>
						    @if($count == 0)
						    <a class="dropdown-item">
						    	Não há solicitações de amizade
						    </a>
						    @else
						    @foreach($friendshipRequesteds as $friendshipRequested)
						    <a class="dropdown-item" href="{{ route('profile.index', $friendshipRequested->slug) }}">
						    	<div>
						    		<img src="{{ url('/images/profile_picture')}}/{{ $friendshipRequested->profile_picture }}" width="50" class="rounded-circle">
						    		{{ $friendshipRequested->first_name.' '.$friendshipRequested->last_name }}
						    	</div>
						    	<div class="w-100 mb-2"></div>
						    	<div>
						    		<button class="btn btn-success mr-2" data-accept-friend-request="{{ $friendshipRequested->id }}" data-keepOpenOnClick>Aceitar</button>
						    		<button class="btn btn-secondary" data-remove-friend-request="{{ $friendshipRequested->id }}" data-keepOpenOnClick>Excluir</button>
						    	</div>
						    </a>
						    @endforeach
						    @endif
					  	</div>
					</div>
					<i class="fas fa-bell mr-5 text-dark" style="font-size: 25px;"></i>
					<div class="btn-group">
					  	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  	</button>
					  	<div class="dropdown-menu">
						    <a class="dropdown-item" href="{{ route('settings.index') }}">Configurações</a>
						    <div class="dropdown-divider"></div>
						    <a class="dropdown-item" href="{{ route('homepage.logout') }}">Sair</a>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</nav>
</div>