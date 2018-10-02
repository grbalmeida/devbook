<div class="card mt-2 ml-3 col-8">
	<div class="card-body">
		@if(session('success'))
		<div class="alert alert-success mt-2 mb-2">{{ session('success') }}</div>
		@endif	
		<h3>Alterar Senha</h3>
		<form method="POST" action="{{ route('settings.updatePassword') }}">
			@csrf
			<div class="ml-2">
				<input type="hidden" name="_method" value="PUT">
				<span>Atual</span>
				<input class="form-control mb-2 col-4 {{ $errors->has('current') || session('error') ? 'is-invalid' : '' }}" type="password" name="current">
				@if($errors->has('current'))
					<span class="d-block invalid-feedback">{{ $errors->first('current') }}</span>
				@endif
				@if(session('error'))
					<span class="d-block invalid-feedback">{{ session('error') }}</span>
				@endif
				<span>Nova</span>
				<input class="form-control mb-2 col-4 {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password">
				@if($errors->has('password'))
					<span class="d-block invalid-feedback">{{ $errors->first('password') }}</span>
				@endif
				<span>Digite novamente</span>
				<input class="form-control col-4" type="password" name="password_confirmation">
				<input class="btn btn-success mt-2" type="submit" value="Salvar alterações">
			</div>
		</form>
	</div>
</div>