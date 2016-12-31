$(function(){
    $('#js_btn_comment_save').click(function(){
        save_comment();
    });
    get_comment_list();
})

function get_comment_list(){
    var api_url  = build_url('list', 'comment', 'api');
    $.get(api_url, {'post_id':post_id}, function(data){
        //var data = eval("("+data+")");
        if(data['code'] == 200){
            var comment_list  = data['data']['list'];
            var comment_count = comment_list.length;
            for(i=0; i<comment_count; i++){
                create_comment_item(comment_list[i]);
            }
        }
    })
}

function create_comment_item(data){


    var time = data['create_time'] ? data['create_time'] : 0;
    if(time){
        time = parseInt(time) * 1000;
    }else{
        time = new Date().getTime();
    }
    var d = new Date(time);
    var mouth  = d.getMonth()+1;
    if(mouth<10) mouth = '0' + mouth;
    var day    = d.getDate();
    if(day<10) day = '0' + day;
    var hour   = d.getHours();
    if(hour<10) hour = '0' + hour;
    var minute = d.getMinutes();
    if(minute<10) minute = '0' + minute;
    var second = d.getSeconds();
    if(second<10) second = '0' + second;
    time = d.getFullYear()+"-"+mouth+"-"+day+" "+hour+":"+minute+":"+second;

    var comment_item = '';
    comment_item += '<div class="comment first odd clearfix">';
    comment_item += '    <ul class="links inline">';
    comment_item += '        <li class="comment_forbidden first last">';
    comment_item += '            <span><a href="javascript:void(0)">登录</a> - 评论</span>';
    comment_item += '        </li>';
    comment_item += '    </ul>';
    comment_item += '    <div class="submitted">';
    comment_item += '        <span>';
    comment_item += '            <a title="查看用户资料" href="javascript:void(0)">'+data['nickname']+'</a>';
    comment_item += '        </span>';
    comment_item += '    </div>';
    comment_item += '    <div class="content">';
    comment_item +=          data['content'];
    comment_item += '        <p class="submitted">';
    comment_item += '            <span>'+time+'</span>';
    comment_item += '        </p>';
    comment_item += '    </div>';
    comment_item += '</div>';
    $('#comment_list').prepend(comment_item);
}

function save_comment(){
    var content  = $('#comment_body').val();
    var post_id  = $('#post_id').val();
    var nickname = $('#nickname').val();
    if(!content || !post_id || !nickname){
        return false;
    }
    var api_url  = build_url('add', 'comment', 'api');
    $.post(api_url, {'content':content, 'post_id':post_id, 'nickname':nickname}, function(data){
        //data = eval("("+data+")")
        if(data['code'] == 200){
            var tmp = new Array();
            tmp['content']  = content;
            tmp['nickname'] = nickname;
            create_comment_item(tmp);

            $('#comment_body').val('');
        }
    })
}


/**
 * 创建URL函数
 *
 * @param action      //方法名
 * @param controller  //类名
 * @param app         //应用名
 * @param param       //参数，格式如:{'id':15, 'name':'zhangsan'}
 */
function build_url(action, controller, app, param){
    var url = '/'+app+'/'+controller+'/'+action;
    if(param){
        var s = '';
        $.each(param, function(i, n){
            s += '&' + i + '=' + n;
        });
        s=s.substr(1);
    }
    if(s) url += '?' + s;

    return url;
}
