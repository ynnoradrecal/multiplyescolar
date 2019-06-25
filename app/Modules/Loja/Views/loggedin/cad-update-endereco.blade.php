@extends('Loja::master')

@section('title', 'Dados do cliente - Lista de endereços')

@section('css')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.block-grid/latest/bootstrap3-block-grid.min.css">
@endsection

@section('content')

	<section id="breadcrumb">
		
		<img src="{{ asset('images') }}/lines.gif" class="center-block img-responsive" alt="Lines" />
		
		<div class="container">

			<div class="col-md-5">

				<h1>Dados do cliente</h1>

			</div>

			<div class="col-md-2 text-center">

					<i class="fa fa-folder-open" aria-hidden="true"></i>

			</div>

			<div class="col-md-5 text-right">

				<ul>
					<li>Home</li>
					<li>/</li>
					<li>Cadastra Endereço</li>
				</ul>

			</div>

		</div>

		<img src="{{ asset('images') }}/down.png" class="center-block img-responsive seta-baixo" alt="Lines">

	</section>

	<section id="clientes">

		<div class="container">

			<div class="col-md-4">
				{{--  Instancia Sidebar  --}}
				@include('Loja::templates.sidebar-logedin')

			</div>

			<div class="col-md-8">

				<div class="content-client-data">

					<h1>Cadastra Endereços</h1>
					<br>

					<form action="" method="post">
						
						{{ csrf_field() }}

						@if( isset($endereco->id) )
							<input name="_method" value="PUT" type="hidden" />
							<input name="endereco_id" value="{{ $endereco->id }}" type="hidden" />
						@endif

						<input type="hidden" name="user_id" value="{{ Auth::guard('cliente')->user()->id }}" />

						<div class="col-md-6">
							<div class="form-group {{ $errors->has('cep') ? 'has-error' : ''}}">
								<input class="form-control" type="text" name="cep" value="{{ isset($endereco->cep) ? $endereco->cep : old('cep')}}" placeholder="CEP" />
								{!! $errors->first('cep', '<p class="help-block">Este campo é obrigatório.</p>') !!}
							</div>
						</div>
						
						<div class="col-md-7">
							<div class="form-group {{ $errors->has('logradouro') ? 'has-error' : ''}}">
								<input class="form-control" type="text" name="logradouro" value="{{ isset($endereco->logradouro) ? $endereco->logradouro : old('logradouro')}}" placeholder="Endereço" />
								{!! $errors->first('logradouro', '<p class="help-block">Este campo é obrigatório.</p>') !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group {{ $errors->has('numero') ? 'has-error' : ''}}">
								<input class="form-control" type="text" name="numero" value="{{ isset($endereco->numero) ? $endereco->numero : old('numero')}}" placeholder="Número" />
								{!! $errors->first('numero', '<p class="help-block">Campo obrigatório.</p>') !!}
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<input class="form-control" type="text" name="complemento" value="{{ isset($endereco->complemento) ? $endereco->complemento : old('complemento')}}" placeholder="Complemento" />
							</div>
						</div>

						<div class="col-md-6 ">
							<div class="form-group {{ $errors->has('bairro') ? 'has-error' : ''}}">
								<input class="form-control" type="text" name="bairro" value="{{ isset($endereco->bairro) ? $endereco->bairro : old('bairro')}}" placeholder="Bairro" />
								{!! $errors->first('bairro', '<p class="help-block">Este campo é obrigatório.</p>') !!}
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group {{ $errors->has('cidade') ? 'has-error' : ''}}">
								<input class="form-control" type="text" name="cidade" value="{{ isset($endereco->cidade) ? $endereco->cidade : old('cidade')}}" placeholder="Cidade" />
								{!! $errors->first('cidade', '<p class="help-block">Este campo é obrigatório.</p>') !!}
							</div>
						</div>

						<div class="col-md-6 ">
							<div class="form-group {{ $errors->has('estado') ? 'has-error' : ''}}">
								<select id="" class="form-control" name="estado">
									<option value="">Selecione Estado</option>
								    <option <?php echo $endereco->estado == "AC" ? "selected=selected" : "" ?> value="AC">Acre</option>
								    <option <?php echo $endereco->estado == "AL" ? "selected=selected" : "" ?> value="AL">Alagoas</option>
								    <option <?php echo $endereco->estado == "AP" ? "selected=selected" : "" ?> value="AP">Amapá</option>
								    <option <?php echo $endereco->estado == "AM" ? "selected=selected" : "" ?> value="AM">Amazonas</option>
								    <option <?php echo $endereco->estado == "BA" ? "selected=selected" : "" ?> value="BA">Bahia</option>
								    <option <?php echo $endereco->estado == "CE" ? "selected=selected" : "" ?> value="CE">Ceará</option>
								    <option <?php echo $endereco->estado == "DF" ? "selected=selected" : "" ?> value="DF">Distrito Federal</option>
								    <option <?php echo $endereco->estado == "ES" ? "selected=selected" : "" ?> value="ES">Espirito Santo</option>
								    <option <?php echo $endereco->estado == "GO" ? "selected=selected" : "" ?> value="GO">Goiás</option>
								    <option <?php echo $endereco->estado == "MA" ? "selected=selected" : "" ?> value="MA">Maranhão</option>
								    <option <?php echo $endereco->estado == "MS" ? "selected=selected" : "" ?> value="MS">Mato Grosso do Sul</option>
								    <option <?php echo $endereco->estado == "MT" ? "selected=selected" : "" ?> value="MT">Mato Grosso</option>
								    <option <?php echo $endereco->estado == "MG" ? "selected=selected" : "" ?> value="MG">Minas Gerais</option>
								    <option <?php echo $endereco->estado == "PA" ? "selected=selected" : "" ?> value="PA">Pará</option>
								    <option <?php echo $endereco->estado == "PB" ? "selected=selected" : "" ?> value="PB">Paraíba</option>
								    <option <?php echo $endereco->estado == "PR" ? "selected=selected" : "" ?> value="PR">Paraná</option>
								    <option <?php echo $endereco->estado == "PE" ? "selected=selected" : "" ?> value="PE">Pernambuco</option>
								    <option <?php echo $endereco->estado == "PI" ? "selected=selected" : "" ?> value="PI">Piauí</option>
								    <option <?php echo $endereco->estado == "RJ" ? "selected=selected" : "" ?> value="RJ">Rio de Janeiro</option>
								    <option <?php echo $endereco->estado == "RN" ? "selected=selected" : "" ?> value="RN">Rio Grande do Norte</option>
								    <option <?php echo $endereco->estado == "RS" ? "selected=selected" : "" ?> value="RS">Rio Grande do Sul</option>
								    <option <?php echo $endereco->estado == "RO" ? "selected=selected" : "" ?> value="RO">Rondônia</option>
								    <option <?php echo $endereco->estado == "RR" ? "selected=selected" : "" ?> value="RR">Roraima</option>
								    <option <?php echo $endereco->estado == "SC" ? "selected=selected" : "" ?> value="SC">Santa Catarina</option>
								    <option <?php echo $endereco->estado == "SP" ? "selected=selected" : "" ?> value="SP">São Paulo</option>
								    <option <?php echo $endereco->estado == "SE" ? "selected=selected" : "" ?> value="SE">Sergipe</option>
								    <option <?php echo $endereco->estado == "TO" ? "selected=selected" : "" ?> value="TO">Tocantins</option>
								</select>
								<!-- <input class="form-control" type="text" name="estado" value="{{ isset($endereco->estado) ? $endereco->estado : old('estado')}}" placeholder="Estado" /> -->
								{!! $errors->first('estado', '<p class="help-block">Este campo é obrigatório.</p>') !!}
							</div>
						</div>

						<div class="col-md-12">
							<input class="btn btn-blue btn-lg" type="submit" value="Enviar" />
						</div>

					</form>

				</div>

			</div>

		</div>

	</section>

@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
					
		});
	</script>
@endsection
