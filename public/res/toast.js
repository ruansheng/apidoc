/**
 * 模仿android里面的Toast效果，主要是用于在不打断程序正常执行的情况下显示提示数据
 * @param config
 * @return
 */
var Toast = function(config){
    this.context = config.context==null?$('body'):config.context;//上下文
    this.message = config.message;//显示内容
    this.time = config.time==null?3000:config.time;//持续时间
    this.left = config.left;//距容器左边的距离
    this.top = config.top;//距容器上方的距离
};

var msgEntity;

Toast.prototype = {
    //显示动画
    success :function(){
        $("#toastMessage").remove();
        //设置消息体
        var msgDIV = new Array();
        msgDIV.push('<div id="toastMessage" style="border-radius:7px;">');
        msgDIV.push('<span>'+this.message+'</span>');
        msgDIV.push('</div>');
        msgEntity = $(msgDIV.join('')).appendTo(this.context);
        //设置消息样式
        var left = this.left == null ? this.context.width()/2-msgEntity.find('span').width()/2 : this.left;
        var top = this.top == null ? '20px' : this.top;
        msgEntity.css({position:'absolute',top:top,'z-index':'99999',left:left,'background-color':'#449d44',color:'white','font-size':'18px',padding:'10px',margin:'10px'});
        msgEntity.hide();

        msgEntity.fadeIn(this.time/2);
        msgEntity.fadeOut(this.time/2);
    },
    error :function(){
        $("#toastMessage").remove();
        //设置消息体
        var msgDIV = new Array();
        msgDIV.push('<div id="toastMessage" style="border-radius:7px;">');
        msgDIV.push('<span>'+this.message+'</span>');
        msgDIV.push('</div>');
        msgEntity = $(msgDIV.join('')).appendTo(this.context);
        //设置消息样式
        var left = this.left == null ? this.context.width()/2-msgEntity.find('span').width()/2 : this.left;
        var top = this.top == null ? '20px' : this.top;
        msgEntity.css({position:'absolute',top:top,'z-index':'99999',left:left,'background-color':'#c9302c',color:'white','font-size':'18px',padding:'10px',margin:'10px'});
        msgEntity.hide();
        msgEntity.fadeIn(this.time/2);
        msgEntity.fadeOut(this.time/2);
    }

};

//new Toast({context:$('body'),top:200 ,message:'Toast效果显示'}).success();
//new Toast({context:$('body'),top:200 ,message:'Toast效果显示'}).error();
