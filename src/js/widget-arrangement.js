$(function () {

    $canvas = $('.grid-stack-main');
    var options = {
        width: 10,
        float: true,
        removable: '.trash',
        removeTimeout: 100,
        placeholderClass: 'grid-stack-placeholder',
        acceptWidgets: '.grid-stack-item'
    };
    $canvas.gridstack(options);

    $('.gridstack-sidebar .grid-stack-item').draggable({
        revert: 'invalid',
        handle: '.grid-stack-item-content',
        scroll: false,
        appendTo: 'body'
    });
});