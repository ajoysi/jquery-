	

 //点击查看更多  控制下拉上拉效果
			function zk() {
	        var th = $('.app');
	        var h = th.css('height');
	        if (h == '150px') {
	        	th.css('height', '430px');
	            $('#click_img').attr('src', 'images/bt_pull.png');
	            $(".bottom").show();
	          
	        } else {
	              th.css('height', '150px');
	            $('#click_img').attr('src', 'images/bt_down.png');

	        }
	    }
// 显示时间
		$(function(){
			setInterval(fn,1000);
			function fn(){
		    var arr = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
		    var date = new Date();	
		    var innerHTML = date.getFullYear()+"年"+ (date.getMonth()+1) +
		             "月" + date.getDate() + "日" + "  " + arr[date.getDay()];  
		    $(".date").html(innerHTML);
		    var hours = date.getHours();
		    var minutes=date.getMinutes();
		    var second=date.getSeconds()
		    if(minutes<10){
		    	var num ="0"+minutes;
		    }else{
		    	var num =minutes;
		    }
		    if(second<10){
		    	var second ="0"+second;
		    }else{
		    	var second =second;
		    }
		       
		    if(hours <10){
		          var hoursInnerHTML = "上午"+"0"+ date.getHours()+":"+num+":"+second;          
		        }
		        else if(hours <12){
		          var hoursInnerHTML = "上午"+ date.getHours()+":"+num+":"+second;  	
		        }
		        else if(hours <18){
		            var hoursInnerHTML = "下午"+ date.getHours()+":"+num+":"+second ;          
		        }else if(hours <=23){
		            var hoursInnerHTML = "晚上"+ date.getHours()+":"+num+":"+second;
		           
		        }
		    $(".day").html(hoursInnerHTML);
		}

		 });