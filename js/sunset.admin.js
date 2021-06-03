jQuery(document).ready(function ($) {
    var mediaUploader;
    $('#upload-button').on('click', function (e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Your Profile',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();

            $('#profile_pic').val(attachment.url);
            $('#profic-preview').css('background-image', 'url(' + attachment.url + ')');
        });
        mediaUploader.open();

    });
    // Profile Remove Actions
    $('#remove-button').on('click', function (e) {
        e.preventDefault();
        var answer = confirm('Are you sure you want to remove this profile ?');
        if (answer) {
            $('#profile_pic').val('');
            $('.sunset-general-form').submit();
        }
    });

    // Name, Descriptions live preview
    $('#first-name, #last-name, #describe').on('keyup', function () {
        var fName = $('#first-name').val();
        var lName = $('#last-name').val();
        var fullName = fName + ' ' + lName;
        var describe = $('#describe').val();
        $('#name').text(fullName);
        $('#desc').text(describe);
    });
});
