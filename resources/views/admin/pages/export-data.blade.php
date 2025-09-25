<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="{{ getAttributPage($menu,request()->route()->getName(),'icon') }} position-left"></i> <span
                    class="text-semibold">{{ getAttributPage($menu,request()->route()->getName(),'label') }}</span></h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal" method="get" action="{{ route('export_data_process') }}" target="_blank">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-md-4 control-label">Tanggal Awal</label>
                            <div class="col-md-8 form-group">
                                <input type="date" name="start_date" value="{{ date('Y-m-d') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label">Tanggal Akhir</label>
                            <div class="col-md-8 form-group">
                                <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label">Data</label>
                            <div class="col-md-6 form-group">
                                <select class="form-control" name="select_data">
                                    <option value="SalesInvoice">Sales Invoice</option>
                                    <option value="SalesReceipt">Sales Receipt</option>
                                    <option value="SalesRefund">Sales Refund</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label">Outlet</label>
                            <div class="col-md-6 form-group">
                                <select class="form-control" name="branch_id">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" data-code="{{ $branch->branch_code }}">
                                            {{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label">Kode Outlet</label>
                            <div class="col-md-5 form-group">
                                <input type="text" name="branch_code" value="{{ $branches[0]->branch_code }}"
                                    readonly class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <label class="col-md-3 control-label">Pilih Kode Tertentu</label>
                            <div class="col-md-9 form-group">
                                <select name="multi_trans_id[]" class="form-control" multiple></select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="icon-download position-left"></i> Eksport
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script>
        let urlAutoTrans = "{{ route('transaction-autocomplete') }}";
        var outlates = {!! $branches !!};
        for (let i = 0; i < outlates.length; i++) {
            if (localStorage.getItem('magicOutlate') == outlates[i].id) {
                $('[name="branch_code"]').val(outlates[i].branch_code)
                break
            }
        }

        $('[name="branch_id"]').val(localStorage.getItem('magicOutlate'))


        $('[name="branch_id"]').change(function() {
            for (let i = 0; i < outlates.length; i++) {
                if ($(this).val() == outlates[i].id) {
                    $('[name="branch_code"]').val(outlates[i].branch_code)
                    break
                }
            }
        })

        $('[name="multi_trans_id[]"]').select2({
            ajax: {
                url: urlAutoTrans,
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    let query = {
                        search: params.term,
                        branch_id: $('[name="branch_id"]').val(),
                        start_date_payment: $('[name="start_date"]').val(),
                        end_date_payment: $('[name="end_date"]').val()
                    }
                    return query;
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        })
    </script>
    @if (!request()->ajax())
    @endpush
@endif
