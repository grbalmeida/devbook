<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Devbook</title>
	<link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body>
	<div class="container-fluid">
		<nav class="navbar navbar-dark bg-primary d-flex flex-row-reverse">
			<form>
				<div class="form-inline">
					<input type="text" class="form-control mr-2" placeholder="E-mail">
					<input type="password" class="form-control mr-2" placeholder="Senha">
				<button type="submit" class="btn btn-success">Logar</button>
			</div>
			</form>
		</nav>
		<div class="container-fluid d-flex flex-row-reverse">
			<div class="card mt-5 w-50 px-4">
				<div class="card-body">
					<div class="h4">Cadastre-se agora</div>
				</div>
				<form method="POST">
					@csrf
					<input type="text" name="first_name" placeholder="Nome" class="form-control mb-2 {{ $errors->has('first_name') ? 'is-invalid' : '' }}" value="{{ old('first_name') }}">
					@if($errors->has('first_name'))
						<div class="invalid-feedback">
							{{ $errors->first('first_name') }}
						</div>
					@endif
					<input type="text" name="last_name" placeholder="Sobrenome" class="form-control mb-2 {{ $errors->has('last_name') ? 'is-invalid' : '' }}" value="{{ old('last_name') }}">
					@if($errors->has('last_name'))
						<div class="invalid-feedback">
							{{ $errors->first('last_name') }}
						</div>
					@endif
					<input type="text" name="email" placeholder="E-mail" class="form-control mb-2 mr-2 {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}">
					@if($errors->has('email'))
						<div class="invalid-feedback">
							{{ $errors->first('email') }}
						</div>
					@endif
					<input type="text" name="email_confirmation" placeholder="Confirme o e-mail" class="form-control mb-2" value="{{ old('email_confirmation') }}">
					@if($errors->has('email_confirmation'))
						<div class="invalid-feedback">
							{{ $errors->first('email_confirmation') }}
						</div>
					@endif
					<input type="password" name="password" placeholder="Senha" class="form-control mb-2 {{ $errors->has('password') ? 'is-invalid' : '' }}">
					@if($errors->has('password'))
						<div class="invalid-feedback">
							{{ $errors->first('password') }}
						</div>
					@endif
					<div class="form-inline mb-3">
						<label>Data de nascimento</label>
						<div class="w-100 mb-2"></div>
						<div>
							<select class="form-control" name="day">
								@foreach($days as $day)
									<option value="{{ $day }}">{{ $day }}</option>
								@endforeach
							</select>
							<select class="form-control" name="month">
								@foreach($months as $index => $month)
									<option value="{{ ($index + 1) }}">{{ $month }}</option>
								@endforeach
							</select>
							<select class="form-control" name="year">
								@foreach($years as $year)
									<option value="{{ $year }}">{{ $year }}</option>
								@endforeach	
							</select>
						</div>
					</div>
					<input type="radio" name="gender" class="mr-1" value="0" @if(!old('gender')) checked @endif>Feminino
					<input type="radio" name="gender" class="mr-1" value="1" @if(old('gender')) checked @endif>Masculino
					@if($errors->has('gender'))
						<div class="invalid-feedback">
							{{ $errors->first('gender') }}
						</div>
					@endif
					<div class="w-100"></div>
					<button class="btn btn-success mb-3 mt-2">
					Cadastrar</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>