<style>
    .l2 {
        padding-left: 1em;
    }

    .l1 {
        font-weight: bold;
    }

    .fixedHeader-floating {
        top: 48px !important;
        table-layout: auto !important;
    }

    .dataTables_filter,
    .dataTables_length {
        margin-bottom: 0px;
    }

    #dataTable {
        table-layout: fixed !important;
        word-wrap: break-word;
    }

    .dataTable th,
    .dataTable td {
        padding: 5px !important;
    }

    .dataTables_scroll .dataTables_scrollBody td,
    .dataTables_scroll .dataTables_scrollBody th {
        white-space: unset;
    }

    .dataTables_scroll .dataTables_scrollHead td,
    .dataTables_scroll .dataTables_scrollHead th {
        white-space: unset;
    }

    .panel-heading,
    .panel-flat>.panel-heading {
        padding: 10px;
    }

    .content {
        padding: 0 20px 20px 20px
    }

    .limit-text {
        white-space: nowrap !important;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .limit-text:hover {
        overflow: visible;
        white-space: normal !important;
    }

    .datatable-header {
        padding-bottom: 10px;
    }

    .dropdown-menu {
        width: 228px;
    }

    .dataTable thead .sorting:after,
    .dataTable thead .sorting:before,
    .dataTable thead .sorting_asc:after,
    .dataTable thead .sorting_asc_disabled:after,
    .dataTable thead .sorting_desc:after,
    .dataTable thead .sorting_desc_disabled:after {
        right: 5px;
    }

    .dataTable thead .sorting,
    .dataTable thead .sorting_asc,
    .dataTable thead .sorting_asc_disabled,
    .dataTable thead .sorting_desc,
    .dataTable thead .sorting_desc_disabled {
        padding-right: 15px;
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
        <ul style="list-style-type: none;margin: 0;padding: 0;border-bottom:1px solid #ddd;">
            @foreach ($status_employee['data'] as $status)
                <li style="display: inline-block;padding:5px;">
                    <a href="javascript:void(0)" data-label="{{ $status->text }}"
                        class="status_employee_change btn btn-default {{ $status_employee['default'] == $status->id ? 'btn-info' : '' }} btn-rounded">{{ $status->text }}
                        @if ($status->id != '')
                            <label class="label label-danger label-rounded"
                                style="margin-left:5px;">{{ isset($data_status_employee[$status->text]) ? $data_status_employee[$status->text] : 0 }}</label>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        @php
            $filter = isset($config['filter']) ? $config['filter'] : [];
        @endphp
        @if (count($filter) > 0)
            <form id="formFilter" class="panel-heading element-filter" style="display: none;">
                <div class="row">
                    @foreach ($filter as $fill)
                        @if ($fill['type'] == 'select' && isset(${$fill['name']}))
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control filter-select2" name="{{ $fill['name'] }}">
                                    <option value="all">Semua {{ $fill['label'] }}</option>
                                    @php
                                        $countMatchOption = 0;
                                    @endphp
                                    @foreach (${$fill['name']}['data'] as $fdata)
                                        @php
                                            $selectSingle = '';
                                            if (
                                                request()->{$fill['name']} &&
                                                strtolower(request()->{$fill['name']}) == strtolower($fdata->id)
                                            ) {
                                                $countMatchOption++;
                                                $selectSingle = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $fdata->id }}" {{ $selectSingle }}>
                                            {{ $fdata->text }}</option>
                                    @endforeach
                                    @if (request()->{$fill['name']} && $countMatchOption == 0)
                                        <option value="{{ request()->{$fill['name']} }}" selected>
                                            {{ request()->{$fill['name']} }}</option>
                                    @endif
                                </select>
                            </div>
                        @endif
                        @if ($fill['type'] == 'text')
                            <div class="col-md-3">
                                <label for="">{{ $fill['label'] }}</label>
                                <div class="form-group">
                                    <input type="text" class="form-control filter-text" name="{{ $fill['name'] }}">
                                </div>
                            </div>
                        @endif
                        {{-- @if ($fill['type'] == 'multiple' && isset(${$fill['name']}))
                            <div class="col-md-6">
                                <label for="">{{ $fill['label'] }}</label>
                                <select class="form-control filter-select2 multiple" name="{{ $fill['name'] }}[]"
                                    multiple="multiple">
                                    @foreach (${$fill['name']}['data'] as $fdata)
                                        <option value="{{ $fdata->id }}"
                                            {{ request()->{$fill['name']} ? (in_array($fdata->id, request()->{$fill['name']}) ? 'selected' : '') : (!empty($fdata->default) && $fdata->default ? 'selected' : '') }}>
                                            {{ $fdata->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif --}}
                    @endforeach
                </div>
            </form>
        @endif
        <div class="table-responsive">
            <table class="table" id="dataTable" style="width:100%;">
                <thead>
                    <tr>
                        @foreach ($config['labelTable'] as $kcol => $col)
                            <th class="no-sort"><b>{{ ucwords($col) }}</b>
                        @endforeach
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script src="{{ asset('packages/datatables/datatables.min.js') }}"></script>
    <script>
        var reqFilter = {
            'search': '{{ request()->search }}',
            'page': '{{ request()->page ?? 0 }}',
            'page_length': '{{ request()->page_length ?? 50 }}',
            'order_column': '{{ request()->order_column }}',
            'order_method': '{{ request()->order_method }}'
        }

        var type = '{{ $type }}'
        var urlDatatable = "{{ route($type . '-datatable') }}?type=" + type;
        var widthDatatable = {!! json_encode($config['widthTable']) !!}
        var selectDatatable = {!! json_encode($config['selectTable']) !!}
        var filterDatatable = {!! json_encode($config['filter']) !!}
        var customClass = {!! json_encode($config['customClass']) !!}
        var imageSpinner = "{{ asset('img/ellipsis.gif') }}"
        var idSelected = []
        var parameter = {
            type: type,
        }
        var keyupTimer;
        var sorting = []

        setParam()

        function setParam() {
            for (let a = 0; a < filterDatatable.length; a++) {
                parameter[filterDatatable[a]['name']] = function() {
                    if (filterDatatable[a]['type'] == 'multiple') {
                        return $('[name="' + filterDatatable[a]['name'] + '[]"]').val()
                    }
                    return $('[name="' + filterDatatable[a]['name'] + '"]').val()
                }
            }
        }

        function addURL() {
            var global = $('input[type="search"]').val();
            var url = "{{ route($type . '-export-excel') }}?_globalSearch=" + global + '&' + $('#formFilter').serialize();
            var win = window.open(url, '_blank');
            if (win) {
                win.focus();
            } else {
                alert('Please allow popups for this website');
            }
        }

        $(window).trigger('resize')

        $(window).resize(function() {
            // if (parseInt($('#dataTable').css('height')) >= $(window).height() - 360) {
            $('.dataTables_scrollBody').css('height', ($(window).height() - 360));
            $('.dataTables_scrollBody').css('max-height', ($(window).height() - 360));
            // }
        });


        if (reqFilter.order_column && reqFilter.order_method) {
            sorting = [
                [reqFilter.order_column, reqFilter.order_method]
            ]
        } else {
            sorting = []
        }

        var resDataTable = $('#dataTable').DataTable({
            pageLength: parseInt(reqFilter.page_length),
            oSearch: {
                sSearch: reqFilter.search
            },
            displayStart: reqFilter.page_length * reqFilter.page,
            processing: true,
            serverSide: true,
            order: sorting,
            scrollX: true,
            scrollY: '55vh',
            scrollCollapse: true,
            autoWidth: false,
            ajax: {
                url: urlDatatable,
                type: "post",
                data: parameter,
            },
            columns: forTableData(),
            dom: '<"datatable-header"fl><"datatable-scroll"tr><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Tampil:</span> _MENU_',
                processing: '<img src="' + imageSpinner + '" alt="">',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': '→',
                    'previous': '←'
                },
                emptyTable: "Data Tidak Ditemukan",
            },
            drawCallback: function(settings) {
                var api = this.api();
                reqFilter.page = api.page()

                let heightDatatable = $('.datatable-scroll').height()
                let elementProcess = $('#dataTable_processing')
                elementProcess.css('height', heightDatatable + 'px').css('padding-top', heightDatatable / 2 +
                    'px')
            }
        });
        var labelFilter =
            '<div style="float:left;padding-left:10px;"><a href="javascript:void(0)" class="btn btn-default btn-show-filter"><i class="icon-filter4 position-left"></i> Filter</a>';
        @if (isset($config['export']) && $config['export'] == true)
            labelFilter +=
                ' <a onclick="addURL(this)" href="javascript:void(0)" class="btn btn-success export-data"> Export <i class="icon-file-excel"></i></a>';
        @endif
        labelFilter += '</div>';
        $('.dataTables_filter').after(labelFilter)

        var labelAction =
            '<div style="float:right;padding-left:10px;"><div class="btn-group" style="display:none;">' +
            '<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu7"></i> &nbsp;<span class="caret"></span></button>' +
            '<ul class="dropdown-menu dropdown-menu-right">' +
            '<li><a href="javascript:void(0)" class="btn-group-change" data-status="TIDAK SESUAI">TIDAK SESUAI</a></li>' +
            // '<li><a href="javascript:void(0)" class="btn-group-change" data-status="INTERVIEW HRD">INTERVIEW HRD</a></li>' +
            // '<li><a href="javascript:void(0)" class="btn-group-change" data-status="INTERVIEW USER">INTERVIEW USER</a></li>' +
            '<li><a href="javascript:void(0)" class="btn-group-change" data-status="FINAL PROSES">FINAL PROSES</a></li>' +
            '<li><a href="javascript:void(0)" class="btn-group-change" data-status="NEGOSIASI">NEGOSIASI</a></li>' +
            '<li><a href="javascript:void(0)" class="btn-group-change" data-status="DITERIMA">DITERIMA</a></li>' +
            '<li><a href="javascript:void(0)" class="btn-group-change" data-status="TINJAUAN AWAL">TINJAUAN AWAL</a></li>' +
            '<li><a href="javascript:void(0)" class="btn-group-change" data-status="TES LAB">TES LAB</a></li>' +
            '</ul></div>';
        $('#dataTable_length').after(labelAction)

        $('.btn-show-filter').click(function() {
            $('.element-filter').slideToggle();
            $(this).toggleClass("btn-primary");
        })

        function forTableData() {
            let data = []
            for (let i = 0; i < selectDatatable.length; i++) {
                if (customClass[i] == undefined) {
                    data.push({
                        name: selectDatatable[i],
                        data: selectDatatable[i],
                        width: widthDatatable[i],
                    })
                } else {
                    data.push({
                        name: selectDatatable[i],
                        data: selectDatatable[i],
                        width: widthDatatable[i],
                        className: customClass[i]
                    })
                }

            }

            return data;
        }

        $('.filter-select2').each(function() {
            if ($(this).hasClass('select2ajax')) {
                let url = $(this).data('route')
                let label = $(this).data('label')
                $(this).select2({
                    minimumInputLength: 1,
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 100,
                        data: function(params) {
                            let query = {
                                search: params.term,
                            }
                            return query;
                        },
                        processResults: function(data) {
                            let newVal = [{
                                    id: 'all',
                                    text: 'Semua ' + label
                                },
                                ...data
                            ]
                            return {
                                results: newVal
                            };
                        }
                    }
                });
            } else {
                $(this).select2()
            }
        })

        $('.filter-select2').on('select2:select', function() {
            resDataTable.ajax.reload()
            makeHistoryUrl()
        }).on('change', function() {
            resDataTable.ajax.reload()
            makeHistoryUrl()
        })

        $('.filter-text').change(function() {
            resDataTable.ajax.reload()
        })

        resDataTable.on('search.dt', function() {
            clearTimeout(keyupTimer);
            keyupTimer = setTimeout(function() {
                if ($('[type="search"]').val() != reqFilter.search) {
                    reqFilter.search = $('[type="search"]').val()
                    makeHistoryUrl()
                }
            }, 1000);
        });

        resDataTable.on('length.dt', function(e, settings, len) {
            reqFilter.page_length = len
            makeHistoryUrl()
        });

        resDataTable.on('page.dt', function(e, settings) {
            reqFilter.page = resDataTable.page.info().page
            makeHistoryUrl()
        })

        resDataTable.on('order.dt', function() {
            let order = resDataTable.order();
            if (order.length > 0) {
                if (order[0][0] != reqFilter.order_column || order[0][1] != reqFilter.order_method) {
                    reqFilter.order_column = order[0][0]
                    reqFilter.order_method = order[0][1]
                    makeHistoryUrl()
                }
            }
        })

        $('body').on('click', '.status_employee_change', function() {
            $('.status_employee_change').removeClass('btn-info')
            $(this).toggleClass('btn-info')
            let label = $(this).data('label')
            if (label == 'All') {
                label = label.toLowerCase()
            }

            $('[name="status_employee"]').val(label).change()
        })

        function makeHistoryUrl() {
            let current = window.location.href
            current = current.replace(window.location.search, '')
            let param = []
            $('#formFilter').find('input,select').each(function(i, v) {
                let val = $(v).val() ? $(v).val().trim() : ''
                if (val != 'all' && val != '') {
                    param.push($(v).prop('name') + '=' + val)
                }
            })

            for (const property in reqFilter) {
                if (reqFilter[property] != '') {
                    param.push(property + '=' + reqFilter[property])
                }
            }

            let newUrl = param.length > 0 ? current + '?' + param.join('&') : current
            window.history.pushState(null, null, newUrl);
        }

        $('body').on('change', '[name="ids[]"]', function() {
            if ($(this).is(':checked')) {
                idSelected.push($(this).val())
            } else {
                idSelected.splice(idSelected.indexOf($(this).val()), 1)
            }

            if (idSelected.length > 0) {
                $('.btn-group-change').parents('.btn-group').show()
            } else {
                $('.btn-group-change').parents('.btn-group').hide()
            }
        })

        $('.btn-group-change').click(function() {
            let status = $(this).data('status')
            console.log(status)
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "Kamu akan mengubah menjadi " + status + " semua data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#cover-spin').show()
                    $.ajax({
                        url: '{{ route('applicant-change-status-group') }}?status_employee=' +
                            status,
                        method: 'post',
                        data: {
                            ids: idSelected,
                        },
                        success: function(res) {
                            if (res.status == 'success') {
                                if (res.redirect != '') {
                                    loadPage(res.redirect, self)
                                }

                                toastr.success(res.message)
                            } else {
                                toastr.error(res.message)
                            }

                            $('#cover-spin').hide()
                        },
                        error: function(error) {
                            toastr.error(error.hasOwnProperty('responseJSON') ? error
                                .responseJSON.message : error.statusText)
                            $('#cover-spin').hide()
                        }
                    })
                }
            })
        })
    </script>
    @if (!request()->ajax())
    @endpush
@endif
