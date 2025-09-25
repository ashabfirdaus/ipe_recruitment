function notifambilan() {
    $.ajax({
        url: notifUrl,
        type: 'get',
        success: function (res) {
            let html = ''
            for (let i = 0; i < res.data.length; i++) {
                html += '<li class="media">'
                if (res.data[i].status == '1') {
                    html += '<div class="media-left"><span class="badge bg-danger-400 media-badge">-</span></div>'
                }

                html += '<div class="media-body">'
                    + '<a href="javascript:void(0)" class="media-heading">'
                    + '<span class="text-semibold">' + res.data[i].label + '</span>'
                    + '<span class="media-annotation pull-right">' + res.data[i].created_at + '</span>'
                    + '</a><span class="text-muted">' + res.data[i].message + '</span></div></li>'
            }

            if (res.count > 0) {
                $('.badge-notif').text(res.count).css('display', 'block')
            }

            $('.dropdown-content-body').html(html)
            if (res.request_count > 0) {
                let notifreq = ''
                if (res.request_count_unread > 0) {
                    notifreq += '<label style="float:right;margin-left:10px;" class="request_unread"><i class="icon-warning" style="color:#ff5722;"></i></label>'
                }

                notifreq += '<label class="label bg-blue-400">' + res.request_count + '</label>'
                $('#menu-request_trans').append(notifreq)
                $('#menu-request_trans').parents('li').find('.has-ul>span').html($('#menu-request_trans').parents('li').find('.has-ul>span').text().trim() + '<span style="float:right;"><i class="icon-notification2" style="color:#29b6f6;"></i></span>')
            }

            if (res.delivery_count > 0) {
                $('#menu-delivery').append('<label class="label bg-blue-400">' + res.delivery_count + '</label>')
                $('#menu-delivery').parents('li').find('.has-ul>span').html($('#menu-delivery').parents('li').find('.has-ul>span').text().trim() + '<span style="float:right;"><i class="icon-notification2" style="color:#29b6f6;"></i></span>')
            }

            if (res.trans_count > 0) {
                $('#menu-transaction').append('<label class="label bg-blue-400">' + res.trans_count + '</label>')
                $('#menu-transaction').parents('li').find('.has-ul>span').html($('#menu-transaction').parents('li').find('.has-ul>span').text().trim() + '<span style="float:right;"><i class="icon-notification2" style="color:#29b6f6;"></i></span>')
            }

            if (res.pkg_count > 0) {
                $('#menu-package_purchase').append('<label class="label bg-blue-400">' + res.pkg_count + '</label>')
                $('#menu-package_purchase').parents('li').find('.has-ul>span').html($('#menu-package_purchase').parents('li').find('.has-ul>span').text().trim() + '<span style="float:right;"><i class="icon-notification2" style="color:#29b6f6;"></i></span>')
            }

            if (res.prod_count > 0) {
                $('#menu-prod_process').append('<label class="label bg-blue-400">' + res.prod_count + '</label>')
                $('#menu-prod_process').parents('li').find('.has-ul>span').html($('#menu-prod_process').parents('li').find('.has-ul>span').text().trim() + '<span style="float:right;"><i class="icon-notification2" style="color:#29b6f6;"></i></span>')
            }

            if (res.transfer_count > 0) {
                $('#menu-send_item').append('<label class="label bg-blue-400">' + res.transfer_count + '</label>')
                $('#menu-send_item').parents('li').find('.has-ul>span').html($('#menu-send_item').parents('li').find('.has-ul>span').text().trim() + '<span style="float:right;"><i class="icon-notification2" style="color:#29b6f6;"></i></span>')
            }
        },
        error: function (error) {
            toastr.error(error.hasOwnProperty('responseJSON') ? error.responseJSON.message : error.statusText)
        }
    })
}

notifambilan()
// $('.sidebar .navigation a').click(function () {
//     if ($(this).parent().data('route') == 'transaction') {
//         notifambilan()
//     }
// })

$('.btn-notification').click(function () {
    setTimeout(function () {
        $.ajax({
            url: readAllUrl,
            type: 'get',
            success: function (res) {
                $('.badge-notif').text(0).css('display', 'none')
                $('.media-list .media-left').remove()
            },
            error: function (error) {
                console.log(error)
            }
        })
    }, 2000);
})