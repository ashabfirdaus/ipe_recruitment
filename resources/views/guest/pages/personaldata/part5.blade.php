<form action="{{ route('guest-save-personal-data', ['id' => id_exist($personal), 'part' => 5]) }}" method="post"
    class="action-post">
    <label class="text-bold">V. {{ strtoupper(getMultiLang('organization')) }}</label>
    <div class="table-responsive">
        <table class="table table-bordered" style="width:100%;">
            <tr>
                <th style="min-width:200px;">{{ getMultiLang('organization_name') }}</th>
                <th style="min-width:150px;">{{ getMultiLang('period') }} </th>
                <th style="min-width:200px;">{{ getMultiLang('position') }}</th>
            </tr>
            @for ($o = 0; $o < 3; $o++)
                <tr>
                    <td>
                        <input type="text" name="organization_name_{{ $o }}"
                            value="{{ val_exist_with_multi_data($personal, 'organization', 'organization_name_' . $o) }}"
                            class="form-control">
                    </td>
                    <td>
                        <input type="text" name="year_{{ $o }}" class="form-control"
                            value="{{ val_exist_with_multi_data($personal, 'organization', 'year_' . $o) }}">
                    </td>
                    <td>
                        <input type="text" name="position_{{ $o }}" class="form-control"
                            value="{{ val_exist_with_multi_data($personal, 'organization', 'position_' . $o) }}">
                    </td>
                </tr>
            @endfor
        </table>
    </div>
    <div class="pull-right top-10">
        <button type="button" class="btn btn-default prev" data-prev="3">
            <i class="icon-arrow-left8 position-left"></i>Sebelumnya
        </button>
        <button type="submit" class="btn btn-primary">
            Simpan dan lanjutkan <i class="icon-floppy-disk position-right"></i>
        </button>
        <button type="button" class="btn btn-default next" data-next="5" style="display: none;">Selanjutnya
            <i class="icon-arrow-right8 position-right"></i>
        </button>
    </div>
</form>
