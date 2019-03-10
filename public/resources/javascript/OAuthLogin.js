/* 让FF 7 支持outerHTML*/
	try{
		if (typeof(HTMLElement) != "undefined") {
		   HTMLElement.prototype.__defineSetter__("outerHTML", function(s) {
		        var r = this.ownerDocument.createRange();
		        r.setStartBefore(this);
		        var df = r.createContextualFragment(s);
		        this.parentNode.replaceChild(df, this);
		        return s;
		    });
		   HTMLElement.prototype.__defineGetter__("outerHTML", function(){
		        var a = this.attributes, str = "<" + this.tagName, i = 0;
		        for (; i < a.length; i++)
		            if (a[i].specified)
		                str += " " + a[i].name + '="' + a[i].value + '"';
		        if (!this.canHaveChildren)
		            return str + " />";
		        return str + ">" + this.innerHTML + "</" + this.tagName + ">";
		    });
		
		    HTMLElement.prototype.__defineGetter__("canHaveChildren", function(){
		        return !/^(area|base|basefont|col|frame|hr|img|br|input|isindex|link|meta|param)$/.test(this.tagName.toLowerCase());
		    });
		}
	}catch(e){
	}
document.onkeydown = function(e){
   if(!e) e = window.event;//火狐中是 window.event
   if((e.keyCode || e.which) == 13){
    if(e.target.id=="user_name"){
    	e.preventDefault();
    	//enteruser_pwd(e);/*默认回车就是进入下一个元素*/
    }
    else if(e.target.id=="user_pwd"){
    	if($("#sms_area:visible").length>0 || $("#otp_area:visible").length>0 || $("#code_area:visible").length>0){
	    	e.preventDefault();
    	}
    }
   }
}

function focusUserName(){
	var name=$("#user_name").val();
	if(""!=name/* && "学号/职工号/北大邮箱"!=name*/){
		$("#user_name").css("color","#000000");
	}
}
function leaveUserName(){
	var name=$("#user_name").val();
	if(""==name/* || "学号/职工号/北大邮箱"==name*/){
		$("#user_name").css("color","#B7B7B9");
	}
}
function enteruser_pwd(keypressed){
	var key;
    if (document.all) {
        key=window.event.keyCode;
    }
    else {
        key=keypressed.which;
    };
	if(key==13){
		$("#user_pwd").focus();
	}
	else{
		var name=$("#user_name").val();
		if(""==name/* || "学号/职工号/北大邮箱"==name*/){
			$("#user_name").val("");
			$("#user_name").css("color","#000000");
		}
		$("#user_name").next(".i-clear").show();
	}
}
function focususer_pwd(){
  $("#user_pwd").css("color","#000000");
  $("#user_pwd").next(".i-clear").show();
  $("#user_pwd").select();
}
function leaveuser_pwd(){
  var val = $("#user_pwd").val();
  if(""==val){
	   //$("#user_pwd")[0].outerHTML="<input class='input-txt-row input-txt-pad' type='text' id='user_pwd' name='user_pwd' tabIndex = '2'  value='密码' onFocus='focususer_pwd()' onblur='leaveuser_pwd()' onKeyDown='enterSMSCode(event)'  onMouseOver='changeBorderColor(this)' onMouseOut='backBorderColor(this)''/>";
	   $("#user_pwd").css("color","#B7B7B9");
	   $("#user_pwd").next(".i-clear").hide();
  }
}
function reCalculate(){
	var offset = document.body.clientWidth-1000>0?0:document.body.clientWidth-1000;
	$("#left")[0].style.width=555+offset; 
}
var viewIntr=["博雅塔","北阁","办公楼前的华表","北京大学匾额","未名湖博雅塔","南北阁"]
var viewAuth=["吕凤翥","吕凤翥","吕凤翥","吕凤翥","吕凤翥","吕凤翥"]
var vwNo=1;
var vwCnt=12;
function focusName(){
	vwNo = Math.round((Math.random()*10))%vwCnt+1;
	$(".mid").css("background-image","url(/resources/images/pku_view_"+vwNo+".jpg)");
	
	var name=$("#user_name").val();
	if(""!=name/* && "学号/职工号/北大邮箱"!=name*/){
		$("#user_name").next(".i-clear").show();
	}
}
function changeBorderColor(obj){
	obj.style.borderColor="#B40605";
}
function backBorderColor(obj){
	obj.style.borderColor="#CECECE";
}
function changeOutlineColor(obj){
	obj.style.outline="1px solid #B40605";
}
function backOutlineColor(obj){
	obj.style.outline="";
}
function clickCheck(){
	if($("#remember_check").attr("checked")===true || $("#remember_check").attr("checked")==="checked"){
		$("#remember_check").removeAttr("checked");
		$("#remember_text").children(".i-check").removeClass("fa-check-square-o").addClass("fa-square-o");
	}
	else{
		$("#remember_check").attr("checked","checked");
		$("#remember_text").children(".i-check").removeClass("fa-square-o").addClass("fa-check-square-o");
	}
}

function resetInput(event){
	var input = $(event.target).parent().prev("input");
	input.val("");
	$(event.target).parent(".i-clear").hide();
	input.focus();
}
