@if(!$informations->company)
	<div>
		<i class="fas fa-briefcase" style="font-size: 25px;"></i>
		Nenhum local de trabalho para mostrar
	</div>
@else
	<div>
		<i class="fas fa-briefcase" style="font-size: 25px;"></i>
		@if($informations->occupation)
			{{ $informations->occupation }} na empresa {{ $informations->company }}
		@else
			Trabalha na empresa {{ $informations->company }}
		@endif
		<hr>
	</div>
@endif