<div class="card mt-2 ml-3 col-8">
	<div class="card-body">
		@if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
		@endif
		<h3>Privacidade</h3>
		<form method="POST" action="{{ route('settings.updatePrivacy') }}">
			@csrf
			<input type="hidden" name="_method" value="PUT">
			<label>Quem pode ver suas postagens?</label>
			<select class="form-control col-5 mb-2 {{ $errors->has('posts') ? 'is-invalid' : '' }}" name="posts">
				@foreach($permissionsList as $index => $permission)
					<option value="{{ $index }}" {{ $privacyOptions['posts'] == $index ? 'selected' : '' }}>{{ $permission }}</option>
				@endforeach
			</select>
			@if($errors->has('posts'))
				<span class="d-block invalid-feedback">{{ $errors->first('posts') }}</span>
			@endif
			<label>Quem pode lhe enviar solicitações de amizade?</label>
			<select class="form-control col-5 mb-2 {{ $errors->has('friendship_request') ? 'is-invalid' : '' }}" name="friendship_request">
			@foreach($requestList as $index => $request)
				<option value="{{ $index }}" {{ $privacyOptions['friendship_request'] == $index ? 'selected' : '' }}>{{ $request }}</option>
			@endforeach
			</select>
			@if($errors->has('friendship_request'))
				<span class="d-block invalid-feedback">{{ $errors->first('friendship_request') }}</span>
			@endif
			<label>Quem pode ver sua lista de amigos?</label>
			<select class="form-control col-5 {{ $errors->has('friends_list') ? 'is-invalid' : '' }}" name="friends_list">
			@foreach($permissionsList as $index => $permission)
				<option value="{{ $index }}" {{ $privacyOptions['friends_list'] == $index ? 'selected' : '' }}>{{ $permission }}</option>
			@endforeach
			</select>
			@if($errors->has('friends_list'))
				<span class="d-block invalid-feedback">{{ $errors->first('friends_list') }}</span>
			@endif
			<input class="btn btn-success mt-2" type="submit" value="Salvar alterações">
		</form>
	</div>
</div>