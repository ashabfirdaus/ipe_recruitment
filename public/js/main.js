$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

let mainTitle = $('#target-html')
$('title').text(mainTitle.find('.page-title').text() + ' | ' + siteName)

$('body').on('click', '.me', function (e) {
	e.preventDefault();
	if ($(this)[0].parentNode.nodeName == "LI") {
		$(this).attr('disabled', true).append(' <i class="icon-spinner2 spinner pull-right"></i>')
	} else {
		$(this).attr('disabled', true).append(' <i class="icon-spinner2 spinner"></i>')
	}

	loadPage($(this).prop('href'), $(this))
	$('body').removeClass('sidebar-mobile-main')
	$('[data-target="#navbar-mobile"]').addClass('collapsed')
	$('#navbar-mobile').removeClass('in').css('height', '')
})

$('body').on('click', '.me-change-validation', function (e) {
	e.preventDefault()
	$(this).parents('.modal').modal('hide')
	let url = $(this).prop('href')
	Swal.fire({
		title: 'Apakah Kamu Yakin?',
		text: "Kamu akan melanjutkan proses!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Tidak',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			$('#cover-spin').show()
			$.ajax({
				url: url,
				success: function (res) {
					if (res.status == 'success') {
						if (res.redirect != '') loadPage(res.redirect)
						toastr.success(res.message)
					}
				},
				error: function (error) {
					toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText, 'Code ' + error.status)
					$('#cover-spin').hide()
				}
			})
		}
	})
})

$('body').on('click', '.me-change-validation-text', function (e) {
	e.preventDefault()
	$(this).parents('.modal').modal('hide')
	let url = $(this).prop('href')
	$('#modal-void').modal()
	$('.me-void').attr('data-href', url)
})

$('body').on('click', '.me-void', function (e) {
	e.preventDefault()
	let url = $(this).data('href')
	$('#modal-void').modal('hide')
	$.ajax({
		url: url + '&approval_desc=' + $('#modal-void').find('[name="approval_desc"]').val(),
		success: function (res) {
			if (res.status == 'success') {
				if (res.redirect != '') loadPage(res.redirect)
				toastr.success(res.message)
			}
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText, 'Code ' + error.status)
		}
	})
})

$('body').on('click', '.me-change-refund', function (e) {
	e.preventDefault()
	$('#modal-refund').modal('show')
	let url = $(this).prop('href')
	$('.action-refund').prop('href', url)
})

$('body').on('click', '.action-refund', function (e) {
	e.preventDefault()
	$('#modal-refund').modal('hide')
	let url = $(this).prop('href')
	$.ajax({
		url: url + '?duplicate=' + $('[name="is_duplicate"]').val(),
		success: function (res) {
			if (res.status == 'success') {
				if (res.redirect != '') {
					loadPage(res.redirect)
				}

				toastr.success(res.message)
			}
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText, 'Code ' + error.status)
		}
	})
})

$('body').on('click', '.me-change-rewash', function (e) {
	e.preventDefault()
	let url = $(this).prop('href')
	$.ajax({
		url: url,
		type: 'get',
		success: function (res) {
			let target = $('#modal-rewash')
			target.find('#mr_transaction_code').text(res.data.transaction_code)
			target.find('#mr_user').text(res.data.user)
			let html = '';
			for (let i = 0; i < res.data.details.length; i++) {
				let detail = res.data.details[i]
				html += '<tr>'
				html += '<td style="width:40px;"><input type="checkbox" name="item_checked[]" value="' + res.data.details[i]['item_id'] + '"></td>'
				html += '<td>' + res.data.details[i]['item_name'] + '</td>'
				html += '</tr>'
			}
			target.find('#target_mr').html(html)
			target.find('form').prop('action', res.data.url)
			target.find('.btn-action-rewash').prop('disabled', true)
			$('#modal-rewash').modal('show')
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText, 'Code ' + error.status)
		}
	})
})

