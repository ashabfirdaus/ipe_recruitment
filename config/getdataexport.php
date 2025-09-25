<?php

return [
    'account' => [
        'titleColumn' => ['Nama', 'Peran', 'Status', 'Dibuat'],
        'dataColumn' => ['name', 'role_name', 'status', 'created_at'],
    ],
    'role' => [
        'titleColumn' => ['Nama Peran', 'Status'],
        'dataColumn' => ['role_name', 'status'],
    ],
    'report_stock_usage' => [
        'titleColumn' => ['Cabang', 'Gudang', 'Tanggal', 'Kode Transaksi', 'Jenis Pemakaian', 'User', 'Barang', 'Satuan', 'Jumlah', 'Keterangan'],
        'dataColumn' => ['branch_name', 'warehouse_name', 'date', 'stock_usage_code', 'type_transaction', 'name', 'item_name', 'unit_measure_name', 'qty', 'concat_desc'],
    ],
    'report_purchase_request' => [
        'titleColumn' => ['Cabang', 'Tanggal Permintaan', 'Kode Permintaan', 'Pemohon', 'Barang', 'Satuan', 'Jumlah permintaan', 'Tanggal Pesanan', 'Kode Pesanan', 'Jumlah Pesanan', 'Keterangan'],
        'dataColumn' => ['branch_name', 'pr_date', 'purchase_request_code', 'name', 'item_name', 'unit_measure_name', 'pr_qty', 'po_date', 'purchase_order_code', 'po_qty', 'desc'],
    ],
    'report_stock' => [
        'titleColumn' => ['Qrcode', 'Cabang', 'Gudang', 'Barang', 'Qty', 'Satuan', 'Keterangan'],
        'dataColumn' => ['qrcode', 'branch_name', 'warehouse_name', 'item_name', 'remaining_qty', 'unit_measure_name', 'desc'],
    ],
    'history_tracking' => [
        'titleColumn' => ['Kode Transaksi', 'Tanggal', 'Qrcode', 'Cabang', 'Gudang', 'Barang', 'Masuk', 'Keluar', 'Satuan', 'Keterangan'],
        'dataColumn' => ['transaction_code', 'date', 'qrcode', 'branch_name', 'warehouse_name', 'item_name', 'stock_in', 'stock_out', 'unit_measure_name', 'desc'],
    ],
    'report_purchase_order' => [
        'titleColumn' => ['Cabang', 'Tanggal Pesanan', 'Kode Pesanan', 'Supplier', 'Barang', 'Satuan', 'Jumlah Pesanan', 'Belum Diterima', 'Keterangan'],
        'dataColumn' => ['branch_name', 'date', 'purchase_order_code', 'supplier_name', 'item_name', 'unit_measure_name', 'qty', 'remaining_qty', 'desc'],
    ],
];
