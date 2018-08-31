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
				<form>
					<input type="text" name="" placeholder="Nome" class="form-control mb-2">
					<input type="text" name="" placeholder="Sobrenome" class="form-control mb-2">
					<input type="text" name="" placeholder="E-mail" class="form-control mb-2 mr-2">
					<input type="text" name="" placeholder="Confirme o e-mail" class="form-control mb-2">
					<div class="form-inline mb-3">
						<label>Data de nascimento</label>
						<div class="w-100 mb-2"></div>
						<div>
							<select class="form-control">
								@foreach($days as $day)
									<option value="{{ $day }}">{{ $day }}</option>
								@endforeach
							</select>
							<select class="form-control">
								@foreach($months as $index => $month)
									<option value="{{ ($index + 1) }}">{{ $month }}</option>
								@endforeach
							</select>
							<select class="form-control">
								@foreach($years as $year)
									<option value="{{ $year }}">{{ $year }}</option>
								@endforeach	
							</select>
						</div>
					</div>
					<input type="radio" name="gender" class="mr-1">Feminino
					<input type="radio" name="gender" class="mr-1">Masculino
					<div class="w-100"></div>
					<button class="btn btn-success mb-3 mt-2">
					Cadastrar</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>