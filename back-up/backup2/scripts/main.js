// JavaScript Document

$(function(){
	var today = new Date();
	var currTime = today.getHours();
	var bgURL;
	var dTime;
	var dColor;
	
	
	

	// TimeAmbience based on time function	
	/*
	if(currTime < 5){
		dTime = 'malam';
		dColor = '#11345c';
	}else if(currTime >= 6 && currTime < 12){
		dTime = 'pagi';
		dColor = '#92d8f5';
	}else if(currTime >= 12 && currTime < 18){
		dTime = 'siang';
		dColor = '#ffe9b7';
	}else if(currTime > 17){
		dTime = 'malam';
		dColor = '#11345c';
	};
	
	setAmbienceBG();
	
	function setAmbienceBG(){
		winW = window.innerWidth;
		
		//alert($('#content').innerWidth());		
			
		if ($('#corporate-content').length > 0){
			$('#corporate-content').removeClass(dTime).addClass('corp');
		}else{
			$('#content').removeClass('default');
			$('#content').removeClass('corp');
			$('#content').addClass(dTime);
		}
		
		if(winW == 1920){
			strVal = '0 0';
		}else{
			var bgOffset = -(1920 - window.innerWidth)/2;
			bgOffset = Math.round(bgOffset);
		
			strVal = bgOffset.toString() + 'px 0';
		}
		
		$('#content').css('background-position', strVal );
	};
	
	window.onresize = function (){
		setAmbienceBG();
	};
	*/
	
	//content equal height
	
	var sideH = $('#side').height();
	var contentBodyH = $('#content-wrap').innerHeight();
	
	console.log(sideH + ' : ' + contentBodyH);
	
	if(sideH < contentBodyH){
		$('#side').css('height', contentBodyH);
	};
	

/*	//Profile Password Function
	$('#pass-change').click(function(e){
		e.preventDefault();
		$('#pass-form').removeClass('hidden');
		$('#side').css('height', $('#content-wrap').innerHeight());
	});
*/	
	
	//Popup action
	$('#tbl-view a').click(function(e){
		e.preventDefault()
		
		var pack = $(this).attr('href');
		$('#frame-content').attr('src', pack);
		$('#pop-frame').removeClass('hidden');
		//alert($(this).attr('href'));
	});
	
	$('#frame-close').click(function(e){
		e.preventDefault()
		$('#pop-frame').addClass('hidden');
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