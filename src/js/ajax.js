
function standardAjaxWrapper(varDataType, varType, varUrl, varContentType, varData, varSuccessDiv, varErrorDiv, withLoading = false, withFunction = false, additionalFunction = '')
{

	if(withLoading)	
	{
		$('#'+varSuccessDiv).html('<img src="images/loading.png">');
	}
	
	$.ajax({
	    dataType: varDataType,
	    type: varType,
	    url: varUrl,
	    data: varData,
	    contentType: varContentType,
	    success: function(result){
		   
		   $('#'+varSuccessDiv).html(result);
		   
		   if(withFunction)
		   {
		   	additionalFunction();
		   }
			 
	    },
	    error: function(xhr, textStatus, errorThrown) {
	       	
		    $('#'+varErrorDiv).html(errorThrown);
		    $('#'+varSuccessDiv).html('');
	    }
	});
}


