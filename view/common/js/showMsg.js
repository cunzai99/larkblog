/**
 * 提示框插件
 * 
 * 调用demo
 * showMsgObj = new showMessage();     //实例化showMessage类
 * showMsgObj.showMsg(type, param);    //调用提示接口
 * 
 * 参数说明
 *
 * type  提示类型 1：顶部 2：右下角 3：中间弹窗
 * param {status: 1, msg: '右下角提示区测试(自动关闭)！'}
 * param {status: 1, msg: '顶部提示区测试(不自动关闭)！', autoClose: false}
 * param {status: 1, msg: 'test', title: '标题参数测试', cancelable: true, callback: 'deleteMessage'}

 * status     提示状态 1:success  2: warning 3: false
 * msg        提示内容(可包含html标签)
 * title      页面中间弹窗提示标题
 * cancelable 页面中间弹窗提示是否有取消按钮
 * callback   页面中间弹窗提示确定按钮请求函数名
 * autoClose  提示自动关闭(默认自动关闭，页面中间弹窗提示除外)
 * 
 */
showMessage = function(config){
    this.autoClose  = true;
    this.cancelable = true;
    this.params = {};
    this.backgroundWarning  = 'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAaCAMAAAB2FAnXAAAAA3NCSVQICAjb4U/gAAAATlBMVEXSikLSi0PRiULQiUHPiEDOhz/Nhj3MhDzLgzvKgjrJgTnIgDjHfzfGfjbFfTXEfDTDezPCejLBeTHAeDDAdy++di2/di6+dSy8dCu9dCzCd76rAAAACXBIWXMAAArwAAAK8AFCrDSYAAAAFnRFWHRDcmVhdGlvbiBUaW1lADA0LzIxLzEy3/unGwAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAABJSURBVEiJvcGHAYAgAMCwukURFw7+f5QvmtAIULQCOgG9gEHAKGASMAsIAhYBq4AoYBOQBOwCDgGngEvALSALeAU8Aj4BRcAvqFbWfvWrI4QbAAAAAElFTkSuQmCC") repeat-x scroll 0 0 rgba(0, 0, 0, 0)';
    this.backgroundSuccess  = 'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAaCAMAAAB2FAnXAAAAA3NCSVQICAjb4U/gAAAATlBMVEVlt1Jnt1RktlFitU9htE1fs0tdsklbsUdasEVYr0NWrkFUrj9SrT5RrDxPqzpNqjhMqTZKqDRIpzJHpjFFpS9EpS5DpCxBoypCoytAoiluTsbkAAAACXBIWXMAAArwAAAK8AFCrDSYAAAAFnRFWHRDcmVhdGlvbiBUaW1lADA0LzIxLzEy3/unGwAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNAay06AAAABJSURBVEiJvcGHAYAgAMCwukURFw7+f5QvmtAIULQCOgG9gEHAKGASMAsIAhYBq4AoYBOQBOwCDgGngEvALSALeAS8An4Bn4AiqC9ifvUz4IB3AAAAAElFTkSuQmCC") repeat-x scroll 0 0 rgba(0, 0, 0, 0)';
    this.backgroundFalse    = '#FF0000';
    this.init();
};

showMessage.prototype = {
    init : function(){
        if($('#topMsgContainer').length==0){
            var bottomMsgContainerDiv = $('<div id="topMsgContainer"></div>');
            bottomMsgContainerDiv.appendTo('body');
            bottomMsgContainerDiv.css({
                margin:'auto',
                position:'fixed',
                width:'150px',
                whiteSpace:'nowrap',
                textAlign:'center',
                top: 0,
                left:0,
                right:0,
                zIndex: 10000
            });
        }

        if($('#bottomMsgContainer').length==0){
            var bottomMsgContainerDiv = $('<div id="bottomMsgContainer"></div>');
            bottomMsgContainerDiv.appendTo('body');
            bottomMsgContainerDiv.css({
                position: 'absolute',
                right: 0,
                bottom: '3px',
                zIndex: 10000
            });
        }
    },
    showMsg : function(type, params){
        var msgBoxId;
        var autoClose = params.autoClose;
        this.params   = params;

        switch(type){
            case 1: msgBoxObj  = this._getMsgTopBox();    msgBoxContainer = 'topMsgContainer'; break;
            case 2: msgBoxObj  = this._getMsgBottomBox(); msgBoxContainer = 'bottomMsgContainer'; break;
            case 3: msgBoxObj  = this._getMsgBox();       msgBoxContainer = ''; break;
            default: msgBoxObj = '';
        }

        //对象追加到页面
        if (msgBoxObj){
            if (type == 3){
                $('body').append(msgBoxObj);
            }else{
                $('#'+msgBoxContainer).append(msgBoxObj);
            }

            //显示对象
            msgBoxId = msgBoxObj.attr('id');
            if (msgBoxId){
                $("#"+msgBoxId).slideDown('slow');
            }
        }

        //判断自动关闭
        if(type != 3){
            if ((autoClose != undefined && autoClose) || (autoClose == undefined && this.autoClose)){
                var that = this;
                if(type==1)
                    setTimeout(function(){
                        that.closeBySlideUp(msgBoxId);
                    }, 2000);
                else if(type==2)
                    setTimeout(function(){
                        that.closeBySlideUp(msgBoxId);
                    }, 2000);
            }
        }
        return msgBoxObj;
    },
    //页面顶部提示
    _getMsgTopBox : function(){
        var msg     = this.params.msg;
        var status  = this.params.status;
        var divObj  = $("#js_showmsg_top_container").clone();
        var spanObj = divObj.find("#js_showmsg_top_content");

        var timestamp = new Date().getTime();
        var bg = status==1 ? this.backgroundSuccess : (status==2 ? this.backgroundWarning : this.backgroundFalse);
        divObj.attr('id', 'topTips_'+timestamp);
        divObj.css('background', bg);
        
        spanObj.html(msg);
        spanObj.css({color: '#FFFFFF'});

        return divObj;
    },
    //弹窗提示
    _getMsgBox : function(){
        var msg       = this.params.msg;
        var title     = this.params.title;
        var divObj    = $("#js_showmsg_container").clone();
        var timestamp = new Date().getTime();
        var msgBoxId  = 'msgBox_'+timestamp;
        divObj.attr('id', msgBoxId);

        var msgBoxHead = divObj.find('#js_showmsg_container_head');
        msgBoxHead.attr('id', 'showmsg_container_head');
        msgBoxHead.html(title);

        divObj.find('#js_showmsg_close_b').click(function(){closeMsgBox(msgBoxId, '', '', true)});
        divObj.find('#js_showmsg_close_cancel').click(function(){closeMsgBox(msgBoxId, '', '', true)});
        var callback = this.params.callback;

        if (callback) {
            divObj.find('#js_showmsg_close_confirm').click(function(){
                callback();
            });
        }

        var msgBoxContent = divObj.find('#js_showmsg_container_content');
        msgBoxContent.html(msg);

        return divObj;
    },
    //页面右下角提示
    _getMsgBottomBox : function(){
        var msg = this.params.msg;
        var divObj = $("#js_showmsg_bottom_container").clone();
        var timestamp = new Date().getTime();
        divObj.attr('id', 'bottomTips_'+timestamp);
        divObj.html(msg);
        divObj.show();

        return divObj;
    },
    closeBySlideUp : function(msgBoxId, time){
        time = time ? time : 500;
        $('#'+msgBoxId).slideUp(time);
    },
    closeByFadeOut : function(msgBoxId, time){
        time = time ? time : 500;
        $("#"+msgBoxId).fadeOut(time);
    }
}