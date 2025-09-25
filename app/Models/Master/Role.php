<?php
namespace App\Models\Master;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name', 'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    public function rulesLogin()
    {
        return $this->hasMany(Rule::class)->select(['menu', 'read', 'create', 'edit', 'delete', 'export', 'import', 'other', 'view', 'print']);
    }

    public function saveDetail($array)
    {
        $newAr = [];
        $menus = [];
        try {
            foreach ($array as $ar) {
                if ($ar['id'] == null) {
                    unset($ar['id']);
                    $ar['role_id'] = $this->id;
                    $newAr[]       = $ar;
                } else {
                    $menus[$ar['menu']] = $ar;
                }
            }

            DB::table('rules')->where('role_id', $this->id)->whereNotIn('menu', array_keys($menus))->delete();
            $find = Rule::where('role_id', $this->id)->get();
            foreach ($find as $f) {
                if (isset($menus[$f->menu])) {
                    $a = $menus[$f->menu];
                    unset($a['id']);
                    $f->update($a);
                }
            }

            if (count($newAr) > 0) {
                DB::table('rules')->insert($newAr);
            }

            return ['status' => 'success'];
        } catch (\Exception $th) {
            Log::error($th);
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