$('body').on('click', '[name="item_checked[]"]', function () {
	let self = $(this)
	let countChecked = 0
	if (self.is(':checked')) {
		$('[name="item_checked[]"]').each(function (index, list) {
			if ($(list).is(':checked')) countChecked++;
		})
	}

	if (countChecked == 0) {
		$('.btn-action-rewash').prop('disabled', true)
	} else {
		$('.btn-action-rewash').prop('disabled', false)
	}
})

$('body').on('click', '.me-change', function (e) {
	let self = $(this)
	e.preventDefault()
	let url = $(this).prop('href')
	$.ajax({
		url: url,
		success: function (res) {
			if (res.status == 'success') {
				if (res.redirect != '') {
					loadPage(res.redirect, self)
				}

				toastr.success(res.message)
			}
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText, 'Code ' + error.status)
		}
	})
})

$('body').on('submit', '.no-post-action', function (e) {
	e.preventDefault();
})

$('body').on('submit', '.get-action', function (e) {
	e.preventDefault();
	$(this).find('[type="submit"]').attr('disabled', true).append(' <i class="icon-spinner2 spinner"></i>')

	let param = ''
	$(this).find('input,select').each(function (i, v) {
		let separator = i == 0 ? '?' : '&'
		param += separator + $(v).prop('name') + '=' + $(v).val()
	})

	loadPage($(this).prop('action') + param, $(this))
})

function handleSubmitAjax(thisElement) {
	$('#cover-spin').show()
	let self = $(thisElement)

	$('.handle-number-2,.handle-number-4').each(function (i, v) {
		$(v).val(normalizeNumber($(v).val()))
	})

	let sub = self.find('[type="submit"]')
	sub.next().attr('disabled', true)
	sub.attr('disabled', true).append(' <i class="icon-spinner2 spinner"></i>')
	let formData = new FormData(thisElement)
	let hasLibrary = self.hasClass('tag-library')
	$.ajax({
		url: self.prop('action'),
		method: self.prop('method'),
		data: formData,
		processData: false,
		contentType: false,
		xhr: function () {
			var xhr = new window.XMLHttpRequest();
			if (hasLibrary) {
				$('.progress').show();
				var line = $('.progress-bar')
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						line.css('width', Math.round(percentComplete * 100) + '%')
						line.text(Math.round(percentComplete * 100) + ' %')
					}
				}, false);
			}

			return xhr;
		},
		success: function (res) {
			$('body').removeClass('modal-open').css('padding-right', '')
			$('.modal-backdrop').remove();
			if (res.status == 'success') {
				if (res.redirect != '') {
					loadPage(res.redirect, self)
				}

				toastr.success(res.message)
			} else {
				toastr.error(res.message)
				showError(res.attribut, self)
			}

			sub.next().attr('disabled', false)
			sub.attr('disabled', false).find('i').remove()

			if (hasLibrary) {
				$('.progress').hide();
				var line = $('.progress-bar')
				line.css('width', '0%')
				line.text('0%')
			}

			// $('#cover-spin').hide()
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
			sub.next().attr('disabled', false)
			sub.attr('disabled', false).find('i').remove()
			if (error.responseJSON.attribut !== undefined) {
				showError(error.responseJSON.attribut, self)
			}
			if (hasLibrary) {
				$('.progress').hide();
				var line = $('.progress-bar')
				line.css('width', '0%')
				line.text('0%')
			}

			$('body').removeClass('modal-open').css('padding-right', '')
			$('.modal-backdrop').remove();
			$('#cover-spin').hide()
		}
	})
}

$('body').on('submit', '.post-action', function (e) {
	// $(this).preventDoubleSubmission();
	// if ($(this).data('submitted') === true) {
	e.preventDefault();
	// } else {
	handleSubmitAjax(this)
	// }
})

