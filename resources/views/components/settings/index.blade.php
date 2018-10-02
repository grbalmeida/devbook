<div class="card mt-2 ml-3 col-8">
	<div class="card-body">
		@if(session('success'))
		<div class="alert alert-success mt-2">{{ session('success') }}</div>
		@endif
		<h3>Informações Pessoais</h3>
		<form method="POST" action="{{ route('settings.updatePersonalInformation') }}">
			@csrf
			<input name="_method" type="hidden" value="PUT">
			<div class="ml-2 row">
				<input class="col-4 form-control mr-2" type="text" name="first_name" value="{{ $user->first_name }}">
				<input class="col-4 form-control" type="text" name="last_name" value="{{ $user->last_name }}">
			</div>
			<div class="ml-2 mt-2">
				@component('components.calendar', ['days' => $days, 'months' => $months, 'years' => $years, 'user' => $user])
				@endcomponent
			</div>
			<div class="ml-2 mt-2 row">
				<input type="radio" name="gender[]" value="0" class="mr-1" @if($user->gender == 0) checked @endif>Feminino
				<input type="radio" name="gender[]" value="1" class="mr-1" @if($user->gender == 1) checked @endif>Masculino
			</div>
			<button class="ml-2 mt-2 btn btn-success">Salvar alterações</button>
		</form>
	</div>
</div>