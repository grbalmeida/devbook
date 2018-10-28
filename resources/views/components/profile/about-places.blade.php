@if(!$informations->actual_city && !$informations->hometown)
	<div>
		<i class="fas fa-map-marker-alt" style="font-size: 25px;"></i>
		Nenhum local para exibir
	</div>	
@else
	<div>
		<i class="fas fa-map-marker-alt" style="font-size: 25px;"></i>
		@if($informations->actual_city)
			Mora em {{ $informations->actual_city }}
		@endif
		@if($informations->hometown)
			/ De {{ $informations->hometown }}
		@endif
	</div>
@endif