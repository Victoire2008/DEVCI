<?php
return [
    'mailgun'  => ['domain'=>env('MAILGUN_DOMAIN'),'secret'=>env('MAILGUN_SECRET'),'endpoint'=>env('MAILGUN_ENDPOINT','api.mailgun.net'),'scheme'=>'https'],
    'postmark' => ['token'=>env('POSTMARK_TOKEN')],
    'ses'      => ['key'=>env('AWS_ACCESS_KEY_ID'),'secret'=>env('AWS_SECRET_ACCESS_KEY'),'region'=>env('AWS_DEFAULT_REGION','us-east-1')],
    'wave'     => ['api_key'=>env('WAVE_API_KEY'),'secret'=>env('WAVE_SECRET_KEY')],
    'orange_money' => ['merchant_key'=>env('ORANGE_MONEY_MERCHANT_KEY'),'auth_header'=>env('ORANGE_MONEY_AUTH_HEADER')],
];
