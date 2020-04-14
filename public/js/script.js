jQuery(document).ready(function() {
    var avatarWidth = jQuery('.avatar-wrapper .avatar').width();
    jQuery('.avatar-wrapper .avatar').each(function(i, ele) {
        ele.style.height = avatarWidth + 'px';
    });

    jQuery('#forms-table table').DataTable();
});