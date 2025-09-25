var firebaseConfig = {
    apiKey: "AIzaSyDFU0157hce09U9iCnbP6ZxxyfV7JS26Ac",
    authDomain: "mymagic-c120a.firebaseapp.com",
    projectId: "mymagic-c120a",
    storageBucket: "mymagic-c120a.appspot.com",
    messagingSenderId: "991184321453",
    appId: "1:991184321453:web:efed106c43033a7f9a3f24",
    measurementId: "G-4K0E3T8PTB"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
// console.log(messaging.getToken())
messaging.requestPermission().then(function () {
    return messaging.getToken()
}).then(function (token) {
    if (!localStorage.getItem('fcmToken')) {
        $.ajax({
            url: siteMain + '/auth/fcmtoken',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'post',
            data: { fcm_token: token },
            success: function (res) {
                localStorage.setItem('fcmToken', token)
            },
            error: function (error) {
                console.error(error)
            }
        })
    }
}).catch(function (err) {
    console.log("Unable to get permission to notify.")
});

messaging.onMessage(function (payload) {
    var notify;
    notify = new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon,
    });

    let html = '<li class="media"><div class="media-left"><span class="badge bg-danger-400 media-badge">-</span></div>'
        + '<div class="media-body">'
        + '<a href="javascript:void(0)" class="media-heading">'
        + '<span class="text-semibold">' + payload.notification.title + '</span>'
        + '<span class="media-annotation pull-right"></span>'
        + '</a><span class="text-muted">' + payload.notification.body + '</span></div></li>'

    $('.dropdown-content-body').prepend(html)
    let countNumber = parseFloat($('.badge-notif').text())
    $('.badge-notif').text(countNumber + 1).css('display', 'block')

    $('#btn-notification-effect').click()
    Swal.fire({
        position: 'center',
        icon: 'info',
        title: payload.notification.title,
        text: payload.notification.body,
        showConfirmButton: false,
        timer: 5000
    })

    if (payload.notification.title.toLowerCase() == 'permintaan ambilan') {
        if ($('#menu-request_trans').find('.request_unread').length == 0) {
            // console.log($('#menu-request_trans').find('.request_unread').length)
            $('#menu-request_trans').append('<span class="label label-warning request_unread"><i class="icon-warning"></i></span>')
        }
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
});

$('.btn-logout').click(function (e) {
    messaging.deleteToken()
})

$('#btn-notification-effect').click(function () {
    notifSound.play();
})
