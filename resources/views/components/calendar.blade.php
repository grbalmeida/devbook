<div class="form-inline mb-3">
	<label>Data de nascimento</label>
	<div class="w-100 mb-2"></div>
	<div>
		<select class="form-control {{ session('date_error') ? 'is-invalid' : '' }}" name="day">
			@foreach($days as $day)
				<option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }} @if(!empty($user)) @if(substr($user->birthday, 8) == $day) selected @endif @endif>{{ $day }}</option>
			@endforeach
		</select>
		<select class="form-control {{ session('date_error') ? 'is-invalid' : '' }}" name="month">
			@foreach($months as $index => $month)2
				<option value="{{ ($index + 1) }}" {{ old('month') == $month ? 'selected' : '' }} @if(!empty($user)) @if(substr($user->birthday, 5, 7) == ($index + 1)) selected @endif @endif>{{ $month }}</option>
			@endforeach
		</select>
		<select class="form-control {{ session('date_error') ? 'is-invalid' : '' }}" name="year">
			@foreach($years as $year)
				<option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }} @if(!empty($user)) @if(substr($user->birthday, 0, 4) == $year) selected @endif @endif>{{ $year }}</option>
			@endforeach	
		</select>
	</div>
	@if(session('date_error'))
		<div class="invalid-feedback d-block">
			{{ session('date_error') }}
		</div>
	@endif
</div>