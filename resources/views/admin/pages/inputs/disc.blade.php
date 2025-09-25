<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="{{ getAttributPage($menu, request()->route()->getName(), 'icon') }} position-left"></i> <span
                    class="text-semibold">{{ getAttributPage($menu, request()->route()->getName(), 'label') }}</span>
            </h4>
        </div>
    </div>
</div>
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-11">
                    <h5 class="panel-title">{{ $data ? 'Edit' : 'Tambah' }}
                        {{ getAttributPage($menu, request()->route()->getName(), 'label') }}</h5>
                </div>
                <div class="col-md-1 text-right">
                    <select name="set_lang" class="form-control select2">
                        <option value="en" selected>EN</option>
                        <option value="id">ID</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal post-action" action="{{ route('disc-save', id_exist($data)) }}" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">Label <span class="required">*</span></label>
                            <div class="col-md-9 form-group">
                                <input type="text" name="question_number"
                                    value="{{ val_exist($data, 'question_number') }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Urutan <span class="required">*</span></label>
                            <div class="col-md-3 form-group">
                                <input type="number" name="sequence" value="{{ val_exist($data, 'sequence') }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="text-bold">JAWABAN</label>
                        @if (count(val_exist($data, 'details', [])) > 0)
                            @foreach ($data->details as $key => $detail)
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ $detail->alphabet }}</span>
                                        <input type="text" name="options[{{ $key }}][text][en]"
                                            class="form-control en" value="{{ uselang($detail->desc, 'en') }}">
                                        <input type="text" name="options[{{ $key }}][text][id]"
                                            class="form-control id" value="{{ uselang($detail->desc, 'id') }}">
                                        <input type="hidden" name="options[{{ $key }}][id]"
                                            value="{{ $detail->id }}">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @php
                                $rangeAlphabet = range('A', 'D');
                            @endphp
                            @for ($i = 0; $i < 4; $i++)
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ $rangeAlphabet[$i] }}</span>
                                        <input type="text" name="options[{{ $i }}][text][en]"
                                            class="form-control en">
                                        <input type="text" name="options[{{ $i }}][text][id]"
                                            class="form-control id">
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
                <hr>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk position-left"></i>
                        Simpan</button>
                    <a href="{{ route('disc') }}" class="btn btn-default me"><i class="icon-undo2 position-left"></i>
                        Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script>
        $('.select2').select2()
        $('form').find('.en,.id').hide()
        $('.' + $('[name="set_lang"]').val()).show()
        $('[name="set_lang"]').change(function() {
            $('form').find('.en,.id').hide()
            $('.' + $('[name="set_lang"]').val()).show()
        })
    </script>
    @if (!request()->ajax())
    @endpush
@endif
