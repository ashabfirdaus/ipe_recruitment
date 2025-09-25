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
            <form class="form-horizontal post-action" action="{{ route('iq-save', id_exist($data)) }}" method="post"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label">Pertanyaan <span class="required">*</span></label>
                            <div class="col-md-9 form-group">
                                <textarea name="question[en]" class="form-control en" rows="5">{{ uselang(val_exist($data, 'question'), 'en') }}</textarea>
                                <textarea name="question[id]" class="form-control id" rows="5">{{ uselang(val_exist($data, 'question'), 'id') }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Gambar 1</label>
                            <div class="col-md-9 form-group">
                                <input type="file" name="media_id1" class="form-control">
                            </div>
                            @if (val_exist($data, 'media_id1') && file_exists(public_path($data->media1->path)))
                                <img src="{{ asset($data->media1->path) }}" alt=""
                                    style="max-width:100px;margin-top:10px;">
                            @endif
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Gambar 2</label>
                            <div class="col-md-9 form-group">
                                <input type="file" name="media_id2" class="form-control">
                            </div>
                            @if (val_exist($data, 'media_id2') && file_exists(public_path($data->media2->path)))
                                <img src="{{ asset($data->media2->path) }}" alt=""
                                    style="max-width:100px;margin-top:10px;">
                            @endif
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Gambar 3</label>
                            <div class="col-md-9 form-group">
                                <input type="file" name="media_id3" class="form-control">
                            </div>
                            @if (val_exist($data, 'media_id3') && file_exists(public_path($data->media3->path)))
                                <img src="{{ asset($data->media3->path) }}" alt=""
                                    style="max-width:100px;margin-top:10px;">
                            @endif
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Urutan <span class="required">*</span></label>
                            <div class="col-md-9 form-group">
                                <input type="number" name="sequence" class="form-control"
                                    value="{{ val_exist($data, 'sequence') }}">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label">Status <span class="required">*</span></label>
                            <div class="col-md-5 form-group ">
                                <select class="form-control" name="status">
                                    <option value="1" {{ val_exist($data, 'status') == '1' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="0" {{ val_exist($data, 'status') == '0' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
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
                                            class="form-control en" value="{{ useLang($detail->desc, 'en') }}"
                                            placeholder="Masukkan jawaban">
                                        <input type="text" name="options[{{ $key }}][text][id]"
                                            class="form-control id" value="{{ useLang($detail->desc, 'id') }}"
                                            placeholder="Masukkan jawaban">
                                        <input type="file" name="options[{{ $key }}][media_id]"
                                            class="form-control">
                                        <input type="hidden" name="options[{{ $key }}][id]"
                                            value="{{ $detail->id }}">
                                    </div>
                                    @if ($detail->media_id)
                                        <img src="{{ asset($detail->media->path) }}" alt=""
                                            style="max-width:100px;margin-top:10px;">
                                    @endif
                                </div>
                            @endforeach
                        @else
                            @php
                                $rangeAlphabet = range('A', 'H');
                            @endphp
                            @for ($i = 0; $i < 8; $i++)
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">{{ $rangeAlphabet[$i] }}</span>
                                        <input type="text" name="options[{{ $i }}][text][en]"
                                            class="form-control en" placeholder="Masukkan Jawaban">
                                        <input type="text" name="options[{{ $i }}][text][id]"
                                            class="form-control id" placeholder="Masukkan Jawaban">
                                        <input type="file" name="options[{{ $i }}][media_id]"
                                            class="form-control">
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="icon-floppy-disk position-left"></i>
                        Simpan</button>
                    <a href="{{ route('iq') }}" class="btn btn-default me"><i
                            class="icon-undo2 position-left"></i> Kembali</a>
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
