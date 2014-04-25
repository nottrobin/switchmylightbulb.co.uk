function instantLightbox(content) {
    var anchor = jQuery('<a href="#popup"></a>');
    console.log(anchor);
    anchor.fancybox({
        'content'       : '<section id="popup">'+content+'</section>',
        'overlayOpacity': 0.7
    });
    anchor.trigger('click');
}
