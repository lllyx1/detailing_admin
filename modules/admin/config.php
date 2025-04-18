<?php
return [
    'components' => [
        'view' => [
            'class' => 'yii\web\View',
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ],
            ],
        ],
    ],
    'params'=> [
        'hail812/yii2-adminlte3' => [
            'pluginMap' => [
                'sweetalert2' => [
                    'css' => 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
                    'js' => 'sweetalert2/sweetalert2.min.js'
                ],
                'toastr' => [
                    'css' => ['toastr/toastr.min.css'],
                    'js' => ['toastr/toastr.min.js']
                ],
            ]
        ]
    ]
];