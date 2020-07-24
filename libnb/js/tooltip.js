var cleantips=1;
var is_over_tooltip=false;
var active_tooltip=null;

//tooltip ajax function
$('.toolinfo').trigger('click');

$(document).on({
	click: showTooltip,
	mouseenter: (e) => e.preventDefault(),
	mouseleave: (e) => { hideTooltip(e,null,1500); }
}, '.toolinfo');

$(document).on({
	mouseenter: (e) => { is_over_tooltip=true; },
	mouseleave: (e) => { is_over_tooltip=false; hideTooltip(null,active_tooltip,1500);}
}, '.tooltip');

$('body').on('touchstart', function(e){ is_over_tooltip=false; hideTooltip(null,active_tooltip,1500); });

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
				$this.unbind("mouseleave");
				active_tooltip=$this;
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
		timer = setTimeout(() => { hideTooltip(e,null,0) }, set_timer);
		some_el.data('timer', timer);
	}
}


function get_tooltip_el(e)
{
	var to_return=null;
	if(typeof(e)!=="undefined" && e)
	{ to_return = !e.target.classList.contains('toolinfo') ? $(e.target.parentNode) : $(e.target); }
	return to_return;
}

async function hideTooltip(e,$this,delay) {
	// $this should always be the .toolinfo element in order to dispose of it
	
	if($this==null){ var $this = get_tooltip_el(e); }
	if(typeof($this)!=="undefined" && $this && typeof($this.attr('aria-describedby'))!=="undefined")
	{	
		setTimeout(function()
		{
			cleantips=1;
			$this.attr("data-load",'1');
			if(is_over_tooltip==false)
			{
				$this.tooltip('hide');
				active_tooltip=null;
				$this.removeAttr("aria-describedby");
				setTimeout(function(){ $this.tooltip('dispose'); },600);
			}
		},delay);
		
		// Timer is set only in mobile
		if ($this.data('timer')) { clearTimeout($this.data('timer')); }
	}
}