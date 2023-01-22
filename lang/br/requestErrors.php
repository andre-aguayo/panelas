<?php

return [
    'email' => [
        'required' => 'O email é obrigatorio.',
        'email' => 'Formato de email é inválido.'
    ],
    'password' =>
    [
        'required' => 'A senha é obrigatoria.',
        'min' => 'A senha deve conter ao menos 5 caracteres.'
    ],
    'productCategory' => ['notFound' => 'Esta categoria nao foi encontrada.'],
    'product' => [
        'notFound' => 'O produto informado nao foi encontrado.',
        'store' => 'Nao foi possivel cadastrar o produto.',
        'update' => 'Nao foi possivel editar o produto.',
        'productInformation' => [
            'update' => 'Nao foi possivel atualizar as informaçoes do produto.',
            'delete' => 'Nao foi possivel remover a informaçao deste produto.',
        ],
        'productStock' => [
            'update' => 'Nao foi possivel alterar o estoque do produto.'
        ]
    ],
];
