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
        z-index: 1;
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
</style>
<div class="container">
    <div class="content" style="padding-top:0px;">
        <form action="{{ route('save-register') }}" method="post" class="action-post" enctype="multipart/form-data"
            id='formRegister'>
            <div class="panel panel-flat">
                <div class="panel-body">
                    <h3>{{ strtoupper(getMultiLang('title_register')) }}</h3>
                    <input type="hidden" name="slug_position" value="{{ $slug_position }}" autocomplete="off">
                    <input type="hidden" name="lang" value="id" autocomplete="off">
                    <hr>
                    @if ($errors->any())
                        <div class="alert alert-danger">Complete the data correctly<br>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{ getMultiLang('applied_position') }} <span class="required">*</span></label>
                            <div class="form-group {{ $errors->first('position') ? 'has-error' : '' }}">
                                <input type="text" name="position" class="form-control"
                                    value="{{ strtoupper($position) }}" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-md-3 pull-right">
                            <label>{{ getMultiLang('date') }} <span class="required">*</span></label>
                            <div class="form-group {{ $errors->first('date') ? 'has-error' : '' }}">
                                <input type="date" name="register_date" value="{{ date('Y-m-d') }}"
                                    class="form-control" readonly autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <label class="text-bold">{{ strtoupper(getMultiLang('personal_identity')) }}</label>
                    <div class="row">
                        <label class="col-md-3">{{ getMultiLang('email') }} <span class="required">*</span></label>
                        <div class="col-md-3 form-group {{ $errors->first('email1') ? 'has-error' : '' }}">
                            <input type="text" name="email1" class="form-control" value="{{ old('email1') }}"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">No. WhatsApp <span class="required">*</span></label>
                        <div class="col-md-3 form-group {{ $errors->first('handphone1') ? 'has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon" id="sizing-addon2">+62</span>
                                <input type="text" name="handphone1" class="form-control"
                                    value="{{ old('handphone1') }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">{{ getMultiLang('full_name') }} <span class="required">*</span></label>
                        <div class="col-md-5 form-group {{ $errors->first('full_name') ? 'has-error' : '' }}">
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">{{ getMultiLang('gender') }} <span class="required">*</span></label>
                        <div class="col-md-9 form-group {{ $errors->first('gender') ? 'has-error' : '' }}">
                            @foreach ($genders as $gender)
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="{{ $gender }}" autocomplete="off"
                                        {{ old('gender') == $gender ? 'checked' : '' }}>
                                    {{ $gender }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">{{ getMultiLang('nik_ktp') }} <span class="required">*</span></label>
                        <div class="col-md-5 form-group {{ $errors->first('nik_ktp') ? 'has-error' : '' }}">
                            <input type="text" name="nik_ktp" class="form-control" value="{{ old('nik_ktp') }}"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">{{ getMultiLang('place_n_date') }} <span
                                class="required">*</span></label>
                        <div class="col-md-3 form-group {{ $errors->first('place_of_birth') ? 'has-error' : '' }}">
                            <input type="text" name="place_of_birth" class="form-control"
                                value="{{ old('place_of_birth') }}" autocomplete="off">
                        </div>
                        <div class="col-md-3 form-group {{ $errors->first('date_of_birth') ? 'has-error' : '' }}">
                            <input type="date" name="date_of_birth" class="form-control"
                                value="{{ old('date_of_birth') }}" placeholder="dd/mm/yyy" autocomplete="off">
                        </div>
                        <label class="col-md-1">{{ getMultiLang('age') }} </label>
                        <div class="col-md-2 form-group {{ $errors->first('age') ? 'has-error' : '' }}">
                            <input type="number" name="age" class="form-control" value="{{ old('age') }}"
                                readonly autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">
                            {{ getMultiLang('official_photo') }} <span class="required">*</span>
                            <br>
                            <span style="font-size: smaller;">(Max Size: 1MB, Format: JPEG, JPG, PNG)</span>
                        </label>
                        <div
                            class="col-md-4 form-group {{ $errors->first('official_photo_temp') ? 'has-error' : '' }}">
                            <img alt="" height="100" id="uploadPreview1"
                                style="margin-top:10px;margin-bottom:10px;" src="{{ asset('img/placeholder.jpg') }}">
                            <input type="file" name="official_photo_temp" class="form-control upload_file"
                                value="{{ old('official_photo_temp') }}" autocomplete="off"
                                id="official_photo_temp">
                            <input type="hidden" name="official_photo" value="{{ old('official_photo') }}">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3">
                            {{ getMultiLang('latest_cv') }} <span class="required">*</span>
                            <br>
                            <span style="font-size: smaller;">(Max Size: 1MB, Format: PDF)</span>
                        </label>
                        <div class="col-md-4 form-group {{ $errors->first('latest_cv_temp') ? 'has-error' : '' }}">
                            <input type="file" name="latest_cv_temp" class="form-control upload_file"
                                value="{{ old('latest_cv_temp') }}" autocomplete="off" id="latest_cv_temp">
                            <input type="hidden" name="latest_cv" value="{{ old('latest_cv') }}">
                        </div>
                    </div>
                    <div class="text-bold" style="margin-bottom:20px;">
                        <p>{{ getMultiLang('approval') }}</p>
                    </div>
                    <div class="alert alert-info">
                        {{ getMultiLang('recheck') }}
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary" id="btnRegister">
                            <i class="icon-check posision-left"></i>
                            {{ strtoupper(getMultiLang('btn_save_register')) }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        window.dataPelamar = null;
        $(':text,textarea').on('propertychange input', function() {
            let input = $(this).val()
            $(this).val(input.toUpperCase())
        });

        $("#formRegister").validate({
            rules: {
                position: "required",
                register_date: "required",
                email1: {
                    required: true,
                    email: true
                },
                handphone1: {
                    required: true,
                    number: true,
                    phone_regex: /^[1-9]\d*/
                },
                full_name: "required",
                gender: "required",
                nik_ktp: {
                    required: true,
                    number: true,
                    exactlength: 16
                },
                place_of_birth: "required",
                date_of_birth: "required",
                age: "required",
                official_photo_temp: {
                    required: function(element) {
                        return $('[name="official_photo"]').val() == '';
                    },
                    extension: 'jpeg|jpg|png',
                    filesize: 1
                },
                official_photo: 'required',
                latest_cv: 'required',
                latest_cv_temp: {
                    required: function(element) {
                        return $('[name="latest_cv"]').val() == '';
                    },
                    extension: 'pdf',
                    filesize: 1
                },
            },
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
                // $('[name="official_photo_temp"]').val('')
                sendRegisterData()
                return false;
            }
        });

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

        $.validator.addMethod(
            "phone_regex",
            function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            },
            'Tidak boleh berawalan 0 dan +62'
        );

        $.validator.addMethod(
            "exactlength",
            function(value, element, param) {
                return this.optional(element) || value.length == param;
            },
            "Silakan masukkan tepat {0} karakter"
        );

        function diff_years(dt2, dt1) {
            var diff = (dt2.getTime() - dt1.getTime()) / 1000;
            diff /= (60 * 60 * 24);
            return Math.abs(Math.round(diff / 365.25));
        }

        $('[name="date_of_birth"]').change(function() {
            var dt1 = new Date();
            var dt2 = new Date($(this).val());
            let age = diff_years(dt2, dt1);
            $('[name="age"]').val(age);
        });

        $('[name="official_photo_temp"]').change(function() {
            if ($(this).val()) {
                let oFReader = new FileReader();
                let file = $(this)[0].files[0];
                let nextInput = $(this).next()
                let self = $(this)
                let nameInput = self.prop('name')

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
                            $('[name="official_photo"]').val(dataUrl)
                            document.getElementById("uploadPreview1").src = dataUrl;
                        }
                        image.src = readerEvent.target.result;
                    }
                }
                reader.readAsDataURL(file);
            }
        })

        $('[name="latest_cv_temp"]').change(function() {
            if ($(this).val()) {
                let oFReader = new FileReader();
                let file = $(this)[0].files[0];
                let nextInput = $(this).next()
                let self = $(this)
                let nameInput = self.prop('name')

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

                    $('[name="latest_cv"]').val(readerEvent.currentTarget.result)
                };

            }
        })

        function sendRegisterData() {
            $('#cover-spin').show()
            let form = $('form')
            let url = form.prop('action')
            $.ajax({
                url: url,
                type: 'post',
                data: form.serialize(),
                success: function(res) {
                    if (res.redirect) {
                        window.location = res.redirect
                    }

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
    </script>
@endpush
