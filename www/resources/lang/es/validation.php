<?php

return [
    'custom' => [
        'gif_id' => [
            'unique' => 'Este GIF ya fue agregado como favorito por el usuario'
        ],
        'user_id' => [
            'exists' => 'El ID de usuario no existe'
        ],
        'user_id.numeric' => 'El campo debe ser numerico',
        'email' => [
            'exists' => 'El email del usuario no existe',
        ]
    ]
];