$('.main-menu').click(function () {
	let otherDrop = $('.main-menu').not($(this))
	for (let i = 0; i < otherDrop.length; i++) {
		let parent = $(otherDrop.get(i)).parent()
		parent.find('.drop-menu').removeClass('in')
		parent.find('.main-menu').removeClass('active').addClass('collapsed')
	}
})

$('body').on('click', '.delete-data', function (e) {
	e.preventDefault()
	Swal.fire({
		title: 'Apakah Kamu Yakin?',
		text: "Kamu akan menghapus data ini!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Tidak',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			deleteData($(this).prop('href'), $(this))
		}
	})
})

$('body').on('click', '.cancel-void-data', function (e) {
	e.preventDefault()
	Swal.fire({
		title: 'Apakah Kamu Yakin?',
		text: "Kamu akan mengembalikan data ini!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Tidak',
		confirmButtonText: 'Ya'
	}).then((result) => {
		if (result.isConfirmed) {
			deleteData($(this).prop('href'), $(this))
		}
	})
})

window.onpopstate = function (e) {
	if (e) {
		window.location.reload(true)
	}
};

function deleteData(link, target) {
	$('#cover-spin').show()
	let self = $(this)
	$.ajax({
		url: link,
		method: 'post',
		success: function (res) {
			if (res.status == 'success') {
				if (res.redirect != '') {
					loadPage(res.redirect, self)
				}

				$('.action-delete').data('url', '')
				$('#confirmation-delete').modal('hide')

				toastr.success(res.message)
			} else {
				$('#confirmation-delete').modal('hide')
				toastr.error(res.message)
			}

			$('#cover-spin').hide()
		}, error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
			$('#cover-spin').hide()
		}
	})
}

var tempids = []

$('body').on('click', '.select-delete', function (e) {
	e.preventDefault()
	let formSelect = $('[name="deleteselect[]"]')
	let ids = []
	for (let i = 0; i <= formSelect.length; i++) {
		if ($(formSelect.get(i)).is(':checked')) {
			ids.push($(formSelect.get(i)).val())
		}
	}

	tempids = ids
	let url = $(this).prop('href')
	$('.action-multi-delete').data('url', url)
	$('#confirmation-multi-delete').modal('show')
})

$('body').on('click', '.action-multi-delete', function (e) {
	if (tempids.length > 0) {
		multiDeleteData($(this).data('url'), $(this))
	}
})

$('body').on('input', '.input-capital', function () {
	let input = $(this).val()
	$(this).val(input.toUpperCase())
})

$('.select2').select2()

function multiDeleteData(link, tag) {
	$('#cover-spin').show()
	let self = $(this)
	tag.prev().attr('disabled', true)
	tag.attr('disabled', true).append(' <i class="icon-spinner2 spinner"></i>')
	$.ajax({
		url: link,
		method: 'post',
		data: {
			ids: tempids,
			page: key,
			redirect: currentUrl
		},
		success: function (res) {
			if (res.status == 'success') {
				$('.action-multi-delete').data('url', '')

				$('body').removeClass('modal-open').css('padding-right', '')
				$('.modal-backdrop').remove();

				if (res.redirect != '') {
					loadPage(res.redirect, self)
				}

				toastr.success(res.message)
			} else {
				$('body').removeClass('modal-open').css('padding-right', '')
				$('.modal-backdrop').remove();

				toastr.error(res.message)
			}

			tempids = []

			tag.prev().attr('disabled', false)
			tag.attr('disabled', false).find('i').remove()
			$('#cover-spin').hide()
		}, error: function (error) {
			$('#confirmation-multi-delete').modal('hide')
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
			tempids = []

			tag.prev().attr('disabled', false)
			tag.attr('disabled', false).find('i').remove()
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
				tag.parents('.form-group-new').addClass('has-error')
				tag.parents('.form-group').addClass('has-error')
			}
		}
	}
}

