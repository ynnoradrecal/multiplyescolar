<?php

namespace App\Modules\Loja\Helpers;

use Illuminate\Http\Request;
use Mail;
use Auth;
use Config;

class EmailHelper {
	/*
	*	Esse Helper fará o envio de todos os emails do site
	*	cada formulário possuirá uma função própria de envio
	*	cada formulário também precisará de uma view alocada na pasta abaixo
	*	App\Modules\Loja\Views\emails
	*/


	// funcção de envio do formulário de contato
	public function formContato($request, $to)
	{

		// array com dados vindos do formulário
		$data = [
			'nome' => $request->input('nome'),
			'telefone' => $request->input('telefone'),
			'email' => $request->input('email'),
			'mensagem' => $request->input('mensagem')
		];

		// array com as configurações de envio
		$sendData = [
			'view' => 'Loja::emails.contato',
			'from' => Config::get('mail.from'),
			'to' => $to,
			'subject' => 'Contato - Email enviado do site Multiply Art'
		];

		return $this->sender($request, $data, $sendData);

	}


	// funcção de envio do formulário de contato
	public function formSupport($request, $to)
	{

		// array com dados vindos do formulário
		$data = [
			'nome' => $request->input('name'),
			'email' => $request->input('email'),
			'assunto' => $request->input('assunto'),
			'mensagem' => $request->input('mensagem')
		];

		// array com as configurações de envio
		$sendData = [
			'view' => 'Loja::emails.atendimento',
			'from' => Config::get('mail.from'),
			'to' => $to,
			'subject' => 'Email enviado do site Multiply Art - '.$data['assunto']
		];

		return $this->sender($request, $data, $sendData);

	}


	// funcção criada unicamente para os envios de email
	protected function sender($request, $data, $sendData)
	{
		try {
			
			Mail::send( $sendData['view'] , $data, function($message) use ($sendData){
				$message->from( $sendData['from'] );
				$message->to( $sendData['to'] );
				$message->subject( $sendData['subject'] );
			});
			
			return true;

		} catch (\Exception $e) {
			return false;
		}		

	}
}