<link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />
<style>
    th.table-action {
        width: 50px !important;
        text-align: center;
    }

    .l2 {
        padding-left: 1em;
    }

    .l1 {
        font-weight: bold;
    }

    .select2-selection__rendered {
        line-height: 36px !important;
    }

    .select2-container .select2-selection--single {
        height: 36px !important;
    }

    .select2-selection__arrow {
        height: 36px !important;
    }

    .fixedHeader-floating {
        top: 48px !important;
        table-layout: auto !important;
    }

    .table th {
        background-color: #f58c8c;
        color: white;
    }

    .datatable-footer,
    .datatable-header {
        padding: 10px 10px 10px 10px;
    }

    .dataTables_filter,
    .dataTables_length {
        margin-bottom: 0px;
    }

    .panel-heading,
    .panel-flat>.panel-heading {
        padding: 10px 10px 0px 10px;
    }

    .element-filter .form-group {
        margin-bottom: 0px;
    }

    #dataTable th {
        font-weight: bold;
    }

    .panel-flat>.panel-heading+.dataTables_wrapper>.datatable-header {
        padding-top: 10px;
    }

    .group>td {
        background-color: rgb(222, 222, 222);
    }

    .dataTable thead .sorting:after,
    .dataTable thead .sorting:before,
    .dataTable thead .sorting_asc:after,
    .dataTable thead .sorting_asc_disabled:after,
    .dataTable thead .sorting_desc:after,
    .dataTable thead .sorting_desc_disabled:after {
        right: 5px;
        color: white;
    }

    .dataTable thead .sorting,
    .dataTable thead .sorting_asc,
    .dataTable thead .sorting_asc_disabled,
    .dataTable thead .sorting_desc,
    .dataTable thead .sorting_desc_disabled {
        padding-right: 15px;
    }

    .dataTable tbody tr:hover {
        background-color: rgb(235, 235, 235);
    }

    @media (max-width: 1487px) {
        .datatable-scroll {
            width: 100%;
            overflow-x: scroll;
        }
    }

    .table>thead>tr>th {
        padding-right: 20px !important;
    }
</style>
@php
    $config = config('getdatatable.' . $type);
    $firstMenu = firstMenu($menu, $type);
    $getMenu = request()->route()->getName();