function loadPage(url, self = false) {
	$.ajax({
		cache: false,
		url: url,
		method: 'get',
		async: true,
		beforeSend: function (xhr) {
			$('#cover-spin').show()
		},
		success: function (res) {
			let targetHtml = $('#target-html');
			let h = res.html
			let s = res.html.search("<script")
			let en = res.html.length
			if (s > 0) {
				h = h.replace(res.html.substring(s, en), "")
			}

			targetHtml.html(h)

			activeMenu(res.parent)
			window.history.pushState(null, null, url);
			$('title').text(targetHtml.find('.page-title').text() + ' | ' + siteName)

			$('#replace-script').nextAll('script').remove()
			if (s > 0) {
				let tagJs = res.html.replace(res.html.substring(0, s), "");
				$('#replace-script').after(tagJs)
			}

			if (self && self.find('.spinner')) {
				self.find('.spinner').remove()
			}

			$('.modal-backdrop').remove()

			handleNumber2()
			handleNumber4()
			// $('.select2').select2()

			$('#cover-spin').hide()
		}, error: function (error) {
			self.find('.spinner').remove()
			handleError(error)
		}
	})
}

function activeMenu(name) {
	let menu = $('.navigation li')
	menu.removeClass('active')
	for (let i = 0; i < menu.length; i++) {
		let set = $(menu.get(i))
		if (name == set.data('route')) {
			set.addClass('active')
			set.parents('.parent-tag-menu').addClass('active')
		}
	}
}

$('.sidebar-section').each(function (i, v) {
	if ($(v).parent('li').next('li').find('a').length == 0) {
		$(v).parent('li').hide()
	}
})

$('.navigation-header').each(function (i, v) {
	if ($(this).next().hasClass('navigation-header')) {
		$(this).remove()
	}
})

if (window['timer']) {
	$("body").bind("touchstart touchmove scroll mousedown DOMMouseScroll mousewheel keyup", function (e) {
		clearTimeout(setTimer);
		setTimer = setTimeout(function () {
			$.ajax({
				method: 'get',
				url: logout,
				success: function (res) {
					$('.btn-login-back').click()
					$('#modal-login').modal({ backdrop: 'static', keyboard: false })
				}
			})
		}, timer);
	});
}

let deviceId = localStorage.getItem('deviceId')

$('.btn-login-barcode').click(function () {
	$('.input-login').hide()
	$('.input-barcode').show()

	setTimeout(function () {
		$('#barcode').focus()
	}, 500);
})

$('.btn-login-back').click(function () {
	$('.input-login').show()
	$('.input-barcode').hide()
})

$('#barcode').on('change', function () {
	let self = $(this)
	$.ajax({
		type: 'post',
		url: self.data('route'),
		data: {
			barcode: self.val(),
			redirect: '',
		},
		success: function (res) {
			$('#modal-login').modal('hide')
			self.val('')
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
		}
	})
})

$('body').on('submit', '.login-ajax', function (e) {
	e.preventDefault()
	let self = $(this)
	let formData = new FormData(this)
	$.ajax({
		url: self.prop('action'),
		method: self.prop('method'),
		data: formData,
		processData: false,
		contentType: false,
		success: function (res) {
			$('#modal-login').modal('hide')
			$('.login-ajax').find('input').each(function (i, v) {
				$(v).val('')
			})
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
		}
	})
})

$('#header-outlate').html('<i class="icon-office text-size-small"></i> &nbsp;Cabang ' + localStorage.getItem('magicOutlateName'))

function checkListNumbering() {
	$('#cover-spin').show()
	$.ajax({
		url: urlNumbering,
		type: 'get',
		success: function (res) {
			let html = ''
			for (let i = 0; i < res.data.length; i++) {
				let d = res.data[i]
				html += '<tr><td>' + d.sequence + '</td>'
				html += '<td>' + d.item_code + '</td>'
				html += '<td>' + d.transaction_code + '</td>'
				html += '<td>' + d.name + ' - ' + d.address + '</td></td>'
				html += '<td>' + d.taking + '</td>'
			}
			$('#modal-numbering').find('.modal-body tbody').html(html)
			$('#modal-numbering').modal('show')
			$('#cover-spin').hide()
		},
		error: function (error) {
			toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
			$('#cover-spin').hide()
		}
	})
}

