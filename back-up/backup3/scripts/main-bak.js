// JavaScript Document

$(function(){
	//Main Nav
	var userToolWidth = ($('div.subnav').width()-10)*-1;
	$('div.subnav').css('left', userToolWidth);
	
	$('#customer-nav #customer-profile').hover(function(){
		if($(this).children('div.subnav')){
			$(this).children('div.subnav').animate({left:0});
		}
	});
	
	$('#customer-nav #customer-profile').mouseleave(function(){
		if($(this).children('div.subnav')){
			$(this).children('div.subnav').animate({left:userToolWidth});
		}
	});
	
	//Popup action
	$('#tbl-view a').click(function(e){
		e.preventDefault()
		
		var pack = $(this).attr('href');
		$('#frame-content').attr('src', pack);
		
		$('#content-detail').removeClass('hidden');
		
		//console.log($('#frame-content').contents().height());
		//$('#pop-frame').removeClass('hidden');
		//alert($(this).attr('href'));
	});
	
	$('#frame-close').click(function(e){
		e.preventDefault()
		//$('#pop-frame').addClass('hidden');
		$('#content-detail').removeClass('hidden');
		$('#frame-content').attr('src', '');
	});
	
	
	//Popup Tab Channel Function
	var chCategory;
	var offset;
	var lastTab
	
	if($('ul#ch-tab-head').length > 0){
		chCategory = $('ul#ch-tab-head li').length;
		offset =  (chCategory * 100)-800;
		//alert($('#tab-container ul').css('margin-left'));
	}
	
	
	$('.ch-cat-title').click(function(){
		var prevAct = $('#ch-tab-head').find('.active').index();
		var currAct = $(this).index();
				
		$('#ch-tab-head').find('.active').removeClass('active');
		$(this).addClass('active');
		
		$('#ch-content div:eq(' + prevAct + ')').addClass('hide');
		$('#ch-content div:eq(' + currAct + ')').removeClass('hide');
	});
	
	
	
	$('.tab-nav').bind('click', slideTab);
	
	function slideTab(e){
		
		switch(e.currentTarget.id){
			case 'nav-left':
				if($('#tab-container ul').css('margin-left') != '0px'){
					$('.tab-nav').unbind('click');
		
					$('#tab-container ul').animate(
						{marginLeft: '+=' + offset + 'px'}, 200, function(){$('.tab-nav').bind('click', slideTab);}
					);
				}
				break;
			case 'nav-right':
				if($('#tab-container ul').css('margin-left') != '-' + offset + 'px'){
					$('.tab-nav').unbind('click');
					
					$('#tab-container ul').animate(
						{marginLeft: '-=' + offset + 'px'}, 200, function(){$('.tab-nav').bind('click', slideTab);}
					);
				}
				break;
		};	
	}
	
	$('#ch-content').masonry({
	  itemSelector: '.cat-box',
	  columnWidth: 260
	});
});