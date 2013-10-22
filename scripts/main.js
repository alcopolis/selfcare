// JavaScript Document

$(function(){
	
	if($('#welcome').length > 0){
		$('#user-menu').addClass('hide');	
		$('.page').css('margin-top', '0');
	}else{
		$('#user-menu').removeClass('hide');
	}
		
	//Popup action
	$('#tbl-view a').click(function(e){
		e.preventDefault()
		
		var pack = $(this).attr('href');
		$('#frame-content').attr('src', pack);
		
		$('#content-detail').removeClass('hide');
		
		//$('#frame-content').css('height', 'auto');
		
		//console.log($('#frame-content').contents().height());
		//$('#pop-frame').removeClass('hidden');
		//alert($(this).attr('href'));
	});
	
	
	//Masonry
	if($('#ch-content')){
		$('#ch-content').masonry({
		  itemSelector: '.cat-box',
		  columnWidth: 260
		});
	}
	
	
	//Modify channel save button
	//if($('#btn-save').length > 0){
		$('#btn-save').click(function(){
			console.log('asdfasdfasd');
			$('#notif').css('margin-top','60px');
		});
	//}
});



/*function setLayout(){
	var winW, winH;
	
	winW = $(window).innerWidth();
	winH = $(window).innerHeight();	
		
	if($('div#content').height() < winH-192){
		$('#content').height(winH-236);
	}else{
		$('#content').css('height', 'auto');	
	}
	
	if($('body#home-login')){
		var t, l;
		
		t = (winH - $('#login').height() - 410)/2;
		l = (winW - $('#login').width())/2;
		$('#login').css({'top':t, 'left':l});
	}
	
}*/