function formatRupiah(number, prefix, self = '') {
	if (typeof number === 'string') {
		if (number.includes(',')) {
			let reg = number.match(/^([^,]*,[^,]*)/);
			number = normalizeNumber(reg[0])
		}
	}

	if (number == '0') {
		return 0;
	} else {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR",
			currencyDisplay: "code"
		}).format(number).replace("IDR", '').trim();
	}
}

function normalizeNumber(number) {
	number = number ? number : '0'
	if (number.indexOf(',') > -1) {
		number = number.replaceAll('.', '').replaceAll(',', '.')
	} else {
		number = number.replaceAll('.', '')
	}

	return parseFloat(number)
}

function handleComa(number) {
	number = number.toString()
	let explode = number.split('.')
	if (explode.length > 1) {
		let reverse = parseFloat(explode[1].split('').reverse().join(''))
		if (reverse > 0) {
			reverse = reverse.toString().split('').reverse().join('')
			explode[1] = reverse
		} else {
			explode.splice(1, 1)
		}
	}

	return explode.join('.')
}

handleNumber2()

function handleNumber2() {
	$('body').find('.handle-number-2').each(function (i, v) {
		let val = $(v).val()
		$(v).val(formatRupiah(val))
	})
}

$(document).on('change', '.handle-number-2', function () {
	let str = $(this).val() ? $(this).val() : 0
	if ((this).hasAttribute('data-max')) {
		$(this).val(formatRupiah(str, $(this)))
	} else {
		$(this).val(formatRupiah(str))
	}
})

$(document).on("beforeinput", '.handle-number-2,.handle-number-4', function (e) {
	var currentValue = $(this).val();
	if (currentValue == '0') {
		$(this).val('')
	}
});

$(document).on('input', '.handle-number-2,.handle-number-4', function () {
	let angka = $(this).val()
	angka = angka.toString().replace(/^\,|^0/, '0').replace(/[^,\d]/g, '')
	$(this).val(angka)
})

let tempNominal = '';

$(document).on('click', '.handle-number-2,.handle-number-4', function () {
	let val = normalizeNumber($(this).val());
	if (val == '0') {
		$(this).val('')
	} else {
		$(this).val(val.toString().replace('.', ','))
		tempNominal = val.toString().replace('.', ',')
	}
})

$(document).on('blur', '.handle-number-2,.handle-number-4', function () {
	if ($(this).val() == '') {
		$(this).val('0')
	} else {
		if (tempNominal == $(this).val()) {
			$(this).change()
		}
	}

	tempNominal = ''
})

handleNumber4()

function handleNumber4() {
	$('body').find('.handle-number-4').each(function (i, v) {
		let val = $(v).val()
		let prefix = $(this).data('prefix') ? $(this).data('prefix') : 0;
		$(v).val(formatNumber(val, prefix))
	})
}

$(document).on('change', '.handle-number-4', function () {
	let number = $(this).val() ? $(this).val() : 0
	let prefix = $(this).data('prefix') ? $(this).data('prefix') : 0;
	if ((this).hasAttribute('data-max')) {
		$(this).val(formatNumber(number, prefix, $(this)))
	} else {
		$(this).val(formatNumber(number, prefix))
	}
})

function formatNumber(number, prefix = 0) {
	if (typeof number === 'string') {
		if (number.includes(',')) {
			let reg = number.match(/^([^,]*,[^,]*)/);
			number = normalizeNumber(reg[0])
		}
	}

	if (number == '0') {
		return 0;
	} else {
		return new Intl.NumberFormat("id-ID", {
			style: 'decimal',
			minimumFractionDigits: 0,
			maximumFractionDigits: prefix
		}).format(number);
	}
}

