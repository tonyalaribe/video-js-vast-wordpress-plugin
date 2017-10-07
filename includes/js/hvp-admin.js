jQuery(document).ready(function($){
    function uploader(button, id, upload_type){
        var file_frame = wp.media.frames.file_frame = wp.media({
            frame: 'post',
            state: 'insert',
            title: button.data('uploader-title'),
            button: {text: button.data('uploader-button-text')},
            library: {type: upload_type},
            multiple: false,
        });
        file_frame.on('insert', function(){
            var selection = file_frame.state().get('selection');
            selection.each(function(attachment, index){
                attachment = attachment.toJSON();
                id.val(attachment.url);
            });
        });
        file_frame.open();
    }
    if ($('.hvp-video-upload').length > 0 && typeof wp !== 'undefined' && wp.media && wp.media.editor)
    {
        $(document).on('click', '.hvp-video-upload', function(e){
            e.preventDefault();
            var button = $(this);
            var id = button.prev();
            uploader(button, id, 'video');
            return false;
        });
        $(document).on('click', '.hvp-poster-upload', function(e){
            e.preventDefault();
            var button = $(this);
            var id = button.prev();
            uploader(button, id, 'image');
            return false;
        });
    }
    $(document).on('ready', function() {
        $('#hvp-firstrun-overlay').fadeIn();
        $('#hvp-firstrun-content').fadeIn();
        if ($('.hvp-video-ads').is(':checked'))
            $('.hvp-ads-container').show().focus();
        else
            $('.hvp-ads-container').hide();
    });
    $(document).on('click', '.hvp-close-button', function(){
        hvp.handle_close();
        return true;
    });
    $(document).on('change', '.hvp-video-ads', function(){
        if ($(this).is(':checked'))
        {
            $('.hvp-ads-container').show().focus();
        }
        else
        {
            $('.hvp-ads-container').hide();
        }
    });
    window.hvp = {
        handle_close: function(){
            $('.hvp-popup-overlay').fadeOut();
            $('.hvp-popup-content').fadeOut();
        },
        create_lead: function(){
            
        },
        set_user_info: function(info) {
            this.user_info = info;
        },
    };
});
