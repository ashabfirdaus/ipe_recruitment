var parameter = { type: type }
var keyupTimer;
var tableHeight = 0;

setParam()

function setParam() {
    for (let a = 0; a < filterDatatable.length; a++) {
        let name = filterDatatable[a]['name'];
        let valName = filterDatatable[a]['name']
        if (filterDatatable[a].hasOwnProperty('multiple')) {
            valName = valName + '[]'
        }

        parameter[name] = function () {
            return $('[name="' + valName + '"]').val()
        }
    }
}

if (reqFilter.order) {
    sorting = reqFilter.order
} else {
    sorting = []
    for (let i = 0; i < orderDatatable.length; i++) {
        let temp = [selectDatatable.indexOf(orderDatatable[i][0]), orderDatatable[i][1]]
        sorting.push(temp)
    }
}

var resDataTable = $('#dataTable').DataTable({
    paging: (showAllDatatable == '1' ? false : true),
    pageLength: parseInt(reqFilter.page_length),
    oSearch: {
        sSearch: reqFilter.search
    },
    displayStart: reqFilter.page_length * reqFilter.page,
    processing: true,
    serverSide: true,
    order: sorting,
    autoWidth: false,
    ajax: {
        url: urlDatatable,
        type: "post",
        data: parameter,
    },
    columns: SetColumnDatatable(),
    dom: '<"datatable-header"fl><"datatable-scroll"tr><"datatable-footer"ip>',
    language: {
        search: '<span>Filter:</span> _INPUT_',
        searchPlaceholder: 'Ketik untuk filter',
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
    drawCallback: function () {
        var api = this.api();
        reqFilter.page = api.page()
        let heightDatatable = $('#dataTable').height()
        let elementProcess = $('#dataTable_processing')
        elementProcess.css('height', heightDatatable + 'px').css('padding-top', heightDatatable / 2 + 'px')
        // if (Object.keys(groupDatatable).length > 0) {
        //     var rows = api.rows({ page: 'current' }).nodes();
        //     var last = null;
        //     api.column($('.groupdatatable').val(), { page: 'current' }).data().each(function (group, i) {
        //         if (last !== group) {
        //             $(rows).eq(i).before(
        //                 '<tr class="group"><td colspan="' + selectDatatable.length + '">' + group + '</td></tr>'
        //             );

        //             last = group;
        //         }
        //     });
        // }

        tableHeight = $(".datatable-scroll").prop("scrollHeight")

        processAfterLoad(api)
    }
});

$('body').on('click', '.dropdown-toggle', function () {
    if (!$(this).parent().hasClass('open')) {
        setTimeout(() => {
            let newTableHeight = $(".datatable-scroll").prop("scrollHeight")
            if (newTableHeight > tableHeight) {
                $(".datatable-scroll").css('height', newTableHeight + 'px')
            }
        }, 100);
    }

    $(this).parents('.open').on('hidden.bs.dropdown', function (e) {
        $(".datatable-scroll").css('height', '')
    });
})

if (filterDatatable.length > 0) {
    $('.dataTables_filter').after(
        '<div style="float:left;padding-left:10px;"><a href="javascript:void(0)" class="btn btn-default btn-show-filter ' + (showFilter != '0' ? 'btn-primary' : '') + '"><i class="icon-filter4 position-left"></i> Filter</a></div>'
    )
}

if (ifExport == 1) {
    $('.dataTables_filter').after(
        '<div style="float:left;padding-left:10px;"><a href="javascript:void(0)" class="btn btn-success btn-export-data"><i class="icon-download position-left"></i> Ekspor</a></div>'
    )
}

$('.btn-show-filter').click(function () {
    $('.element-filter').slideToggle();
    $(this).toggleClass("btn-primary");
})

function SetColumnDatatable() {
    let data = []
    for (let i = 0; i < selectDatatable.length; i++) {
        let explode = selectDatatable[i].split('.')
        data.push({
            name: selectDatatable[i],
            data: explode[explode.length - 1]
        })

        if (widthDatatable[i] != null) {
            data[i]['width'] = widthDatatable[i] + 'px'
        }

        if (selectDatatable[i] == 'action') {
            data[i]['className'] = 'table-action'
        }

        if (disabledSortDatatable.length > 0) {
            data[i]['orderable'] = disabledSortDatatable.includes(i) ? false : true
        }

        if (decimalFormatNumberDatatable.includes(selectDatatable[i])) {
            data[i]['className'] = 'text-right';
            data[i]['render'] = function (data) {
                return data ? formatNumber(data, 4) : 0;
            }
        }

        if (decimalFormatRupiahDatatable.includes(selectDatatable[i])) {
            data[i]['className'] = 'text-right';
            data[i]['render'] = function (data) {
                return data ? formatRupiah(data, 2) : 0;
            }
        }
    }

    return data;
}

if ($('.filter-daterange').length > 0) {
    $('.filter-daterange').daterangepicker({
        timePicker: false,
        autoUpdateInput: false,
        autoApply: true,
        locale: {
            format: 'DD/MM/YYYY'
        },
    });
}

$('.filter-select2').each(function () {
    if ($(this).hasClass('select2ajax')) {
        let url = $(this).data('route')
        let label = $(this).data('label')
        $(this).select2({
            minimumInputLength: 1,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    let query = {
                        search: params.term,
                    }
                    return query;
                },
                processResults: function (data) {
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

$('.filter-daterange').on('apply.daterangepicker', function (ev, picker) {
    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    resDataTable.ajax.reload()
    makeHistoryUrl()
});

$('.filter-daterange').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
    resDataTable.ajax.reload()
    makeHistoryUrl()
});

$('.filter-select2').on('select2:select', function () {
    resDataTable.ajax.reload()
    makeHistoryUrl()
}).on('change', function () {
    resDataTable.ajax.reload()
    makeHistoryUrl()
})

$('.filter-text').change(function () {
    resDataTable.ajax.reload()
    makeHistoryUrl()
})

$('.btn-reset').click(function () {
    $('.element-filter').find('input,select').each(function (i, v) {
        if ($(v).prop("tagName") == 'SELECT') {
            let label = $(v).data('label')
            $(v).val('all').change()
        } else {
            $(v).val('')
        }
    })

    resDataTable.ajax.reload()
    makeHistoryUrl()
})

$('.groupdatatable').select2().on('select2:select', function () {
    resDataTable.ajax.reload()
    makeHistoryUrl()
})

$('.selectbranch').change()

$('.selectbranch').select2().on('select2:select', function (e) {
    let resSelect2 = e.params.data
    let warehouseData = branches.filter(x => x.id == resSelect2.id);
    if (warehouseData.length > 0) {
        $('[name="warehouse_id"]').empty()
        $('[name="warehouse_id"]').select2({
            data: [
                { id: 'all', 'text': "Semua Gudang" }
                , ...warehouseData[0].format_warehouses
            ]
        })
    } else {
        $('[name="warehouse_id"]').empty()
        $('[name="warehouse_id"]').select2({
            data: [
                { id: 'all', 'text': "Semua Gudang" }
            ]
        })
    }
})

$('.selectcategory').change()

$('.selectcategory').select2().on('select2:select', function (e) {
    let resSelect2 = e.params.data
    let subData = categories.filter(x => x.id == resSelect2.id);
    if (subData.length > 0) {
        $('[name="sub_category_id"]').empty()
        $('[name="sub_category_id"]').select2({
            data: [
                { id: 'all', 'text': "Semua Sub Kategori" }
                , ...subData[0].format_sub_categories
            ]
        })
    } else {
        $('[name="sub_category_id"]').empty()
        $('[name="sub_category_id"]').select2({
            data: [
                { id: 'all', 'text': "Semua Sub Kategori" }
            ]
        })
    }
})

$('.btn-export-data').click(function () {
    $('#cover-spin').show()
    $.ajax({
        url: urlExport,
        data: { ...parameter, 'search': function () { return $('input[type="search"]').val() } },
        type: 'get',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = type + '.xlsx';
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
            $('#cover-spin').hide()
        }, error: function (error) {
            toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
            $('#cover-spin').hide()
        }
    })
})

function makeHistoryUrl() {
    let current = window.location.href
    current = current.replace(window.location.search, '')
    let param = []
    $('.element-filter').find('input,select').each(function (i, v) {
        let val = $(v).val() ? $(v).val() : ''
        let name = $(v).prop('name');
        if (name.indexOf('[]') > -1) {
            name = name.replace('[]', '')
        }

        if (val != 'all' && val != '') {
            param.push(name + '=' + val)
        }
    })

    for (const property in reqFilter) {
        if (reqFilter[property] !== '') {
            if (Array.isArray(reqFilter[property])) {
                param.push(property + '=' + JSON.stringify(reqFilter[property]))
            } else {
                param.push(property + '=' + reqFilter[property])
            }
        }
    }

    let newUrl = param.length > 0 ? current + '?' + param.join('&') : current
    window.history.pushState(null, null, newUrl);
}

resDataTable.on('search.dt', function () {
    clearTimeout(keyupTimer);
    keyupTimer = setTimeout(function () {
        if ($('[type="search"]').val() != reqFilter.search) {
            reqFilter.search = $('[type="search"]').val()
            makeHistoryUrl()
        }
    }, 1000);
});

resDataTable.on('length.dt', function (e, settings, len) {
    reqFilter.page_length = len
    makeHistoryUrl()
});

resDataTable.on('page.dt', function (e, settings) {
    reqFilter.page = resDataTable.page.info().page
    makeHistoryUrl()
})

resDataTable.on('order.dt', function () {
    let order = resDataTable.order();
    if (order.length > 0) {
        reqFilter.order = order
        makeHistoryUrl()
    }
})

function processAfterLoad(api) {
    // console.log('main')
}