var _cf = (function () {
	function _shift(x) {
		var parts = x.toString().split('.');
		return (parts.length < 2) ? 1 : Math.pow(10, parts[1].length);
	}
	return function () {
		return Array.prototype.reduce.call(arguments, function (prev, next) { return prev === undefined || next === undefined ? undefined : Math.max(prev, _shift(next)); }, -Infinity);
	};
})();

Math.tambah_qty = function () {
	var f = _cf.apply(null, arguments); if (f === undefined) return undefined;
	function cb(x, y, i, o) { return x + f * y; }
	return customRound(Array.prototype.reduce.call(arguments, cb, 0) / f, 4);
};

Math.kurang_qty = function (l, r) { var f = _cf(l, r); return customRound((l * f - r * f) / f, 4); };

Math.kali_qty = function () {
	var f = _cf.apply(null, arguments);
	function cb(x, y, i, o) { return (x * f) * (y * f) / (f * f); }
	return customRound(Array.prototype.reduce.call(arguments, cb, 1), 4);
};

Math.bagi_qty = function (l, r) { var f = _cf(l, r); return customRound((l * f) / (r * f), 4); };

Math.tambah = function () {
	var f = _cf.apply(null, arguments); if (f === undefined) return undefined;
	function cb(x, y, i, o) { return x + f * y; }
	return customRound(Array.prototype.reduce.call(arguments, cb, 0) / f, 2);
};

Math.kurang = function (l, r) { var f = _cf(l, r); return customRound((l * f - r * f) / f, 2); };

Math.kali = function () {
	var f = _cf.apply(null, arguments);
	function cb(x, y, i, o) { return (x * f) * (y * f) / (f * f); }
	return customRound(Array.prototype.reduce.call(arguments, cb, 1), 2);
};

Math.bagi = function (l, r) { var f = _cf(l, r); return customRound((l * f) / (r * f), 2); };

function customRound(number, prefix = 0) {
	let splitNumber = number.toString().split('.')
	let res = splitNumber.length == 2 ? number.toFixed(prefix) : number;
	return res;
}

// setTimeout(function() {
// 	$.ajax({
// 		url:showNotificationUrl,
// 		success:function(res){
// 			if (res.count != 0) {
// 				$('#target-notification').find('.count-notif').text(res.count).show()
// 				$('#target-notification').find('.notifications').html(res.html).addClass('action')
// 			}


// 		}
// 	})
// }, 500);

// $('#target-notification').on('click','a',function(){
// 	if ($('#target-notification').find('.notifications').hasClass('action')) {
// 		setTimeout(function() {
// 			$.ajax({
// 				url:readNotificationUrl,
// 				success:function(res){
// 					$('#target-notification').find('.count-notif').hide()
// 					$('#target-notification').find('.notifications').removeClass('action')
// 				}
// 			})
// 		}, 500);
// 	}
// })

// Echo.private('orders').listen('NewOrder', (e) => {
// 	let tcnotif = $('#target-notification').find('.count-notif')
// 	tcnotif.text(parseInt(tcnotif.text())+1).show()
// 	let html = '<li><a href="'+e.url+'" class="notification-item me"><span class="dot bg-success"></span>Pemesanan dengan code '+e.code+' dari '+e.name+'</a></li>'
// 	$('#target-notification').find('.notifications').append(html).addClass('action')

// 	if (! ('Notification' in window)) {
// 		console.log('Web Notification is not supported');
// 		return;
// 	}

// 	Notification.requestPermission( permission => {
// 		let notification = new Notification('Pesanan Baru', {
// 			body: 'Pemesanan dengan code '+e.code+' dari '+e.name,
// 			icon: e.icon
// 		});


// 		notification.onclick = () => {
// 			window.open(e.url);
// 		};
// 	});
// })

function handleError(error) {
	if (error.status == 401) {
		window.location.replace(siteMain + '/auth/login?redirect=' + window.location.href);
	} else {
		toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
		$('#cover-spin').hide()
	}
}