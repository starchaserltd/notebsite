var cleantips = 1;
var allshow = 0;

$('#addcompare').click(function(e)
 {
  e.preventDefault();
  e.stopPropagation();
  addcompare();
 });
 
$(".toggler").click(function(e){
	e.preventDefault();
	if($(this).attr('data-hide')=="all")
	{
		if(allshow)
		{
			$('.hide'+$(this).attr('data-hide')).slideUp(500);
			$this=$('.toggler');
			allshow=0; $this.text("Show more details"); $(this).text("Show all details");
		}
		else
		{  $('.hide'+$(this).attr('data-hide')).slideDown(500);	$this=$('.toggler'); allshow=1; $this.text("Show less details"); $(this).text("Hide all details"); }	
	}
	else
	{
        $('.hide'+$(this).attr('data-hide')).slideToggle(500);
		$this=$(this);
		if($this.text().toLowerCase().indexOf("more") > -1)
		{ $this.text("Show less details"); }
		else
		{ 
			if($this.text().toLowerCase().indexOf("less") > -1)
			{ $this.text("Show more details"); }
		}
	}
});
	
$(function() {
	$('.pics').on('click', function() 
	{
		$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
		$('#enlargeImageModal').modal('show');
	});
});

/*DISQUE CODE*/
/**
* RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
* LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
*/

(function() { // DON'T EDIT BELOW THIS LINE

	if(window.disqusloaded)
	{
		var d = document; var s = d.createElement('script');
		disqusloaded=0;
		s.src = '//notebrointexim.disqus.com/embed.js';

		s.setAttribute('data-timestamp', +new Date());
		(d.head || d.body).appendChild(s);
	}
	else
	{
		DISQUS.reset({
			reload: true,
			config: window.disqus_config  
		});
	}
})();

