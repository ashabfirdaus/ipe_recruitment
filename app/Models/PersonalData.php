<?php
namespace App\Models;

use App\Models\Master\Careers;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    protected $table    = 'personal_datas';
    protected $fillable = [
        'user_id',
        'position',
        'date',
        'full_name',
        'nickname',
        'place_of_birth',
        'date_of_birth',
        'age',
        'religion',
        'gender',
        'blood_group',
        'marital_status',
        'address_ktp',
        'postal_code_ktp',
        'home_ownership_status',
        'home_phone',
        'handphone1',
        'handphone2',
        'email1',
        'email2',
        'emergency_name',
        'emergency_address',
        'emergency_phone',
        'emergency_relationship',
        'salary_expectation',
        'career_expectation',
        'placement',
        'placement_reason',
        'overtime',
        'overtime_reason',
        'reference',
        'reference_reason',
        'other_position',
        'abroad',
        'needs_abroad',
        'transport',
        'transport_owner',
        'height',
        'weight',
        'bpjs',
        'has_opened',
        'lang',
        'nik_ktp',
        'status_employee',
        'register_date',
        'slug_position',
        'kabupaten_kota_ktp',
        'domisili',
        'linkedin',
        'ig_fb',
        'pendidikan_terakhir',
        'asal_sekolah_universitas',
        'jurusan_sekolah',
        'pendidikan_lainnya',
        'sumber_lowongan',
        'recent_work_experiance',
        'terakhir_bekerja',
        'preferensi_lokasi_kerja',
        'kapan_bisa_gabung',
        'ability_drive_car',
        'official_photo',
        'latest_cv',
        'willingness_follow_proccess',
        'interview_date',
        'interview_note',
        'interview_result',
        'status_test',
        'result_disc_test_path',
        'result_iq_test_path',
        'final_interview_date',
        'final_interview_user',
        'final_interview_note',
        'final_interview_result',
        'identity_code',
        'kecamatan_ktp',
        'rt_ktp',
        'kelurahan_desa_ktp',
        'domisili_sesuai_ktp',
        'final_process',
        'final_process_join_date',
        'final_process_reason',
        'status_cancel',
        'ijazah',
        'ready_contact',
        'career_id',
        'rhesus_blood_group',
        'ukuran_baju',
        'berkacamata',
        'berkacamata_kiri',
        'berkacamata_kanan',
        'kewarganegaraan',
        'npwp',
        'rw_ktp',
        'provinsi_ktp',
        'address_cur',
        'rt_cur',
        'rw_cur',
        'kelurahan_desa_cur',
        'kecamatan_cur',
        'kabupaten_kota_cur',
        'provinsi_cur',
        'postal_code_cur',
        'penghasilan_terakhir',
        'fasilitas_terakhir',
        'fasilitas_diharapkan',
        'penghasilan_lain',
        'komposisi_gaji',
        'tanggal_pernikahan',
        'kerja_pasangan',
        'alamat_kerja_pasangan',
        'telepon_kerja_pasangan',
        'bantuan_keluarga',
        'asal_bantuan_keluarga',
        'membantu_keluarga',
        'tujuan_membantu_keluarga',
        'no_rek_bca',
        'pemilik_rek_bca',
        'no_sim',
        'pengetahuan_scma',
        'kontribusi_anda',
        'riwayat_kesehatan',
        'keterangan_riwayat_kesehatan',
        'sim',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function family()
    {
        return $this->hasMany(Family::class)->where('type', '1');
    }

    public function family2()
    {
        return $this->hasMany(Family::class)->where('type', '2');
    }

    public function training()
    {
        return $this->hasMany(Training::class);
    }

    public function language()
    {
        return $this->hasMany(Language::class);
    }

    public function organization()
    {
        return $this->hasMany(Organization::class);
    }

    public function hobby()
    {
        return $this->hasMany(Hobby::class);
    }

    public function health()
    {
        return $this->hasMany(Health::class);
    }

    public function work()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function personality()
    {
        return $this->hasMany(Personality::class);
    }

    public function histories()
    {
        return $this->hasMany(StatusHistory::class, 'personal_data_id');
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public function career()
    {
        return $this->belongsTo(Careers::class);
    }
}
