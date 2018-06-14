jQuery(document).ready(function(){
	var waiting_pay = $('.waiting-pay');
		
	function subOrderCount(parent) {
		var total = parseInt(waiting_pay.text()) - 1;
			waiting_pay.text(total);
	}
	function addOrderCount(parent) {
		var total = parseInt(waiting_pay.text()) + 1;
			waiting_pay.text(total);
	}
	
    $('.order-item__cancel').click(function()
    {
        if (confirm("確定要刪除此項目?"))
        {
            var id = $(this).parent().parent().parent().attr('id');
            var parent = $(this).parent().parent().parent();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'cancelitem', arguments: id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                       parent.fadeOut('slow', function() {$(this).remove();subOrderCount(parent);});
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    $('.order-item__restore').click(function()
    {
        if (confirm("確定要復原此項目?"))
        {
            var id = $(this).parent().parent().parent().attr('id');
            var parent = $(this).parent().parent().parent();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'restoreitem', arguments: id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                       parent.fadeOut('slow', function() {$(this).remove();addOrderCount(parent);});
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    
    $('.product-item__drop').click(function()
    {
        if (confirm("確定要下架此商品?"))
        {
            var id = $(this).parent().parent().parent().attr('id');
            var parent = $(this).parent().parent().parent();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'productdropoff', commodity_id: id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                       parent.fadeOut('slow', function() {$(this).remove();subOrderCount(parent);});
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    $('.product-item__shelf').click(function()
    {
        if (confirm("確定要上架此商品?"))
        {
            var id = $(this).parent().parent().parent().attr('id');
            var parent = $(this).parent().parent().parent();
 
            $.ajax(
            {
                   type: "POST",
                   url: "./functions/json.php",
                   data: {functionname: 'productonshelf', commodity_id: id},
                   dataType: 'json',
                   
                   success: function(data) {
                       if(data['error'] == 1)
                         alert(data['result']);
                       parent.fadeOut('slow', function() {$(this).remove();subOrderCount(parent);});
                       
                   },
                   error: function(data) {
                           	alert(data['error']);
                   },
             });
        }
    });
    
});