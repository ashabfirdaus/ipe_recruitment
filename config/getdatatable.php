<?php

return [
    'account'           => [
        'table'           => 'users',
        'widthTable'      => [],
        'labelTable'      => ['Nama', 'Peran', 'Status', 'Dibuat', 'Action'],
        'selectTable'     => ['name', 'role_name', 'users.status', 'users.created_at', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [
            ['label' => 'Peran', 'name' => 'role_id', 'type' => 'select'],
            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'prefix' => 'users'],
        ],
    ],
    'role'              => [
        'table'           => 'roles',
        'widthTable'      => [null, '87', '100'],
        'labelTable'      => ['Nama Peran', 'Status', 'Action'],
        'selectTable'     => ['role_name', 'status', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [
            ['label' => 'Status', 'name' => 'status', 'type' => 'select'],
        ],
    ],
    'disc'              => [
        'table'           => 'discs',
        'widthTable'      => [],
        'labelTable'      => ['label', 'Urutan', 'Status', 'Action'],
        'selectTable'     => ['question_number', 'sequence', 'status', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [
            ['label' => 'Status', 'name' => 'status', 'type' => 'select'],
        ],
    ],
    'iq'                => [
        'table'           => 'iqs',
        'widthTable'      => [],
        'labelTable'      => ['Pertanyaan', 'Urutan', 'Status', 'Action'],
        'selectTable'     => ['question', 'sequence', 'status', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [
            ['label' => 'Status', 'name' => 'status', 'type' => 'select'],
        ],
    ],
    'applicant'         => [
        'table'           => 'personal_datas',
        'widthTable'      => [50, 80, 100, 200, 70, 70, 250, 50, 110, 100, 300, 120, 160, 100, 100, 100, 100, 100, 100, 100],
        'labelTable'      => [
            '', 'Action', 'Tanggal', 'Posisi', 'View', 'Foto', 'Nama', 'Usia', 'Jenis Kelamin', 'Status Pernikahan', 'Alamat Saat Ini', 'No. WhatsApp', 'Preferensi Lokasi Kerja',
            'Status Pelamar', 'Status Tes', 'Hasil Tes', 'Interview', 'Expected Salary', 'CV Terbaru', 'Penyerahan Ijazah',
        ],
        'selectTable'     => [
            'id', 'action', 'date', 'position', 'has_opened', 'official_photo', 'full_name', 'age_auto', 'gender', 'marital_status', 'address_cur', 'handphone1', 'preferensi_lokasi_kerja',
            'status_employee', 'status_test', 'hasil_tes', 'interview', 'salary_expectation', 'latest_cv', 'ijazah',
        ],
        'customClass'     => [24 => 'limit-text'],
        'orderBy'         => ['updated_at', 'desc'],
        'customDatatable' => ['customColumn', 'actionColumn'],
        'filter'          => [
            ['label' => 'Posisi', 'name' => 'position', 'type' => 'select'],
            ['label' => 'Status Pelamar ', 'name' => 'status_employee', 'type' => 'select'],
            ['label' => 'Status Tes ', 'name' => 'status_test', 'type' => 'select'],
            ['label' => 'Status Pernikahan ', 'name' => 'marital_status', 'type' => 'select'],
        ],
        'export'          => true,
    ],
    'position'          => [
        'table'           => 'positions',
        'widthTable'      => [],
        'labelTable'      => ['Nama Posisi', 'Status', 'Action'],
        'selectTable'     => ['position_name', 'status', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => ['table' => ['position_name', 'status'], 'label' => ['position_name', 'Status']],
    ],
    'handle_image'      => [
        'table'           => 'settings',
        'widthTable'      => [],
        'labelTable'      => ['Nama', 'Status', 'Action'],
        'selectTable'     => ['key', 'status', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [],
    ],
    'log'               => [
        'table'           => 'logs',
        'widthTable'      => [],
        'labelTable'      => ['Keterangan', 'Catatan', 'Pengguna', 'Waktu', 'Action'],
        'selectTable'     => ['description', 'extra_description', 'users.name as name', 'logs.created_at as created_at', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [],
        // 'customLabel'     => [
        //     [
        //         'label'    => 'Waktu',
        //         'template' => 'datetime',
        //     ],
        // ],
    ],
    'applicant_account' => [
        'table'           => 'users',
        'widthTable'      => [],
        'labelTable'      => ['Nama', 'Status', 'Dibuat', 'Action'],
        'selectTable'     => ['name', 'status', 'created_at', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [
            // 'table' => ['name', 'status'],
            // 'label' => ['nama', 'Status'],
        ],
    ],
    'career'            => [
        'table'           => 'careers',
        'widthTable'      => [],
        'labelTable'      => ['Nama', 'Link', 'Dibuat', 'Status', 'Action'],
        'selectTable'     => ['career_name', 'link', 'created_at', 'status', 'action'],
        'customDatatable' => ['linkEditFirstColumn', 'customColumn', 'actionColumn'],
        'filter'          => [
            ['label' => 'Status', 'name' => 'status', 'type' => 'select'],
        ],
    ],
];
