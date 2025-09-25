<div class="container">
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <h4>DATA DIRI</h4>
                <label for="" class="text-bold">I. IDENTITAS DIRI</label>
                <table class="table table-bordered">
                    <tr>
                        <td width="200">Nama Lengkap</td><td width="50">:</td><td>{{$data->full_name}}</td>
                    </tr>
                    <tr>
                        <td width="200">Nama Panggilan</td><td width="50">:</td><td>{{$data->nickname}}</td>
                    </tr>
                    <tr>
                        <td width="200">Tempat & Tanggal Lahir</td><td width="50">:</td><td>{{$data->place_of_birth}} , {{date('d-m-Y', strtotime($data->date_of_birth))}}</td>
                    </tr>
                    <tr>
                        <td width="200">Usia</td>
                        <td width="50">:</td>
                        <td>{{$data->age}} Tahun</td>
                    </tr>
                    <tr>
                        <td width="200">Agama</td>
                        <td width="50">:</td>
                        <td>{{$data->religion}}</td>
                    </tr>
                    <tr>
                        <td width="200">Jenis Kelamin</td>
                        <td width="50">:</td>
                        <td>{{$data->gender}}</td>
                    </tr>
                    <tr>
                        <td width="200">Golongan Darah</td>
                        <td width="50">:</td>
                        <td>{{$data->blood_group}}</td>
                    </tr>
                    <tr>
                        <td width="200">Status Perkawinan</td>
                        <td width="50">:</td>
                        <td>{{$data->marital_status}}</td>
                    </tr>
                    <tr>
                        <td width="200">Alamat  Tinggal Sekarang Yang Bisa Dihubungi</td>
                        <td width="50">:</td>
                        <td>{{$data->address}}</td>
                    </tr>
                    <tr>
                        <td width="200">Kode Pos</td>
                        <td width="50">:</td>
                        <td>{{$data->postal_code}}</td>
                    </tr>
                    <tr>
                        <td width="200">Status Kepemilikan</td>
                        <td width="50">:</td>
                        <td>{{$data->home_ownership_status}}</td>
                    </tr>
                    <tr>
                        <td width="200">Nomor Telepon Aktif Rumah</td>
                        <td width="50">:</td>
                        <td>{{$data->home_phone}}</td>
                    </tr>
                    <tr>
                        <td width="200">Nomor Telepon Aktif Handphone 1</td>
                        <td width="50">:</td>
                        <td>{{$data->handphone1}}</td>
                    </tr>
                    <tr>
                        <td width="200">Nomor Telepon Aktif handphone 2</td>
                        <td width="50">:</td>
                        <td>{{$data->handphone2}}</td>
                    </tr>
                    <tr>
                        <td width="200">Alamat Email Aktif 1</td>
                        <td width="50">:</td>
                        <td>{{$data->email1}}</td>
                    </tr>
                    <tr>
                        <td width="200">Alamat Email Aktif 2</td>
                        <td width="50">:</td>
                        <td>{{$data->email2}}</td>
                    </tr>
                    <tr>
                        <td width="200">Jika Dalam Keadan Darurat Bisa Menghubungi Nama</td>
                        <td width="50">:</td>
                        <td>{{$data->emergency_name}}</td>
                    </tr>
                    <tr>
                        <td width="200">Jika Dalam Keadan Darurat Bisa Menghubungi Alamat</td>
                        <td width="50">:</td>
                        <td>{{$data->emergency_address}}</td>
                    </tr>
                    <tr>
                        <td width="200">Jika Dalam Keadan Darurat Bisa Menghubungi Telepon</td>
                        <td width="50">:</td>
                        <td>{{$data->emergency_phone}}</td>
                    </tr>
                    <tr>
                        <td width="200">Jika Dalam Keadan Darurat Bisa Menghubungi Hubungan</td>
                        <td width="50">:</td>
                        <td>{{$data->relationship}}</td>
                    </tr>
                </table>

                <hr>
                <label for="" class="text-bold">II. PENDIDIKAN</label>
                <table class="table table-bordered">
                    <tr>
                        <th >Tingkat Pendidikan</th>
                        <th >Nama Sekolah</th>
                        <th>Tahun</th>
                    </tr>
                    @foreach($data->education as $ke => $edu)
                    <tr>
                        <td>{{$edu->level_education}}</td>
                        <td>
                            @if($ke == 0)
                            {{$edu->school_name}}
                            @else
                            Universitas : {{$edu->school_name}} <br>
                            Jurusan : {{$edu->major}} <br>
                            IPK : {{$edu->ipk}}
                            @endif
                        </td>
                        <td>{{$edu->start_year_education}} until {{$edu->end_year_education}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">III. LINGKUNGAN KELUARGA</label>
                <table class="table table-bordered">
                    <tr>
                        <th >Hubungan</th>
                        <th >Nama</th>
                        <th>P/L</th>
                        <th>Tempat & Tanggal Lahir</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                    </tr>
                    @foreach($data->family as $fam)
                    <tr>
                        <td>{{$fam->family_relationship}}</td>
                        <td>{{$fam->name}}</td>
                        <td>{{$fam->gender}}</td>
                        <td>{{$fam->place_of_birth}}, {{$fam->date_of_birth}}</td>
                        <td>{{$fam->education}}</td>
                        <td>{{$fam->profession}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">IV. KURSUS / TRAINING</label>
                <table class="table table-bordered">
                    <tr>
                        <th >Kursus / Training</th>
                        <th >Tahun</th>
                        <th>Diselenggarakan</th>
                        <th>Keterangan</th>
                    </tr>
                    @foreach($data->training as $tra)
                    <tr>
                        <td>{{$tra->training_name}}</td>
                        <td>{{$tra->start_year_training}} until {{$tra->end_year_training}}</td>
                        <td>{{$tra->location}}</td>
                        <td>{{$tra->desc}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">V. KEMAMPUAN BAHASA ASING</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Bahasa</th>
                        <th>Berbicara</th>
                        <th>Menulis</th>
                    </tr>
                    @foreach($data->language as $lang)
                    <tr>
                        <td>{{$lang->language_name}}</td>
                        <td>{{$lang->speak}}</td>
                        <td>{{$lang->write}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">VI. PENGALAMAN BERORGANISASI (SOSIAL, PUBLIK, KEAGAMAAN, DLL)</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Organisasi</th>
                        <th>Jenis Organisasi</th>
                        <th>Tahun</th>
                        <th>Jabatan</th>
                    </tr>
                    @foreach($data->organization as $org)
                    <tr>
                        <td>{{$org->organization_name}}</td>
                        <td>{{$org->organization_type}}</td>
                        <td>{{$org->year}}</td>
                        <td>{{$org->position}}</td>
                    </tr>
                    @endforeach
                </table>
                
                <hr>
                <label for="" class="text-bold">VII. HOBI DAN PRESTASI</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Hobi</th>
                        <th>Prestasi</th>
                    </tr>
                    @foreach($data->hobby as $hob)
                    <tr>
                        <td>{{$hob->type == 'hobby' ? $hob->value : ''}}</td>
                        <td>{{$hob->type == 'achievement' ? $hob->value : ''}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">VIII. CATATAN KESEHATAN</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Penyakit Yang Diderita</th>
                        <th>Tahun</th>
                        <th>Dirawat di</th>
                    </tr>
                    @foreach($data->health as $he)
                    <tr>
                        <td>{{$he->disease}}</td>
                        <td>{{$he->year}}</td>
                        <td>{{$he->treated}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">IX. PENGALAMAN KERJA</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Perusahaan</th>
                        <th>Masa Kerja</th>
                        <th>Jabatan</th>
                        <th>Gaji Terakhir</th>
                        <th>Alasan Berhenti</th>
                    </tr>
                    @foreach($data->work as $work)
                    <tr>
                        <td>{{$work->company_name}}</td>
                        <td>{{$work->start_year_work}} until {{$work->end_year_work}}</td>
                        <td>{{$work->position}}</td>
                        <td>{{$work->last_salary}}</td>
                        <td>{{$work->reason_stop}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">I. IDENTITAS DIRI</label>
                <table class="table table-bordered">
                    <tr>
                        <td width="200">Gaji yang diharapkan</td>
                        <td width="50">:</td>
                        <td>{{$data->salary_expectation}}</td>
                    </tr>
                    <tr>
                        <td width="200">Karier yang diharapkan</td>
                        <td width="50">:</td>
                        <td>{{$data->career_expectation}}</td>
                    </tr>
                    <tr>
                        <td width="200">Ditempatkan diluar wilayah Sidoarjo atau Surabaya</td>
                        <td width="50">:</td>
                        <td>{{$data->placement}} karena {{$data->placement_reason}}</td>
                    </tr>
                    <tr>
                        <td width="200">Bekerja lembur atau shift</td>
                        <td width="50">:</td>
                        <td>{{$data->overtime}} karena {{$data->overtime_reason}}</td>
                    </tr>
                    <tr>
                        <td width="200">Siapakah yang mereferensikan anda</td>
                        <td width="50">:</td>
                        <td>{{$data->reference}} karena {{$data->reference_reason}}</td>
                    </tr>
                    <tr>
                        <td width="200">Jika ditempatkan di posisi yang lain, posisi apa yang anda inginkan</td>
                        <td width="50">:</td>
                        <td>{{$data->other_position}}</td>
                    </tr>
                </table>

                <hr>
                <label for="" class="text-bold">XI. TENTANG DIRI ANDA</label>
                <table class="table table-bordered">
                    <tr>
                        <th>Sebutkan Tiga Kebaikan Anda</th>
                        <th>Sebutkan Tiga Kelemahan Anda</th>
                    </tr>
                    @foreach($data->personality as $person)
                    <tr>
                        <td>{{$person->type == 'superiority' ? $person->value : ''}}</td>
                        <td>{{$person->type == 'weakness' ? $person->value : ''}}</td>
                    </tr>
                    @endforeach
                </table>

                <hr>
                <label for="" class="text-bold">XI. LAIN - LAIN</label>
                <table class="table table-bordered">
                    <tr>
                        <td width="200">Pergi keluar negeri</td>
                        <td width="50">:</td>
                        <td>{{$data->abroad}} untuk keperluan {{$data->needs_abroad}}</td>
                    </tr>
                    <tr>
                        <td width="200">Kendaraan</td>
                        <td width="50">:</td>
                        <td>{{$data->transport}}</td>
                    </tr>
                    <tr>
                        <td width="200">Kepemilikan kendaraan</td>
                        <td width="50">:</td>
                        <td>{{$data->transport_owner}}</td>
                    </tr>
                    <tr>
                        <td width="200">Tinggi badan</td>
                        <td width="50">:</td>
                        <td>{{$data->height}}</td>
                    </tr>
                    <tr>
                        <td width="200">Berat badan</td>
                        <td width="50">:</td>
                        <td>{{$data->weight}}</td>
                    </tr>
                    <tr>
                        <td width="200">Memiliki kartu BPJS Ketenagakerjaan</td>
                        <td width="50">:</td>
                        <td>{{$data->bpjs}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
</div>