var cleantips=1;
//tooltip ajax function
	$(function(){ 
    $(document).on('mouseenter', '.toolinfo', function(e){

   if(istime && cleantips)
	{
	cleantips=0;
 	 var $this = $(this);
     var timer = setTimeout(function(){
         data1 = $this.attr("data-original-title");
	   //  console.log(data1+" "+$this.text());
        id=$this.attr("data-toolid");
		f=$this.attr("data-load");
		prop=$this.attr("data-prop");
		
		$.post('libnb/php/tooltip.php?id='+id+'&lan='+lang+'&prop='+prop, {
            html: 'some server response',
            data1: data1
        }, function(data){
			$this.attr('data-original-title', data)
			.tooltip('fixTitle');
			//$this.tooltip('{"show":1500, "hide":300}');
			$this.tooltip({ trigger: 'hover' });
		
			if(f==1)
			{
				$this.tooltip('show');  		
				$this.attr('load',"2");
				//alert($this.attr("load"));
			}
		});    
		 
		}, 430); 
	$this.data('timer', timer); }
}).on('mouseleave', '.toolinfo',function(e) {
	cleantips=1;
     clearTimeout($(this).data('timer')); 
	});
});