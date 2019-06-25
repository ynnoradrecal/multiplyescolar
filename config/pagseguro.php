<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sandbox
    |--------------------------------------------------------------------------
    |
    | Checa se utilizará o Sandbox ou Production.
    |
    */
    'sandbox' => env('PAGSEGURO_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    |
    | Conta de email do Vendedor.
    |
    */
    'email' => env('PAGSEGURO_EMAIL', 'contato@multiply.art.br'),

    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | Token do Vendedor.
    |
    */
   
    // token para sandbox
    // 'token' => env('PAGSEGURO_TOKEN', '3BF42BDC9740483696289C6BC3E228A0'),
    
    // token para pagseguro produção
    'token' => env('PAGSEGURO_TOKEN', 'BEA84E092FE04023BE53B1A6A281C32D'),

    /*
    |--------------------------------------------------------------------------
    | NotificationURL
    |--------------------------------------------------------------------------
    |
    | URL de resposta para notificações do Pagseguro.
    |
    */
    'notificationURL' => env('PAGSEGURO_NOTIFICATION', 'https://multiply.art.br/escolar/pagseguro/notification')

];
