<style>
    .table-responsive th {
        background-color: #f58c8c;
        color: white;
        padding: 5px !important;
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
    <form class="form-horizontal post-action" action="{{ route('role-save', id_exist($data)) }}" method="post">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">
                    {{ $data ? 'Edit' : 'Tambah' }}
                    {{ getAttributPage($menu, request()->route()->getName(), 'label') }}
                </h5>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-4 control-label">
                                        Nama Peran <span class="required">*</span>
                                    </label>
                                    <div class="col-md-8 form-group">
                                        <input type="text" name="role_name"
                                            value="{{ val_exist($data, 'role_name') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 control-label">Status <span class="required">*</span></label>
                                    <div class="col-md-5 form-group ">
                                        <select class="form-control" name="status">
                                            <option value="1"
                                                {{ val_exist($data, 'status') == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0"
                                                {{ val_exist($data, 'status') == '0' ? 'selected' : '' }}>Tidak Aktif
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="icon-floppy-disk position-left"></i> Simpan
                        </button>
                        <a href="{{ route('role') }}" class="btn btn-default me btn-block">
                            <i class="icon-undo2 position-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">Akses Halaman</h6>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50px;"></th>
                        <th>Menu</th>
                        <th>Read</th>
                        <th>Create</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Cetak</th>
                        <th>Export</th>
                        <th>Import</th>
                        <th>Lain-Lain</th>
                    </tr>
                    @foreach (getMenu(true) as $key => $menu)
                        @if ($menu['route'] != 'newsection')
                            @if (sizeof($menu['submenu']) > 0)
                                <tr>
                                    <td colspan="11"
                                        style="background-color:rgb(231, 229, 229);text-transform: uppercase;">
                                        {{ $menu['label'] }}</td>
                                </tr>
                                @foreach ($menu['submenu'] as $submenu)
                                    <tr>
                                        <td><a href="javascript:void(0)" class="checklist-row"><i
                                                    class="icon-arrow-right8"></i></a></td>
                                        <td>{{ $submenu['label'] }}</td>
                                        <td>
                                            @if (in_array('read', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][read]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'read') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('create', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][create]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'create') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('view', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][view]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'view') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('edit', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][edit]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'edit') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('delete', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][delete]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'delete') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('print', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][print]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'print') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('export', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][export]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'export') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @if (in_array('import', $submenu['activity']))
                                                <input type="checkbox" name="rules[{{ $submenu['route'] }}][import]"
                                                    {{ checkbox_exist(val_exist($data, 'rules', []), $submenu['route'], 'import') }}>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach (array_diff($submenu['activity'], $exist_column) as $other)
                                                <input type="checkbox"
                                                    name="rules[{{ $submenu['route'] }}][{{ $other }}]"
                                                    {{ checkbox_array_exist(val_exist($data, 'rules', []), $submenu['route'], 'other', $other) }}>
                                                {{ $other }}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td><a href="javascript:void(0)" class="checklist-row"><i
                                                class="icon-arrow-right8"></i></a></td>
                                    <td>{{ $menu['label'] }}</td>
                                    <td>
                                        @if (in_array('read', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][read]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'read') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('create', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][create]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'create') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('view', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][view]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'view') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('edit', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][edit]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'edit') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('delete', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][delete]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'delete') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('print', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][print]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'print') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('export', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][export]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'export') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @if (in_array('import', $menu['activity']))
                                            <input type="checkbox" name="rules[{{ $menu['route'] }}][import]"
                                                {{ checkbox_exist(val_exist($data, 'rules', []), $menu['route'], 'import') }}>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach (array_diff($menu['activity'], $exist_column) as $other)
                                            <input type="checkbox"
                                                name="rules[{{ $menu['route'] }}][{{ $other }}]"
                                                {{ checkbox_array_exist(val_exist($data, 'rules', []), $menu['route'], 'other', $other) }}>
                                            {{ $other }}<br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </form>
</div>

@if (!request()->ajax())
    @push('scripts')
    @endif
    <script>
        $('.checklist-row').click(function() {
            let input = $(this).parents('tr').find('input[type="checkbox"]')
            if ($(input[0]).is(':checked') == true) {
                input.prop('checked', false)
            } else {
                input.prop('checked', true)
            }
        })
    </script>
    @if (!request()->ajax())
    @endpush
@endif
