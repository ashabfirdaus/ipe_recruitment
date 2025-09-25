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
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                {{ $data ? 'Edit' : 'Tambah' }}
                {{ getAttributPage($menu, request()->route()->getName(), 'label') }}
            </h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal post-action" action="{{ route('account-save', id_exist($data)) }}"
                method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">Nama <span class="required">*</span></label>
                            <div class="col-md-9 form-group">
                                <input type="text" name="name" value="{{ val_exist($data, 'name') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Peran <span class="required">*</span></label>
                            <div class="col-md-5 form-group">
                                <select class="form-control select2" name="role_id">
                                    <option value="">Pilih</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ val_exist($data, 'role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if (id_exist($data) == 0)
                            <div class="row">
                                <label class="col-md-3 control-label">Password <span class="required">*</span></label>
                                <div class="col-md-9 form-group">
                                    <input type="password" name="password" value="" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label">Konfirmasi Password <span
                                        class="required">*</span></label>
                                <div class="col-md-9 form-group">
                                    <input type="password" name="password_confirmation" value=""
                                        class="form-control">
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <label class="col-md-3 control-label">Status <span class="required">*</span></label>
                            <div class="col-md-4 form-group">
                                <select class="form-control select2" name="status">
                                    <option value="1" {{ val_exist($data, 'status') == '1' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="0" {{ val_exist($data, 'status') == '0' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <input type="hidden" name="addresses">
                    @if (getRoleUser(request()->route()->getName(), 'reset_password') && id_exist($data))
                        <a href="{{ route('account-reset', id_exist($data)) }}" class="btn btn-warning me-change">
                            <i class="icon-reset position-left"></i> Reset Password
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-floppy-disk position-left"></i> Simpan
                    </button>
                    <a href="{{ route('account') }}" class="btn btn-default me">
                        <i class="icon-undo2 position-left"></i> Kembali
                    </a>
                </div>
            </form>
            <br>
            <div class="row">
                <div class="col-md-6">
                    @if (val_exist($data, 'referral') && count($data->referral->userreferrals) > 0)
                        <div class="panel">
                            <div class="panel-body">
                                <label for="" class="text-bold">BERGABUNG DENGAN UNDANGAN ANDA</label>
                                <ul>
                                    @foreach ($data->referral->userreferrals as $userreferral)
                                        <li>
                                            {{ $userreferral->user->name }} - {{ $userreferral->user->address }}
                                            ({{ date('d/m/Y H:i:s', strtotime($userreferral->created_at)) }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- @if (count(val_exist($data, 'codeowner', [])) > 0)
                    <div class="panel">
                        <div class="panel-body">
                            <label for="" class="text-bold">BERGABUNG DENGAN UNDANGAN</label>
                            <ul>
                                @foreach ($data->codeowner as $codeowner)
                                <li>{{$codeowner->user->name}} {{$codeowner->user->address}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif --}}
                </div>
                <div class="col-md-6">
                    @if (count(val_exist($data, 'userpackagefilter', [])) > 0)
                        <div class="panel">
                            <div class="panel-body">
                                <b>SALDO PAKET</b>
                                <ul>
                                    @foreach ($data->userpackagefilter as $package)
                                        <li>
                                            {{ $package->package->package_name }} - Rp.
                                            {{ number_format($package->nominal - $package->used) }}
                                            <span class="pull-right">
                                                Disc Expired
                                                {{ date('d F Y', strtotime($package->expired_date)) }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if (count(val_exist($data, 'returnitem', [])) > 0 ||
                            count(val_exist($data, 'codeowner', [])) > 0 ||
                            count(val_exist($data, 'pointrans', [])) > 0)
                        <div class="panel">
                            <div class="panel-body">
                                <b>POIN</b>
                                <ul>
                                    @foreach ($data->returnitem as $returnpoint)
                                        <li>Pengembalian Item <b>{{ number_format($returnpoint->nominal) }}</b> Poin
                                        </li>
                                    @endforeach
                                    @foreach ($data->codeowner as $codeowner)
                                        <li>Referral <b>{{ $codeowner->nominal }}</b> Poin</li>
                                    @endforeach
                                    @foreach ($data->pointrans as $pointrans)
                                        <li>Transaksi <b>{{ number_format($pointrans->point) }}</b> Poin</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.components.modal-media')

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script type="text/javascript" src="{{ asset('js/media.js') }}"></script>
    <script>
        var address = "{{ preg_replace('/\r?\n|\r/', ' ', val_exist($data, 'address')) }}"
        var addresses = {!! val_exist($data, 'addresses') ? json_encode($data->addresses) : '[]' !!};
        var htmlAddress =
            '<div class="input-group form-group loop"><div class="input-group-btn"><button type="button" class="btn-check btn btn-default"><i class="icon-checka"></i></button></div><textarea name="address_text[]" class="form-control"></textarea><div class="input-group-btn"><button type="button" class="btn btn-danger btn-remove"><i class="icon-close2"></i></button></div></div>';
        $('.select2').select2()
        setAddresses()

        $('.select2ajax').select2()
        if ($('.target-address').find('.loop').length == 0) {
            let newHtml = htmlAddress.replace('<textarea name="address_text[]" class="form-control"></textarea>',
                '<textarea name="address_text[]" class="form-control">' + address + '</textarea>')
            newHtml = newHtml.replace(
                '<button type="button" class="btn-check btn btn-default"><i class="icon-checka"></i></button>',
                '<button type="button" class="btn-check btn btn-success"><i class="icon-check"></i></button>')
            $('.btn-add').before(newHtml)
            addresses.push({
                id: null,
                address: address,
                status: 1
            })
        }

        $('.add-address').click(function() {
            addresses.push({
                id: null,
                address: '',
                status: 0
            })
            $(this).parent().before(htmlAddress)
            setAddresses()
        })

        $('body').on('click', '.btn-remove', function() {
            let parent = $(this).parents('.loop')
            let index = parent.index()
            addresses.splice(index, 1)
            parent.remove()
            setAddresses()
        })

        $('body').on('click', '.btn-check', function() {
            $(this).parents('.target-address').find('.loop').each(function(i, v) {
                $(v).find('.btn-check').removeClass('btn-success').addClass('btn-default').html(
                    '<i class="icon-checka"></i>')
                addresses[i].status = '0'
            })

            let index = $(this).parents('.loop').index()
            addresses[index].status = '1'
            $(this).removeClass('btn-default').addClass('btn-success').html('<i class="icon-check"></i>')
            setAddresses()
        })

        $('body').on('input', '[name="address_text[]"]', function() {
            let index = $(this).parents('.loop').index()
            addresses[index].address = $(this).val()
            setAddresses()
        })

        $('[name="status_extra_disc"]').change(function() {
            let val = $(this).val()
            if (val == '0') {
                $('.specific').show();
            } else {
                $('.specific').hide()
            }
        })

        $('.number').on('focus', function() {
            if ($(this).val() == '0') $(this).val('')
        })

        // $('.number').on('focusout', function () {
        //     if ($(this).val() == '') $(this).val('0')
        // })

        $('.number').on('input', function() {
            let val = $(this).val()
            $(this).val(val.replace(/^0\d+/, ''))
        })

        $('.copy-referral').click(function() {
            toastr.success("Menyalin kode referral")
            navigator.clipboard.writeText($('[name="referral_code"]').val());
        })

        function setAddresses() {
            $('[name="addresses"]').val(JSON.stringify(addresses))
        }
    </script>
    @if (!request()->ajax())
    @endpush
@endif
