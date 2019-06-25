<section id="steps">

	<div class="container">

		<div class="row">
	
			@php 
					
				$urls = explode('/', url()->full());
				
				$items = [
					'fa fa-glass fa-2x' => 'Eventos', 
					'fa fa-th fa-2x' => 'Galerias', 
					'fa fa-picture-o fa-2x' => 'Fotos', 
					'fa fa-star fa-2x' => 'Adicionais', 
					'fa fa-truck fa-2x' => 'Entrega', 
					'fa fa-money fa-2x' => 'Pagamento'
				];
		
			@endphp 

			<ul class="col-xs-12">
			@foreach( $items as $icon => $item )
					
				<li class=""> 
					<i class="{{ $icon }}"></i>
					@if($item != 'Pagamento')
						<div class="line"></div>
						<div class="line-half">
							<div class="ball"></div>
						</div>
					@endif
				</li>
					
			@endforeach
			<!-- <li class="active"><span>1</span>  </li> -->
			</ul>

		</div>

	</div>

</section>