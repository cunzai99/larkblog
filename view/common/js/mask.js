(function () {
    $.extend($.fn, {
        mask: function (msg, msgIsObj, maskDivClass) {
            this.unmask();
            var op = {
                opacity: 0.8,
                z: 9999,
                bgcolor: '#ccc'
            };
            var original = $(document.body);
            var position = {top: 0, left: 0, bottom: 0, right: 0};
            if (this[0] && this[0] !== window.document) {
                original = this;
                position = original.position();
            }
            var maskDiv = $('<div class="maskdivgen">&nbsp;</div>');
            maskDiv.appendTo(original);
            var maskWidth = original.outerWidth();
            if (!maskWidth) {
                maskWidth = original.width();
            }
            var maskHeight = original.outerHeight();
            if (!maskHeight) {
                maskHeight = original.height();
            }
            maskDiv.css({
                position: 'absolute',
                top: position.top,
                right: position.right,
                left: position.left,
                bottom: position.bottom,
                'z-index': op.z,
                width: maskWidth,
                'background-color': op.bgcolor,
                opacity: 0
            });
            if (maskDivClass) {
                maskDiv.addClass(maskDivClass);
            }
            if (msg && msgIsObj){
                maskDiv.append(msg);
            }else if (msg) {
                /*var msgDiv = $('<div style="position:absolute;border:#6593cf 1px solid; padding:2px;background:#ccca">'+
                 '<div style="line-height:24px;border:#a3bad9 1px solid;background:white;padding:2px 10px 2px 10px">' +
                 msg + '</div></div>');*/
                var msgDiv = $('<div style="position:absolute; width: 200px; height: 100px; ' +
                    'line-height: 100px; text-align: center; border:#ccc 2px solid;background-color: #eee; ' +
                    'padding:8px; -moz-border-radius: 8px;-webkit-border-radius: 8px;border-radius: 10px;">' +
                    '<div style="line-height:24px;padding:10px 2px 2px 2px">' +
                    msg + '</div></div>');
                msgDiv.appendTo(maskDiv);
                var widthspace = (maskDiv.width() - msgDiv.width());
                var heightspace = (maskDiv.height() - msgDiv.height());
                msgDiv.css({
                    cursor: 'wait',
                    top: (heightspace / 2 - 2),
                    left: (widthspace / 2 - 2)
                });
            }
            maskDiv.fadeIn('fast', function () {
                $(this).fadeTo('slow', op.opacity);
            })
            return maskDiv;
        },
        unmask: function () {
            var original = $(document.body);
            if (this[0] && this[0] !== window.document) {
                original = $(this[0]);
            }
            original.find("> div.maskdivgen").fadeOut('slow', 0, function () {
                $(this).remove();
            });
        }
    });
})();
/*
 function doMask(){
 var waiting = '<div style="text-align: center">' +
 '<img src="pop_images/waiting.gif" style="margin: 0 auto; width:40px; height:40px;">' +
 '<p style="text-align: center">连接中，请稍等...</p>' +
 '</div>'
 $.fn.mask(waiting);
 }
    */