@endphp
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <i class="{{ getAttributPage($menu, $type, 'icon') }} position-left"></i>
                <span class="text-semibold">{{ getAttributPage($menu, $type, 'label') }}</span>
            </h4>
            @if (isset($firstMenu['desc']))
                <p>{{ $firstMenu['desc'] }}</p>
            @endif
        </div>
        <div class="heading-elements">
            @if (getRoleUser(request()->route()->getName(), 'create') &&
                    in_array('create', getAttributPage($menu, $type, 'activity')))
                <a href="{{ route($type . '-entry') }}" class="btn btn-primary me">
                    <i class="icon-plus2 position-left"></i> Buat {{ getAttributPage($menu, $type, 'label') }} Baru
                </a>
            @endif
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        @php
            $filter = isset($config['filter']) ? $config['filter'] : [];
            $countFilter = count(request()->except(['search', 'page', 'page_length', 'order', '_']));
        @endphp
        @if (count($filter) > 0)
            <div class="panel-heading element-filter"
                style="{{ $countFilter > 0 ? 'display:block;' : 'display: none;' }}">
                <div class="row">
                    @foreach ($filter as $fill)
                        @if ($fill['type'] == 'select' && isset(${$fill['name']}))
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control filter-select2" name="{{ $fill['name'] }}"
                                    {{ isset($fill['multiple']) ? 'multiple' : '' }}>
                                    @if (!isset($fill['multiple']))
                                        <option value="all">Semua {{ $fill['label'] }}</option>
                                    @endif
                                    @foreach (${$fill['name']}['data'] as $fdata)
                                        @php
                                            $selectSingle = '';
                                            if (
                                                isset(request()->{$fill['name']}) &&
                                                strtolower(request()->{$fill['name']}) == strtolower($fdata->id)
                                            ) {
                                                $selectSingle = 'selected';
                                            } else {
                                                if (isset($fdata->selected) && $fdata->selected == true) {
                                                    $selectSingle = 'selected';
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $fdata->id }}" {{ $selectSingle }}>{{ $fdata->text }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($fill['type'] == 'select-pure' && isset(${$fill['name']}))
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control filter-select2" name="{{ $fill['name'] }}">
                                    @foreach (${$fill['name']}['data'] as $fk => $fdata)
                                        @php
                                            $selectSingle = '';
                                            if (
                                                isset(request()->{$fill['name']}) &&
                                                strtolower(request()->{$fill['name']}) == strtolower($fdata->id)
                                            ) {
                                                $selectSingle = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $fdata->id }}"
                                            {{ !isset(request()->{$fill['name']}) && $fk == 0 ? 'selected' : $selectSingle }}>
                                            {{ $fdata->text }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($fill['type'] == 'text')
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <div class="form-group">
                                    <input type="text" class="form-control filter-text" name="{{ $fill['name'] }}"
                                        value="{{ isset(request()->{$fill['name']}) ? request()->{$fill['name']} : '' }}">
                                </div>
                            </div>
                        @endif

                        @if ($fill['type'] == 'daterange')
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <div class="form-group">
                                    <input type="text" class="form-control filter-daterange"
                                        name="{{ $fill['name'] }}" readonly
                                        value="{{ isset(request()->{$fill['name']}) ? request()->{$fill['name']} : (isset($set_daterange) ? $set_daterange : '') }}">
                                </div>
                            </div>
                        @endif

                        @if ($fill['type'] == 'groupdatatable' && isset(${$fill['name']}))
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control {{ $fill['type'] }}" name="{{ $fill['name'] }}">
                                    @foreach (${$fill['name']}['data'] as $fdata)
                                        @php
                                            $groupSelected = '';
                                            if (
                                                isset($config['groupByTable']) &&
                                                $config['groupByTable']['input'] == $fill['name']
                                            ) {
                                                if ($config['groupByTable']['data'] == $fdata->id) {
                                                    $groupSelected = 'selected';
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $fdata->id }}" {{ $groupSelected }}>{{ $fdata->text }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($fill['type'] == 'selectbranch' && isset(${$fill['name']}))
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control filter-select2 {{ $fill['type'] }}"
                                    name="{{ $fill['name'] }}">
                                    <option value="all">Semua {{ $fill['label'] }}</option>
                                    @foreach (${$fill['name']}['data'] as $fdata)
                                        @php
                                            $selectSingle = '';
                                            if (
                                                isset(request()->{$fill['name']}) &&
                                                strtolower(request()->{$fill['name']}) == strtolower($fdata->id)
                                            ) {
                                                $selectSingle = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $fdata->id }}" {{ $selectSingle }}>{{ $fdata->text }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($fill['type'] == 'selectcategory' && isset(${$fill['name']}))
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control filter-select2 {{ $fill['type'] }}"
                                    name="{{ $fill['name'] }}">
                                    <option value="all">Semua {{ $fill['label'] }}</option>
                                    @foreach (${$fill['name']}['data'] as $fdata)
                                        @php
                                            $selectSingle = '';
                                            if (
                                                isset(request()->{$fill['name']}) &&
                                                strtolower(request()->{$fill['name']}) == strtolower($fdata->id)
                                            ) {
                                                $selectSingle = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $fdata->id }}" {{ $selectSingle }}>{{ $fdata->text }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-md-2">
                        <a href="javascript:void(0)" class="btn btn-primary btn-reset" style="margin-top:27px;">
                            Reset <i class="icon-reset"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        <table class="table hover" id="dataTable" style="width:100%;">
            <thead>
                <tr>
                    @foreach ($config['labelTable'] as $kcol => $col)
                        <th class="{{ $col == 'Action' ? 'table-action' : '' }}">{{ ucwords($col) }}</th>
                    @endforeach
                </tr>
            </thead>
        </table>
    </div>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('packages/datatables/datatables.min.js') }}"></script>
    <script>
        var type = '{{ $type }}'
        var urlDatatable = "{{ route($type . '-datatable') }}?type=" + type;
        var selectDatatable = {!! json_encode($config['selectTable']) !!}
        var widthDatatable = {!! json_encode($config['widthTable']) !!}
        var filterDatatable = {!! json_encode($config['filter']) !!}
        var groupDatatable = {!! isset($config['groupByTable']) ? json_encode($config['groupByTable']) : '{}' !!}
        var orderDatatable = {!! isset($config['orderBy']) ? json_encode($config['orderBy']) : '[]' !!}
        var decimalFormatNumberDatatable = {!! isset($config['decimalFormatNumber']) ? json_encode($config['decimalFormatNumber']) : '[]' !!}
        var decimalFormatRupiahDatatable = {!! isset($config['decimalFormatRupiah']) ? json_encode($config['decimalFormatRupiah']) : '[]' !!}
        var disabledSortDatatable = {!! isset($config['disabledSortTable']) ? json_encode($config['disabledSortTable']) : '[]' !!}
        var showAllDatatable = '{{ isset($config['showAll']) ? 1 : 0 }}'
        var imageSpinner = "{{ asset('img/load-inti.gif') }}"
        var ifExport = '0'
        var urlExport = ''
        var branches = []
        var categories = []
        var reqFilter = {
            'search': '{{ request()->search }}',
            'page': '{{ request()->page ?? 0 }}',
            'page_length': '{{ request()->page_length ?? 50 }}',
            'order': {!! request()->order ? request()->order : '[]' !!}
        }
        var showFilter = '{{ $countFilter }}'

        $('.select2').select2()

        @if (Route::has($type . '-export') && getRoleUser(request()->route()->getName(), 'export'))
            urlExport = '{{ route($type . '-export') }}'
            var ifExport = '1'
        @endif

        @if (isset($branch_id))
            branches = {!! json_encode($branch_id['data']) !!}
        @endif

        @if (isset($category_id))
            categories = {!! json_encode($category_id['data']) !!}
        @endif
    </script>
    <script type="text/javascript" src="{{ asset('js/load-datatable2.js') }}?v={{ date('YmdHis') }}"></script>
    @if (!request()->ajax())
    @endpush
@endif
