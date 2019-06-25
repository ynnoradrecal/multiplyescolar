<template lang="html">
	<div class="col-md-12 col-dm-12 col-xs-12">
		<div class="x_panel">

			<div class="x_title">
				<h2><i class="fa fa-pencil-square-o"></i> Configuração PayPal</h2>
				<!--pulse-loader v-show="loader" class="loader_forms pull-right"></pulse-loader-->
				<div class="clearfix"></div>
			</div>

			<div class="x_content">
				<form class="form-horizontal form-label-left" method="post">
					<fieldset>
						<input class="form-control" placeholder="..." type="hidden" v-model="store.id">
						<div class="form-group" v-bind:class="{'has-error':error.nome}">
							<div class="col-xs-12">
								<label for="">Nomde do Módulo</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.nome">
								<span class="help-block" v-for="error in error.nome">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.email}">
							<div class="col-xs-12">
								<label for="">E-mail</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.email">
								<span class="help-block" v-for="error in error.email">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.token}">
							<div class="col-xs-12">
								<label for="">Token</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.token">
								<span class="help-block" v-for="error in error.token">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.url_redirect}">
							<div class="col-xs-12">
								<label for="">URL de Redirecionamento</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.url_redirect">
								<span class="help-block" v-for="error in error.url_redirect">{{ error }}</span>
							</div>
						</div>

						<div class="form-group" v-bind:class="{'has-error':error.status}">
							<div class="col-xs-12">
								<label for="">Status</label>
								<input class="form-control" placeholder="..." type="text" v-model="store.status">
								<span class="help-block" v-for="error in error.status">{{ error }}</span>
							</div>
						</div>

					</fieldset>
				</form>
			</div>

		</div>
	</div>
</template>