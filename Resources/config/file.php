<?php
return [
    'getThumbnail' => [
        'path' => 'me/drive/items/{itemId}/thumbnails',
        'httpMethod' => 'GET',
        'parameters' => [
            'fileId' => [
                'location' => 'path',
                'type' => 'string',
                'required' => true,
            ]
        ]
    ],

];