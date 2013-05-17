// JavaScript Document

$(function(){ 
	var arrCHSubs = new Array();
	var maxCH = activeCH.length;
	var chadd;
							
	$("#ch-counter").html(maxCH-activeCH.length);
	
	$(".cat-box ul li").click(function(){
		
		//$(this).hasClass('selected') ?	$(this).removeClass('selected') : $(this).addClass('selected');
		
		
		chadd = $(this).attr("id");
		
		if(activeCH.length != maxCH){
			if($(this).hasClass('selected')){
				$(this).removeClass('selected');
				
				activeCH.splice(activeCH.indexOf($(this).attr("id")), 1); 
	
				if(jQuery.inArray(chadd, chPrem)>=0){ 
					if(jQuery.inArray(chadd+ " REMOVE", arrCHSubs) < 0){
						arrCHSubs.push(chadd + " REMOVE");
					}else{
						arrCHSubs.splice(arrCHSubs.indexOf(chadd + " REMOVE"), 1);
					}								
				}else{
						arrCHSubs.splice(arrCHSubs.indexOf(chadd + " ADD"), 1);
				}
			}else{
				$(this).addClass('selected');
				
				activeCH.push($(this).attr("id"));
				
				if(jQuery.inArray(chadd, chPrem)<0){
					if(jQuery.inArray(chadd+ " ADD", arrCHSubs) < 0){
						arrCHSubs.push(chadd + " ADD");
					}else{
						arrCHSubs.splice(arrCHSubs.indexOf(chadd + " ADD"), 1);
					}
				}else{
					arrCHSubs.splice(arrCHSubs.indexOf(chadd + " REMOVE"), 1);
				}
			}
		}else{
			if($(this).hasClass('selected')){
				
				$(this).removeClass('selected');
				activeCH.splice(activeCH.indexOf($(this).attr("id")), 1);
	
				if(jQuery.inArray(chadd, chPrem)>=0){
						if(jQuery.inArray(chadd+ " REMOVE", arrCHSubs)< 0){arrCHSubs.push(chadd + " REMOVE");}
					else{arrCHSubs.splice(arrCHSubs.indexOf(chadd + " REMOVE"), 1);}
				}else{
						arrCHSubs.splice(arrCHSubs.indexOf(chadd + " REMOVE"), 1);
				}
			}
		}
		$("#ch-counter").html(maxCH-activeCH.length);
		$('#packdet').attr('value', arrCHSubs);
		$('#chremain').attr('value', maxCH-activeCH.length);
		$('#editdata').attr('value', arrCHSubs.length);
		console.log(arrCHSubs); 
	});

});