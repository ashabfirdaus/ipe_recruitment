<style>
    .datatable-header {
        display: none;
    }

    #dataTable td,
    #dataTable th {
        padding: 5px;
    }

    #dataTable th {
        font-weight: bold;
        background-color: rgb(222, 222, 222);
    }
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <i class="{{ getAttributPage($menu, request()->route()->getName(), 'icon') }} position-left"></i>
                <span class="text-semibold">{{ getAttributPage($menu, request()->route()->getName(), 'label') }}</span>
            </h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Grafik Status Kandidat</h5>
                    <div class="heading-elements">
                        <div class="heading-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Tahun</span>
                                    <select class="form-control" name="filter_year">
                                        @foreach (range(date('Y'), 2020) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="chart-container">
                        <div class="chart has-fixed-height" id="columns_basic"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-flat no-padding">
                <div class="panel-heading">
                    <h5 class="panel-title">Kandidat Per Posisi</h5>
                </div>
                <table class="table datatable" id="dataTable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Posisi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script type="text/javascript" src="{{ asset('js/echarts.min.js') }}"></script>
    <script src="{{ asset('packages/datatables/datatables.min.js') }}"></script>
    <script>
        var columnsBasicElement = document.getElementById('columns_basic');
        var columnsBasic = echarts.init(columnsBasicElement);
        var listPositionEmployee = []

        getStatusEmployee()
        getPositionEmployee()

        function getStatusEmployee() {
            $.ajax({
                url: '{{ route('load-status-employee') }}?year=' + $('[name="filter_year"]').val(),
                type: 'get',
                success: function(res) {
                    option.xAxis.data = res.labels
                    option.series[0].data = res.values
                    columnsBasic.setOption(option)
                },
                error: function(error) {
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error
                        .statusText)
                }
            })
        }

        function getPositionEmployee() {
            $.ajax({
                url: '{{ route('load-position-employee') }}',
                type: 'get',
                success: function(res) {
                    listPositionEmployee = res.datas
                    resDataTable.clear().rows.add(listPositionEmployee).draw()
                },
                error: function(error) {
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error
                        .statusText)
                }
            })
        }

        $('[name="filter_year"]').change(function() {
            getStatusEmployee()
        })

        var option = {
            color: ['#d87a80'],
            textStyle: {
                fontFamily: 'poppins, Arial, Verdana, sans-serif',
                fontSize: 13
            },
            animationDuration: 750,
            grid: {
                left: 0,
                right: 35,
                top: 10,
                bottom: 0,
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: [],
                axisLabel: {
                    show: true,
                    interval: 0,
                    rotate: 45,
                },
            },
            yAxis: {
                type: 'value',
                show: false
            },
            series: [{
                data: [],
                type: 'bar',
                itemStyle: {
                    normal: {
                        label: {
                            show: true,
                            position: 'inside'
                        }
                    }
                }
            }]
        };

        var resDataTable = $('#dataTable').DataTable({
            data: listPositionEmployee,
            searching: false,
            bInfo: false,
            paging: false,
            ordering: false,
            columns: forTableData(),
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Tampil:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': '→',
                    'previous': '←'
                },
                emptyTable: "Data Tidak Ditemukan",
            },
        });

        function forTableData() {
            return [{
                data: 'index',
                name: 'index',
                width: 30,
                render: function(data, type, full, meta) {
                    return meta.row + 1;
                },
                className: 'text-center'
            }, {
                data: 'position',
                name: 'position'
            }, {
                data: 'total',
                name: 'total',
                width: 30,
                className: 'text-center',
                render: function(data, type, full, meta) {
                    let objectStatus = ['FOLLOW UP', 'TES', 'CADANGAN', 'INTERVIEW HRD', 'INTERVIEW USER',
                        'FINAL PROSES', 'NEGOSIASI'
                    ]
                    let param = $.param({
                        position: full.position,
                        status_employee: objectStatus
                    })
                    return '<a href="{{ route('applicant') }}?' + param +
                        '" class="btn btn-info btn-rounded" style="width:23px;height:23px;padding:2px;">' +
                        data + '</a>'
                }
            }]
        }
    </script>
    @if (!request()->ajax())
    @endpush
@endif
