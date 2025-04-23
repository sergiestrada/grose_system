<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('vehiculos_foto') => storage_path('app/public/assets/vehiculos/foto'),
        public_path('vehiculos_manual') => storage_path('app/public/assets/vehiculos/manual'),
        public_path('vehiculos_factura') => storage_path('app/public/assets/vehiculos/factura'),
        public_path('vehiculos_poliza') => storage_path('app/public/assets/vehiculos/polizas'),
        public_path('vehiculos_tarjeta') => storage_path('app/public/assets/vehiculos/tarjeta'),
        public_path('vehiculos_pesado_foto') => storage_path('app/public/assets/vehiculos_pesado/foto'),
        public_path('vehiculos_pesado_manual') => storage_path('app/public/assets/vehiculos_pesado/manual'),
        public_path('vehiculos_pesado_factura') => storage_path('app/public/assets/vehiculos_pesado/factura'),
        public_path('vehiculos_pesado_poliza') => storage_path('app/public/assets/vehiculos_pesado/polizas'),
        public_path('vehiculos_pesado_tarjeta') => storage_path('app/public/assets/vehiculos_pesado/tarjeta'),
        public_path('maquinaria_foto') => storage_path('app/public/assets/maquinaria_menor/foto'),
        public_path('maquinaria_manual') => storage_path('app/public/assets/maquinaria_menor/manual'),
        public_path('maquinaria_factura') => storage_path('app/public/assets/maquinaria_menor/factura'),
        public_path('maquinaria_poliza') => storage_path('app/public/assets/maquinaria_menor/polizas'),
        public_path('maquinaria_tarjeta') => storage_path('app/public/assets/maquinaria_menor/tarjeta'),
        public_path('certificados') => storage_path('app/public/assets/certificados'),
        public_path('facturas_herramientas') => storage_path('app/public/assets/facturas_herr'),
        public_path('manuales') => storage_path('app/public/assets/manuales'),
        public_path('images') => storage_path('app/public/assets/images'),
        public_path('img') => storage_path('app/public/assets/img'),
        public_path('img_herramienta') => storage_path('app/public/assets/imagenes_herramienta'),
        public_path('faturas_requi') => storage_path('app/public/assets/facturas_requisicion'),
        public_path('conformidades') => storage_path('app/public/assets/conformidades'),
        public_path('documentos_maquinaria') => storage_path('app/public/assets/documentos_maquinaria'),
        public_path('documentos_maquinaria') => storage_path('app/public/assets/documentos_maquinaria'),
		

    ],

];
