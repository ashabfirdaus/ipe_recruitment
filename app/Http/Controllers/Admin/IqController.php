<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use App\Models\Master\Iq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IqController extends CoreController
{
    public function __construct()
    {
        $this->parent         = 'iq';
        $this->model          = Iq::class;
        $this->notupdate      = [];
        $this->entryName      = 'iq-entry';
        $this->checkRouteName = request()->route()->getName();
    }

    public function iq()
    {
        if (! getRoleUser($this->checkRouteName, 'read')) {
            return viewNotFound('Access Denied');
        }

        $array = [
            'type'   => 'iq',
            'status' => [
                'type' => 'select',
                'data' => [(object) ['id' => '1', 'text' => 'Aktif'], (object) ['id' => '0', 'text' => 'Non Aktif']],
            ],
        ];

        $view = '';

        if (request()->ajax()) {
            $view = 'iq';
        }

        return setView('admin', 'index-tes', $view, $array);
    }

    public function customColumnDatatable($request, $datatable, $config)
    {
        $datatable = $datatable->editColumn('question', function ($row) {
            return '<a href="' . route('iq-entry', $row->id) . '" class="me">' . uselang($row->question) . '</a>';
        })->editColumn('status', function ($row) {
            return $row->status == '1' ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>';
        });

        return [
            'column' => ['question', 'status'],
            'result' => $datatable,
        ];
    }

    public function validationForm($id)
    {
        $paramValidate = [
            'question' => 'required',
            'sequence' => 'required',
        ];

        return $paramValidate;
    }

    public function inputData($id, $req)
    {
        $data = $req->all();
        for ($i = 1; $i < 4; $i++) {
            if ($req->hasFile('media_id' . $i)) {
                $data['media_id' . $i] = $this->uploadFile($req->file('media_id' . $i));
                if ($id != 0) {
                    $check = Iq::find($id);
                    if ($check && $check->{'media' . $i}) {
                        $path = $check->{'media' . $i}->path;
                        unlink(public_path($path));
                        $check->{'media' . $i}->delete();
                    }
                }
            }
        }

        $data['question'] = json_encode($req->question);

        return $data;
    }

    public function uploadFile($req)
    {
        $media    = $req;
        $size     = $media->getClientSize();
        $type     = explode('/', $media->getClientMimeType())[0];
        $name     = date('Ymd') . Str::random(4);
        $ext      = strtolower($media->getClientOriginalExtension());
        $mainpath = $name . '.' . $ext;

        $folder = checkFolder();
        $media->move($folder['folder_path'], $mainpath);
        $newpath = $folder['path'] . '/' . $mainpath;
        $res     = $this->mediaSave($media, $type, $newpath, $size);

        return $res->id;
    }

    public function mediaSave($media, $type, $up, $size)
    {
        $req = new Request;
        $req->merge([
            'name'         => $media->getClientOriginalName(),
            'type'         => $type,
            'media_detail' => serialize([
                'ext'       => $media->getClientOriginalExtension(),
                'size'      => $size,
                'mime_type' => $media->getClientMimeType(),
            ]),
            'path'         => $up,
        ]);

        $query = \App\Media::saveMedia($req);

        return $query['data'];
    }

    public function extraSave($data, $req)
    {
        $alphabet  = range('A', 'H');
        $array     = [];
        $existData = [];
        foreach ($data->details as $det) {
            $existData[$det->id] = ['id' => $det->id, 'media_id' => $det->media_id];
        }

        foreach ($req->options as $key => $op) {
            if (isset($op['id'])) {
                $media = isset($existData[$op['id']]) ? $existData[$op['id']]['media_id'] : null;
            } else {
                $media = isset($op['media_id']) ? $op['media_id'] : null;
            }

            if (isset($op['media_id']) && $req->hasFile('options.' . $key . '.media_id')) {
                $media = $this->uploadFile($op['media_id']);
                // if($id != 0){
                //     $check = Iq::find($id);
                //     if($check && $check->media) {
                //         $path = $check->media->path;
                //         unlink(public_path($path));
                //         $check->media->delete();
                //     }
                // }
            }
            $array[] = [
                'desc'     => json_encode($op['text']),
                'alphabet' => $alphabet[$key],
                'media_id' => $media,
                'id'       => isset($op['id']) ? $op['id'] : null,
            ];
        }

        $data->details()->sync($array);

        return ['status' => 'success'];
    }
}
