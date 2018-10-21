<div class="container card mt-2">
		<div class="card-body">
			<div class="row">
				<div class="col-3">
					<img src="/images/profile_picture/{{ $informations->profile_picture }}">
				</div>
			</div>
		</div>
	</div>
	<div class="container mb-1 mt-1">
		<div class="row">
			<div class="col-9"></div>
			<div class="col-3">
				<div class="row">
					<ul class="nav nav-pills">
						<li class="nav-item">
							<a class="nav-link {{ $_SERVER['REQUEST_URI'] == '/profile/'.$slug ? 'active': '' }}" href="{{ route('profile.index', $slug) }}">Perfil</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ $_SERVER['REQUEST_URI'] == '/profile/'.$slug.'/about' ? 'active' : '' }}" href="{{ route('profile.index', $slug) }}/about">Sobre</a>
						</li>
						<li class="nav-item">
					    	<a class="nav-link {{ $_SERVER['REQUEST_URI'] == '/profile/'.$slug.'/friends' ? 'active' : '' }}" href="{{ route('profile.index', $slug) }}/friends">Amigos</a>
					  	</li>
					  	<li class="nav-item">
					    	<a class="nav-link {{ $_SERVER['REQUEST_URI'] == '/profile/'.$slug.'/photos' ? 'active' : '' }}" href="{{ route('profile.index', $slug) }}/photos">Fotos</a>
					  	</li>
					</ul>
				</div>
			</div>
		</div>
	</div>