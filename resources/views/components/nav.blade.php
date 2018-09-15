<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<div class="container-fluid">
	<nav class="navbar navbar-dark bg-primary">
		<div class="col-6">
			<input type="text" name="" placeholder="Buscar" class="form-control col-9">
		</div>
		<div class="col-6">
			<div class="row">
				<div class="col-6">
					<a href="{{ route('profile.index', $user->slug) }}" class="text-dark">
						<img src="{{ url('/images/default.jpg') }}" width="50" class="rounded-circle"> |
						<span>{{ $user->first_name.' '.$user->last_name }}</span>
					</a>
				</div>
				<div class="col-6 mt-2">
					<i class="fas fa-user-friends mr-3 {{ $count > 0 ? 'text-danger' : '' }}" style="font-size: 25px;"></i>
					<i class="fas fa-bell mr-5" style="font-size: 25px;"></i>
					<i class="fas fa-chevron-down"></i>
				</div>
			</div>
		</div>
	</nav>
</div>