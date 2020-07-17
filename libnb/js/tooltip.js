var cleantips=1;
//tooltip ajax function
$('.toolinfo').trigger('click')

$(document).on({
	click: showTooltip,
	mouseenter: (e) => e.preventDefault(),
	mouseleave: hideTooltip
}, '.toolinfo');

function showTooltip(e)
{
	var vw = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
	if (vw >= 768) { e.stopImmediatePropagation(); }
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
			$.post('libnb/php/tooltip.php?id='+id+'&lan='+lang+'&prop='+prop, {
				html: 'some server response',
				data1: data1
			}, function(data){
				$this.attr('data-original-title', data);
				$this.tooltip('show'); 
				$this.attr('data-load',"2");
				$this.on('shown.bs.tooltip', function()
				{
					var arrowPlacement = document.querySelector('.tooltip').getAttribute('x-placement');
					var arrowElement = document.querySelector('.tooltip .arrow');
					if (arrowPlacement === 'left') { arrowElement.classList.add(arrowPlacement); }
				});
			}); 
			// hide the tooltip in mobile
			if (vw < 768)
			{
				var timer = setTimeout(() => { hideTooltip(e) }, 5000);
				$this.data('timer', timer);
			}
		}
	}
}


function hideTooltip(e) {
	// $this should always be the .toolinfo element in order to dispose of it
	var $this = !e.target.classList.contains('toolinfo')
		? $(e.target.parentNode)
		: $(e.target);

	// Dispose only if tooltip is visible
	if (document.querySelector('.tooltip'))
	{
		$this.tooltip('hide');
		setTimeout(() => { $this.tooltip('dispose'); }, 600);
		$this.attr("data-load", '1');
		$this.removeAttr("aria-describedby");
		cleantips=1;
		
		// Timer is set only in mobile
		if ($this.data('timer')) { clearTimeout($this.data('timer'));  }
	}
}