// Javascript Function ticker for edit form
$(function(){ 
	var arrCHSubs = new Array();
	var maxCH = activeCH.length;
	var chadd;
							
	$("#ch-counter").html(maxCH-activeCH.length);
		
	$(".ch-tab-content p.premium").click(function(){
			
		chadd = $(this).attr("id"); 
			
		if(activeCH.length != maxCH){
			if($(this).children(".selected").length > 0){
				$(this).children(".selected").remove();
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
				$(this).prepend("<img class='selected' src='"+ baseurl + "images/actived.png'/>");
				activeCH.push($(this).attr("id"));
				
				if(jQuery.inArray(chadd, chPrem)<0){
					if(jQuery.inArray(chadd+ " ADD", arrCHSubs) < 0){arrCHSubs.push(chadd + " ADD");}
					else{arrCHSubs.splice(arrCHSubs.indexOf(chadd + " ADD"), 1);}
				}else{
						arrCHSubs.splice(arrCHSubs.indexOf(chadd + " REMOVE"), 1);
					}
			};
		}else{ ;
			if($(this).children(".selected").length > 0){ ;
				$(this).children(".selected").remove();
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