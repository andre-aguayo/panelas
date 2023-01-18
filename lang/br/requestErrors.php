<?php

return [
    'email' => [
        'required' => 'o email é obrigatorio.',
        'email' => 'Formato de email é inválido.'
    ],
    'password' =>
    [
        'required' => 'A senha é obrigatoria.',
        'min' => 'a senha deve conter ao menos 5 caracteres.'
    ],
    'productCategory' => ['notFound' => 'Esta categoria nao foi encontrada.'],
    'product' => ['notFound' => 'O produto informado nao foi encontrado.'],
];
