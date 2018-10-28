@if(!$informations->educational_institution)
	<div>
		<i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
		Nenhum instituição de ensino para exibir
		<hr>
	</div>
@else
	<div>
		<i class="fas fa-graduation-cap" style="font-size: 25px;"></i>
		@if($informations->course)
			Estudou {{ $informations->course }} na instituição de ensino {{ $informations->educational_institution }}
		@else
			Estuda na instituição de ensino {{ $informations->educational_institution }}
		@endif
		<hr>
	</div>
@endif