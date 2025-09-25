@push('styles')
    <style>
        label>input[type="radio"] {
            margin-right: 10px;
            margin-left: 5px;
        }

        th,
        td {
            text-align: center;
        }

        .container {
            margin-bottom: 20px;
        }

        .required {
            color: red;
        }

        .form-control-custom {
            height: 36px;
            padding: 7px 12px;
            font-size: 13px;
            line-height: 1.5384616;
            color: #333;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin-left: 10px;
        }

        .row>label {
            margin-top: 8px;
        }

        .top-10 {
            margin-top: 10px;
        }

        label.has-error {
            background: #fb434a;
            padding: 5px 8px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            position: absolute;
            right: 0;
            bottom: 37px;
            margin-bottom: 8px;
            max-width: 230px;
            font-size: 80%;
            z-index: 2;
            color: white;
        }

        label.has-error:after {
            width: 0px;
            height: 0px;
            content: '';
            display: block;
            border-style: solid;
            border-width: 5px 5px 0;
            border-color: #fb434a transparent transparent;
            position: absolute;
            right: 20px;
            bottom: -4px;
            margin-left: -5px;
        }

        .form-group.error {
            color: #fb434a;
        }

        .error input,
        .error textarea {
            border-color: #fb434a;
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            padding: 5px;
        }

        .table>tbody>tr>td>.form-group {
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        @media only screen and (max-width: 769px) {
            .content {
                padding-left: 0px;
                padding-right: 0px;
            }
        }
    </style>
@endpush

<div class="container">
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <h3>{{ strtoupper(getMultiLang('title_info_form')) }}</h3>
                <div>
                    @foreach ($groupData as $group)
                        <label class="label label-default tag-label" style="font-size:14px;">{{ $group }}</label>
                    @endforeach
                </div>
                <div style="font-size:15px;text-align:center;margin:20px;border-bottom:1px solid #b47e18;">
                    <label>{{ getMultiLang('applied_position') }}</label> :
                    <b>{{ val_exist_with_old($personal, 'position') }}</b>
                </div>
                @include('guest.pages.personaldata.part1', ['errors' => $errors, 'personal' => $personal])
                @include('guest.pages.personaldata.part2', ['errors' => $errors, 'personal' => $personal])
                @include('guest.pages.personaldata.part3', ['errors' => $errors, 'personal' => $personal])
                @include('guest.pages.personaldata.part4', ['errors' => $errors, 'personal' => $personal])
                @include('guest.pages.personaldata.part5', ['errors' => $errors, 'personal' => $personal])
                @include('guest.pages.personaldata.part6', ['errors' => $errors, 'personal' => $personal])
                <form action="{{ route('guest-confirmation-submit', id_exist($personal)) }}" method="post"
                    class="action-post">
                    <div class="text-bold" style="margin-bottom:20px;">
                        <p>{{ getMultiLangContent('persetujuan') }}</p>
                    </div>
                    <div class="alert alert-info">
                        {{ getMultiLang('recheck') }}
                    </div>
                    <div class="pull-right top-10">
                        <button type="button" class="btn btn-default prev" data-prev="5">
                            <i class="icon-arrow-left8 position-left"></i>Sebelumnya
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Kirim Form<i class="icon-floppy-disk position-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if (!request()->ajax())
    @push('scripts')
    @endif
    <script>
        let indexGroup = '{{ request()->part ?? 0 }}';

        $('input').prop('autocomplete', 'off')
        $('.next').hide()
        $('body').on('input', '.form-control-custom', function() {
            let input = $(this).val()
            $(this).prev().val(input)
        })
        $(':input').on('propertychange input', function() {
            let input = $(this).val()
            $(this).val(input.toUpperCase())
        });

        $('body').on('input', 'input,textarea', function() {
            let input = $(this).val()
            $(this).val(input.toUpperCase())
        })

        $('form').hide()
        $($('form')[indexGroup]).show()
        $($('.tag-label')[indexGroup]).addClass('label-info').removeClass('label-default')

        $('.next').click(function() {
            let part = $(this).data('next')
            indexGroup = part
            $('.tag-label').removeClass('label-info').addClass('label-default')
            $('form').hide();
            $($('form')[part]).show()
            $($('.tag-label')[part]).addClass('label-info').removeClass('label-default')
        })

        $('.prev').click(function() {
            let part = $(this).data('prev')
            indexGroup = part
            $('.tag-label').removeClass('label-info').addClass('label-default')
            $('form').hide();
            $($('form')[part]).show()
            $($('.tag-label')[part]).addClass('label-info').removeClass('label-default')
        })

        let dataValidate = {
            0: {
                full_name: 'required',
                nickname: 'required',
                place_of_birth: 'required',
                date_of_birth: 'required',
                religion: {
                    required: function(element) {
                        return $("[name='custom_religion']").val() == "";
                    }
                },
                gender: 'required',
                marital_status: 'required',
                nik_ktp: 'required',
                address_ktp: 'required',
                kabupaten_kota_ktp: 'required',
                home_ownership_status: {
                    required: function(element) {
                        return $('[name="custom_home_ownership_status"]').val() == '';
                    }
                },
                handphone1: 'required',
                email1: 'required',
                emergency_name: 'required',
                emergency_address: 'required',
                emergency_phone: 'required',
                emergency_relationship: {
                    required: function(element) {
                        return $('[name="custom_emergency_relationship"]').val() == '';
                    }
                },
                rt_ktp: 'required',
                kelurahan_desa_ktp: 'required',
                kecamatan_ktp: 'required',
                latest_cv_temp: {
                    required: function(element) {
                        return $('[name="latest_cv"]').val() == '';
                    },
                    extension: 'pdf',
                    filesize: 1
                },
                latest_cv: 'required',
                letter_of_reference_temp: {
                    extension: 'pdf',
                    filesize: 1
                },
                official_photo: 'required',
                official_photo_temp: {
                    required: function(element) {
                        return $('[name="official_photo"]').val() == '';
                    },
                    extension: 'jpeg|jpg|png',
                    filesize: 1
                },
                berkacamata: 'required',
                berkacamata_kiri: {
                    required: function(element) {
                        return $('input[name="berkacamata"]:checked').val() == 'YA';
                    }
                },
                berkacamata_kanan: {
                    required: function(element) {
                        return $('input[name="berkacamata"]:checked').val() == 'YA';
                    }
                },
                height: 'required',
                weight: 'required',
                ukuran_baju: 'required',
                kewarganegaraan: 'required',
                // sim: 'required',
                no_sim: {
                    required: function(element) {
                        return $('[name="sim"]').val().trim() != '';
                    }
                },
                transport: 'required',
                postal_code_ktp: 'required',
                rw_ktp: 'required',
                provinsi_ktp: 'required',
                address_cur: 'required',
                rt_cur: 'required',
                rw_cur: 'required',
                kelurahan_desa_cur: 'required',
                kecamatan_cur: 'required',
                kabupaten_kota_cur: 'required',
                provinsi_cur: 'required',
                hobby_0: 'required',
                achievement_0: 'required',
            },
            1: {
                school_name_0: 'required',
                kota_0: 'required',
                major_0: 'required',
                ipk_0: 'required',
                start_year_education_0: 'required',
                end_year_education_0: 'required',
                school_name_1: 'required',
                kota_1: 'required',
                major_1: 'required',
                ipk_1: 'required',
                start_year_education_1: 'required',
                end_year_education_1: 'required',
                school_name_2: 'required',
                kota_2: 'required',
                major_2: 'required',
                ipk_2: 'required',
                start_year_education_2: 'required',
                end_year_education_2: 'required',
                language_name_0: 'required',
                listen_0: 'required',
                speak_0: 'required',
                read_0: 'required',
                write_0: 'required'
            },
            2: {
                salary_expectation: 'required',
                fasilitas_diharapkan: 'required',
            },
            3: {
                tanggal_pernikahan: {
                    required: function(element) {
                        return $('[name="name_5"]').val() == '';
                    }
                },
                name_0: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() != ''
                    }
                },
                gender_0: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() != ''
                    }
                },
                place_of_birth_0: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() != ''
                    }
                },
                date_of_birth_0: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() != ''
                    }
                },
                education_0: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() != ''
                    }
                },
                profession_0: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() != ''
                    }
                },
                name_5: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                gender_5: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                place_of_birth_5: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                date_of_birth_5: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                education_5: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                profession_5: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                name_6: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                gender_6: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                place_of_birth_6: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                date_of_birth_6: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                education_6: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                profession_6: {
                    required: function(element) {
                        return $('[name="tanggal_pernikahan"]').val() == ''
                    }
                },
                bantuan_keluarga: 'required',
                membantu_keluarga: 'required',
                asal_bantuan_keluarga: {
                    required: function(element) {
                        return $('input[name="bantuan_keluarga"]:checked').val() == 'YA';
                    }
                },
                tujuan_membantu_keluarga: {
                    required: function(element) {
                        return $('input[name="membantu_keluarga"]:checked').val() == 'YA';
                    }
                }
            },
            4: {},
            5: {
                pengetahuan_scma: 'required',
                kontribusi_anda: 'required',
                superiority_0: 'required',
                superiority_1: 'required',
                superiority_2: 'required',
                superiority_3: 'required',
                weakness_0: 'required',
                weakness_1: 'required',
                weakness_2: 'required',
                weakness_3: 'required',
                'preferensi_lokasi_kerja[]': 'required',
                placement: 'required',
                overtime: 'required',
                other_position: 'required',
                kapan_bisa_gabung: 'required',
                riwayat_kesehatan: 'required',
                ijazah: 'required',
                keterangan_riwayat_pekerjaan: {
                    required: function(element) {
                        return $('input[name="riwayat_kesehatan"]:checked').val() == 'YA'
                    }
                }
            }
        }

        $.extend($.validator.messages, {
            required: "Tidak boleh kosong",
            email: "Pastikan format email sudah benar",
            number: "Pastikan hanya angka",
        });

        $.validator.addMethod(
            "extension",
            function(value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            },
            "File tidak diizinkan"
        );

        $.validator.addMethod(
            'filesize',
            function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param * 1000000)
            },
            'Ukuran file harus kurang dari {0} MB'
        );

        $('form').each(function(i, v) {
            let routePost = $(this).prop('action')
            let self = $(this)
            $(this).validate({
                rules: dataValidate[i],
                scrollToError: {
                    offset: -100,
                    duration: 500
                },
                errorClass: 'has-error',
                highlight: function(element, errorClass, validClass) {
                    $(element).parents("div.form-group").addClass('error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parents(".error").removeClass('error');
                },
                submitHandler: function(form, e) {
                    e.preventDefault()
                    sendRegisterData(routePost, self)
                    return false;
                }
            });
        })

        function sendRegisterData(route, form) {
            $('#cover-spin').show()
            $.ajax({
                url: route,
                type: 'post',
                data: form.serialize(),
                success: function(res) {
                    if (typeof res.redirect != 'undefined') {
                        window.location = res.redirect
                    } else {
                        form.find('.next').click()
                    }

                    toastr.success(res.message)
                    $('#cover-spin').hide()
                },
                error: function(error) {
                    toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error
                        .statusText)
                    if (error.responseJSON.attribut !== undefined) {
                        showError(error.responseJSON.attribut, form)
                    }

                    $('#cover-spin').hide()
                }
            })
        }

        $('.form-control-custom').each(function(i, v) {
            if ($(this).val() != '') {
                $(this).prev().val($(this).val()).prop('checked', true)
            }
        })

        $('.form-control-custom').change(function() {
            let parent = $(this).prev()
            parent.prop('checked', true)
        })

        $('.form-control-custom').parents('.form-group').find('[type="radio"]').change(function() {
            $(this).parents('.form-group').find('[type="text"]').val('')
        })

        function showError(errors, form) {
            if (errors) {
                let input = form.find('input,textarea,select')
                for (let i = 0; i < input.length; i++) {
                    let tag = $($(input).get(i));
                    let name = tag.prop('name');
                    if (errors[name]) {
                        tag.parents('.form-group').addClass('has-error')
                    }
                }
            }
        }

        $('.upload_file').change(function() {
            if ($(this).val()) {
                let oFReader = new FileReader();
                let file = $(this)[0].files[0];
                let nextInput = $(this).next()
                let self = $(this)
                let nameInput = self.prop('name')
                if (file.type.match(/image.*/)) {
                    let reader = new FileReader();
                    reader.onload = function(readerEvent) {
                        if (nameInput == 'official_photo_temp') {
                            let image = new Image();
                            image.onload = function(imageEvent) {
                                let canvas = document.createElement('canvas'),
                                    max_size = 1000,
                                    width = image.width,
                                    height = image.height;
                                if (width > height) {
                                    if (width > max_size) {
                                        height *= max_size / width;
                                        width = max_size;
                                    }
                                } else {
                                    if (height > max_size) {
                                        width *= max_size / height;
                                        height = max_size;
                                    }
                                }
                                canvas.width = width;
                                canvas.height = height;
                                canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                                let dataUrl = canvas.toDataURL('image/jpeg');
                                $(nextInput).val(dataUrl)
                                document.getElementById("uploadPreview1").src = dataUrl;
                            }
                            image.src = readerEvent.target.result;
                        }
                    }
                    reader.readAsDataURL(file);
                } else {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function(readerEvent) {
                        if (nameInput == 'latest_cv_temp') {
                            self.parent().find('a').remove()
                            setTimeout(() => {
                                self.before('<a href=' + readerEvent.currentTarget.result +
                                    ' download="File CV" id="uploadCv">File CV <i class="icon-file-download"></i></a>'
                                )
                            }, 100);
                        } else if (nameInput == 'letter_of_reference_temp') {
                            self.parent().find('a').remove()
                            self.before('<a href=' + readerEvent.currentTarget.result +
                                ' download="File Referensi" id="uploadRef">File Referensi <i class="icon-file-download"></i></a>'
                            )
                        }

                        $(nextInput).val(readerEvent.currentTarget.result)
                    };
                }
            }
        })

        cekRiwayatKesehatan()
        $('[name="riwayat_kesehatan"]').change(function() {
            cekRiwayatKesehatan()
        })

        function cekRiwayatKesehatan() {
            if ($('[name="riwayat_kesehatan"]:checked').val() == 'YA') {
                $('[name="keterangan_riwayat_pekerjaan"]').prop('readonly', false)
            } else {
                $('[name="keterangan_riwayat_pekerjaan"]').prop('readonly', true).val('')
            }
        }

        cekDapatBantuan()
        $('[name="bantuan_keluarga"]').change(function() {
            cekDapatBantuan()
        })

        function cekDapatBantuan() {
            if ($('[name="bantuan_keluarga"]:checked').val() == 'YA') {
                $('[name="asal_bantuan_keluarga"]').prop('readonly', false)
            } else {
                $('[name="asal_bantuan_keluarga"]').prop('readonly', true).val('')
            }
        }

        cekBeriBantuan()
        $('[name="membantu_keluarga"]').change(function() {
            cekBeriBantuan()
        })

        function cekBeriBantuan() {
            if ($('[name="membantu_keluarga"]:checked').val() == 'YA') {
                $('[name="tujuan_membantu_keluarga"]').prop('readonly', false)
            } else {
                $('[name="tujuan_membantu_keluarga"]').prop('readonly', true).val('')
            }
        }
    </script>
    @if (!request()->ajax())
    @endpush
@endif
