var cleantips=1;
//tooltip ajax function
$('.toolinfo').trigger('click');

$(document).on({
	click: showTooltip,
	mouseenter: (e) => e.preventDefault(),
	mouseleave: (e) => { hideTooltip(e,1500); }
}, '.toolinfo');

function showTooltip(e)
{
	var hide_time=4000;
	var vw = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	if (vw >= 768) { e.stopImmediatePropagation(); }
	if(e.type=="click" && cleantips==0){cleantips=1;}

	if(istime && cleantips)
	{
		cleantips=0;
		var $this = $(this);
		data1 = $this.attr("data-original-title");
		id=$this.attr("data-toolid");
		f=$this.attr("data-load");
		prop=$this.attr("data-prop");
	
		if(f==1)
		{
			autoclose_tooltip($this,vw,hide_time);
			$.post('libnb/php/tooltip.php?id='+id+'&lan='+lang+'&prop='+prop, {
				html: 'some server response',
				data1: data1
			}, function(data){
				$this.attr('data-original-title', data);
				if(data!=undefined && data.length>100) { hide_time=data.length*45; autoclose_tooltip($this,vw,hide_time); }
				$this.tooltip('show'); 
				$this.attr('data-load',"2");
				$this.on('shown.bs.tooltip', function()
				{
					var arrowPlacement = document.querySelector('.tooltip').getAttribute('x-placement');
					var arrowElement = document.querySelector('.tooltip .arrow');
					if (arrowPlacement === 'left') { arrowElement.classList.add(arrowPlacement); }
				});
			}); 
		}
	}
	
	function autoclose_tooltip(some_el,vw,hide_time)
	{
		var set_timer=hide_time;
		if(typeof(timer)!=="undefined") { clearTimeout(timer); }
		if (vw < 768){ set_timer=hide_time*1.1; }
		timer = setTimeout(() => { hideTooltip(e,0) }, set_timer);
		some_el.data('timer', timer);
	}
}


function get_tooltip_el(e)
{
	var to_return=null;
	to_return = !e.target.classList.contains('toolinfo') ? $(e.target.parentNode) : $(e.target);
	return to_return;
}

function hideTooltip(e,delay) {
	// $this should always be the .toolinfo element in order to dispose of it
	var $this = get_tooltip_el(e);
	// Dispose only if tooltip is visible
	if(typeof($this.attr('aria-describedby'))!=="undefined")
	{	
		cleantips=1;
		if(parseFloat(delay)>0)
		{
			$this.tooltip({trigger: 'manual'}).tooltip('show');
			sync_sleep(delay);
			$this.tooltip({trigger: 'click'});
		}
		
		$this.tooltip('hide');
		$this.attr("data-load", '1');
		$this.removeAttr("aria-describedby");
		
		// Timer is set only in mobile
		if ($this.data('timer')) { clearTimeout($this.data('timer')); }
	}
}