jQuery(document).ready(function(){
	var waiting_pay = $('.waiting-pay');
		
	function changeButton(parent) {
		var obj = parent.find("span");
		obj.addClass('setallfinished');
        obj.text("訂單已完成");
        obj.removeClass('setfinished');
	}
	function setdiscount(finalprice,discount) {
		var total = parseInt(finalprice) - parseInt(discount);
		$('#final_price').text(total);
		$('#coupon').text(discount);
	}
	
    $('.setdiscount').click(function()
    {
    	var discount = parseInt($('.setdiscount').parent().find('input').val()),
    		finalprice = parseInt($('#final_price').text()),
    		msg = "確定折扣".concat(discount,"?");
    	if(finalprice < discount)
    		alert("折扣金額大於總金額！");
    	else if(discount <= 0)
    		alert("折扣金額錯誤！");
        else if (confirm(msg))
        {
            var order_id = $('#order_id').text();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'setdiscount', orderid: order_id, price: discount},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                        else
                        {
                       	setdiscount(finalprice,discount);
                       	}
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    
    $('.setpaid').click(function()
    {
        if (confirm("確定要設定為已付款?"))
        {
            var order_id = $('#order_id').text();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'setpaid', orderid: order_id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                        else
                        {
                       		$('#payment_status').text("已付款");
                       		$('#payment_date').text(moment().format('YYYY/MM/DD HH:mm:ss'));
                        }
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    
    $('.setship').click(function()
    {
        if (confirm("確定要設定為已出貨?"))
        {
            var order_id = $('#order_id').text(),
            	ship_id = $('#ship_id').text();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'setship', orderid: order_id, shipid: ship_id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                        else
                        {
                        var msg = "已出貨(寄送編號:".concat(ship_id,")");
                       	$('#ship_status').text(msg);
                       	$('#ship_date').text(moment().format('YYYY/MM/DD HH:mm:ss'));
                       	}
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    
    $('.setfinished').click(function()
    {
        if (confirm("確定買家已收到貨?"))
        {
            var order_id = $('#order_id').text(),
            	ship_id = $('#ship_id').text(),
            	parent = $(this).parent();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'setfinished', orderid: order_id, shipid: ship_id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                        else
                        {
                        changeButton(parent);
                        }
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    
    $('.setallfinished').click(function()
    {
        if (confirm("確定完成此筆訂單?"))
        {
            var order_id = $('#order_id').text(),
            	parent = $(this).parent();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'setallfinished', orderid: order_id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                        else
                        {
                        parent.fadeOut('slow');
                        }
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
});