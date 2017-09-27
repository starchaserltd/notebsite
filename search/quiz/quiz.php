<script>
Number.isInteger = Number.isInteger || function(value) {
    return typeof value === "number" && 
           isFinite(value) && 
           Math.floor(value) === value;
};

var quiz = {
        0:{
            'question': 'You will use your laptop mainly ...',
            'options': {
                'athome' : { 'txt':['at home','single'], 'img':['athome.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'atwork' : { 'txt':['at work','single'], 'img':['atwork.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'atroad' : { 'txt':['<span style="font-size:13px;">between<br>places</span>','single'], 'img':['atboth.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		1:{
            'question': 'You will keep it mainly (multiple choices):',
            'options': {
                'desk' : { 'txt':['<span style="font-size:13px;">on a desk</span>','multiple'], 'img':['desk.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'bed' : { 'txt':['<span style="font-size:13px;">in bed</span>','multiple'], 'img':['bed.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'lap' : { 'txt':['<span style="font-size:13px;">on your lap</span>','multiple'], 'img':['onlap.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'house' : { 'txt':['<span style="font-size:13px;">around<br>the house</span>','multiple'], 'img':['aroundhouse.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'bag' : { 'txt':['<span style="font-size:12px;">bag or<br>backpack</span>','multiple'], 'img':['backpack.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'display_size' : { 'txt':['<span style="font-size:13px;">advanced<br>size select</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['display.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['display_size'],'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		2:{
            'question': 'Basic uses for it (multiple choices):',
            'options': {
                'internet' : { 'txt':['<span style="font-size:13px;">internet<br>browsing</span>','multiple'], 'img':['internet.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'comm' : { 'txt':['<span style="font-size:13px;">video calls<br>or streaming</span>','multiple'], 'img':['communication.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'writing' : { 'txt':['<span style="font-size:13px;">document<br>writing</span>','multiple'], 'img':['docs.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'calc' : { 'txt':['<span style="font-size:12px;">struggling<br>with<br>spreadsheets</span>','multiple'], 'img':['sheet.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'coding' : { 'txt':['<span style="font-size:12px;">computer<br>coding</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['coding.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'media' : { 'txt':['<span style="font-size:12px;">enjoying<br>movies<br>and music</span>','multiple'], 'img':['movies.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		3:{
			'question': 'Advanced uses for it (multiple choices): ',
            'options': {
                'games' : { 'txt':['<span style="font-size:13px;">playing<br>games</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['games.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['games'],'no':1 },
                'pedit' : { 'txt':['<span style="font-size:13px;">photo<br>editing,<br>illustrations</span>','multiple'], 'img':['photoedit.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['pedit'],'no':1 },
                'vedit' : { 'txt':['<span style="font-size:13px;">video<br>editing</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['videoedit.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['vedit'],'no':1 },
				'3dmodel' : { 'txt':['<span style="font-size:12px;">CAD / 3D modeling</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['3dmodel.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['3dmodel'],'no':1 },
				'sysadmin' : { 'txt':['<span style="font-size:12px;">IT management</span>','multiple'], 'img':['sysadmin.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'otherfeatures' : { 'txt':['<span style="font-size:12px;">other<br>features</span>','multiple'], 'img':['other.svg',''], 'chk':{'on':[0]},'extra':['otherfeatures'],'no':1 }
            },
			'selected': 0,
			'done': 0
        },
		4: {
            'question': 'Minimum desired battery life ...',
            'options': {
                '2hour' : { 'txt':['1 hour','single'], 'img':['clock02.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
                '6hour' : { 'txt':['3 hours','single'], 'img':['clock26.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
                '10hour' : { 'txt':['6 hours','single'], 'img':['clock610.svg',''], 'chk':{'on':[0],'style':['display:none; margin-left: 4px;']}, 'no':1 },
				'12hour' : { 'txt':['more than<br>9 hours','single'], 'img':['clock10.svg',''], 'chk':{'on':[0],'style':['display:none; margin-left: 5px;']}, 'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		5:{
            'question': 'Available budget for your options: ',
            'options': {
                'b500' : { 'txt':['under $500','multiple'], 'img':['budget1.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
                'b750' : { 'txt':['$500 - $750','multiple'], 'img':['budget2.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
                'b1000' : { 'txt':['$750 - $1000','multiple'], 'img':['budget3.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
				'b1500' : { 'txt':['$1000 - $1500','multiple'], 'img':['budget4.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
				'b2000' : { 'txt':['$1500 - $2000','multiple'], 'img':['budget5.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
				'b3000' : { 'txt':['over $2000','multiple'], 'img':['budget6.svg',''], 'chk':{'on':[0],'style':['display:none;']}, 'no':1 },
            },
			'selected': 0,
			'done': 1
        },
		'games':{
			'question': 'Type of games you will play: ',
            'options': {
                '2dgames' : { 'txt':['<span style="font-size:13px;">non-3D games</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['2dgames.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'oldgames' : { 'txt':['<span style="font-size:13px;">older games</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['oldgames.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['oldgames'],'no':1 },
                'mmo' : { 'txt':['<span style="font-size:13px;">multiplayer<br>games</span>','multiple'], 'img':['mmo.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['mmo'],'no':1 },
				'3dgames' : { 'txt':['<span style="font-size:12px;">latest<br>releases</span>','multiple'], 'img':['performance.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['3dgames'],'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'3dmodel':{
            'question': 'CAD / 3D modeling programs used: ',
            'options': {
                'autocad' : { 'txt':['<span style="font-size:13px;">AutoCAD</span>','multiple'], 'img':['autocad.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['autocad'],'no':1 },
                'solidworks' : { 'txt':['<span style="font-size:13px;">SolidWorks</span>','multiple'], 'img':['solidworks.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['solidworks'],'no':1 },
				'3dsmaxmaya' : { 'txt':['<span style="font-size:13px;">3Ds Max<br>or Maya</span>','multiple'], 'img':['3dsmax.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['3dsmaxmaya'],'no':1 },
				'catia' : { 'txt':['<span style="font-size:13px;">CATIA</span>','multiple'], 'img':['catia.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['catia'],'no':1 },
				'rhinoceros' : { 'txt':['<span style="font-size:13px;">Rhinoceros</span>','multiple'], 'img':['rhinoceros.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['rhinoceros'],'no':1 },
				'cadother' : { 'txt':['<span style="font-size:13px;">Other</span>','multiple'], 'img':['cadother.svg',''], 'chk':{'on':[0],'style':['display:none;']},'extra':['cadother'],'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'2dgames':{
			'question': 'Minimal graphics quality: ',
            'options': {
                '2dgameslow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '2dgamesmedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','multiple'], 'img':['medq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '2gameshigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','multiple'], 'img':['highq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'oldgames':{
			'question': 'Minimal graphics quality: ',
            'options': {
                'oldgameslow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'oldgamesmedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'oldgameshigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
		},
		'mmo':{
			'question': 'Minimal graphics quality: ',
            'options': {
                'mmolow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'mmomedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'mmohigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'3dgames':{
			'question': 'Minimal graphic quality: ',
            'options': {
                '3dgameslow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '3dgamesmedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '3dgameshigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'autocad':{
            'question': 'AutoCAD model complexity: ',
            'options': {
                'autocadlight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'autocadmedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'autocadheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
			'solidworks':{
            'question': 'SolidWorks model complexity: ',
            'options': {
                'swlight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'swmedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'swheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
			'catia':{
            'question': 'CATIA model complexity: ',
            'options': {
                'catialight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'catiamedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'catiaheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
			'3dsmaxmaya':{
            'question': '3Ds Max / Maya model complexity: ',
            'options': {
                '3dsmaxlight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '3dsmaxmedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '3dsmaxheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
			'rhinoceros':{
            'question': 'Rhinoceros model complexity: ',
            'options': {
                'rhinolight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'rhinomedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'rhinoheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
			'cadother':{
            'question': 'General CAD/3D model complexity: ',
            'options': {
                'cadolight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'cadomedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'cadoheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'otherfeatures':{
            'question': 'Other special features (multiple choices): ',
            'options': {
                'FHDplus' : { 'txt':['<span style="font-size:13px;">FHD+<br>resolution</span>','multiple'], 'img':['fhdplus.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'convertible' : { 'txt':['<span style="font-size:13px;">tablet<br>mode</span>','multiple'], 'img':['2in1.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'stylus' : { 'txt':['<span style="font-size:12px;">stylus<br>support</span>','multiple'], 'img':['stylus.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'metal' : { 'txt':['<span style="font-size:13px;">durable<br>build materials</span>','multiple'], 'img':['metal.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'shdd' : { 'txt':['<span style="font-size:12px;">secondary<br>HDD</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['shdd.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'odd' : { 'txt':['<span style="font-size:12px;">optical<br>drive</span>','multiple'], 'img':['odd.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'pedit':{
			'question': 'For your photo editing you need: ',
            'options': {
                '60srgb' : { 'txt':['<span style="font-size:13px;">normal<br>colour gamut</span>','single'], 'img':['ngamut.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                '90srgb' : { 'txt':['<span style="font-size:13px;">high<br>colour gamut</span>','single'], 'img':['hgamut.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'vedit':{
			'question': 'Your video editing activities will be: ',
            'options': {
                'lvedit' : { 'txt':['<span style="font-size:13px;">casual<br>editing<span>','single'], 'img':['lvideoedit.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'hvedit' : { 'txt':['<span style="font-size:13px;">heavy<br>editing</span>','single'], 'img':['hvideoedit.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        },
		'display_size':{
            'question': 'Select display size (multiple choices): ',
            'options': {
                'disxsmall' : { 'txt':['<span style="font-size:13px;">10 - 13 inch</span>','multiple'], 'img':['xsmall.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1  },
                'dispsmall' : { 'txt':['<span style="font-size:13px;">13 - 14 inch</span>','multiple'], 'img':['small.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
                'dispmedium' : { 'txt':['<span style="font-size:13px;">15 - 16 inch</span>','multiple'], 'img':['normal.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 },
				'displarge' : { 'txt':['<span style="font-size:13px;">17+ inch</span>','multiple'], 'img':['large.svg',''], 'chk':{'on':[0],'style':['display:none;']},'no':1 }
            },
			'selected': 0,
			'done': 1
        }
	};

var imgadd="search/quiz/res/img/icons/"; var currentp=0; var maxpage=5; var inextra=0; var activequery=0;

function makePage(quizp)
{
	if(quizp<0){quizp=0;}
	currentp=quizp; quiz[quizp]['selected']=0;
	switch(quizp)
	{
		case (maxpage-1):
		{
			if(activequery==0)
			{
				var tosearch="b"; 
				quiz_submit=[]; i=0;
				
				for (var key1 in quiz)
				{
					var opt=quiz[key1]['options'];
					for (var key2 in opt)
					{ var selected=opt[key2]; if ((typeof selected['chk']) != 'undefined' && selected['chk']['on']==1 && selected['no']>0 && key1!=4 && key1!=5){ quiz_submit[i]=key2+"=1"; i++; } }
				}
				prequery(quiz_submit.join("&"), tosearch);
				break;
			}
		}
		case (maxpage):
		{
			if(activequery==0)
			{
				var tosearch="p";
				quiz_submit=[]; i=0;
				
				for (var key1 in quiz)
				{
					var opt=quiz[key1]['options'];
					for (var key2 in opt)
					{ var selected=opt[key2]; if ((typeof selected['chk']) != 'undefined' && selected['chk']['on']==1 && selected['no']>0 && key1!=5){ quiz_submit[i]=key2+"=1"; i++; } }
				}
				prequery(quiz_submit.join("&"), tosearch);
				break;
			}
		}
		default:
		{
			activequery=0;	var elms = document.getElementsByClassName('iconel');
			document.getElementById("mainquiz").style.display="block";
			document.getElementById("quiz_noresults").style.display="none";
			document.getElementById("question").innerHTML=quiz[quizp]['question'];
			for (var i = 0; i < elms.length; i++) { elms[i].style.display="none"; }
			var options=quiz[quizp]['options']; var i=1;
			for (var key in options)
			{
				var obj=options[key];
				if(obj['no']>0)
				{
					document.getElementById("opt"+i).style.display="block";
					document.getElementById("opt"+i+"txt").innerHTML="<br>"+obj['txt'][0];
					if (typeof obj['extra'] != 'undefined')
					{ document.getElementById("opt"+i).setAttribute( "onClick", "makeextraPage('"+obj['extra']+"',"+i+",'"+obj["txt"][1]+"'"+");" ); }
					else
					{ document.getElementById("opt"+i).setAttribute( "onClick", "press('"+key+"','"+i+"','"+obj['txt'][1]+"',0);" ); }
					
					document.getElementById('opt'+i+'img').getElementsByTagName('img')[0].src=imgadd+obj['img'][0];
					document.getElementById('opt'+i+'img').classList.add('hoverblue');
					document.getElementById('opt'+i+'chk').setAttribute('style', obj['chk']['style']);
					if(obj['chk']['on']==1)	{ addcheck("opt"+i,quizp); }
					i++;
				}
			}
			if(i==1) {document.getElementById("quiz_noresults").style.display="block"; }
			if(i-1>3) { document.getElementById("quizr2").style.display="block"; }
			else { document.getElementById("quizr2").style.display="none"; }
			
			break;
		}
	}
	navigation();
}

function makeextraPage(quizp,el)
{
	if(!inextra || (inextra && !(Number.isInteger(el))))
	{
		var closeextratextnav=1;
		if(!inextra) { inextra=quizp; closeextratext="closeextra"; if(document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick").indexOf("closeextra(")>=0) { closeextratextnav=0;  } } else { closeextratext="closeextraextra"; }
		//FADEIN CODE
		document.getElementById("extraopt").classList.add("showel");
		document.getElementById("extraopt").style.display="block";
		document.getElementById("question").innerHTML=quiz[quizp]['question'];
		setTimeout(function() { document.getElementById("extraopt").classList.remove("hidel");},10);
		
		var elms = document.getElementsByClassName('extraiconel'); quiz[quizp]['selected']=0;
		for (var i = 0; i < elms.length; i++) { elms[i].style.display="none"; }
		document.getElementById("doneextra").setAttribute( "onClick", closeextratext+"('"+quizp+"','"+el+"');" );
		document.getElementById("doneextra").style.display="block";
		options=quiz[quizp]['options']; var i=1;
		for (var key in options)
		{
			var obj=options[key];
			if(obj['no']>0)
			{
				document.getElementById("extraopt"+i).style.display="block";
				document.getElementById("extraopt"+i+"txt").innerHTML="<br>"+obj['txt'][0];
				if (typeof obj['extra'] != 'undefined')
				{ document.getElementById("extraopt"+i).setAttribute( "onClick", "makeextraPage('"+obj['extra']+"','"+el+"+"+i+"','"+obj["txt"][1]+"'"+");" ); }
				else
				{ document.getElementById("extraopt"+i).setAttribute( "onClick", "press('"+key+"','"+i+"','"+obj['txt'][1]+"','"+quizp+"');" ); }
				document.getElementById('extraopt'+i+'img').getElementsByTagName('img')[0].src=imgadd+obj['img'][0];
				document.getElementById('extraopt'+i+'img').classList.add('hoverblue');
				document.getElementById('extraopt'+i+'chk').setAttribute('style', obj['chk']['style']);
				if(obj['chk']['on']==1)	{ addcheck("extraopt"+i,quizp); }
				i++;
			}
		}
		if(i<6) { document.getElementById("doneextra").style.marginLeft="110px"; }
		
		//ADJUST NAVIGATION FUNCTIONS
		var navnr=document.getElementsByClassName('nrcircle');
		for (var key=0;key<=maxpage;key++)
		{
			if(navnr[key].getAttribute("onClick")!="")
			{
				var split=el.toString().split("+"); var el2=parseInt(split[split.length-1]); var el3=parseInt(split[split.length-2]);
				if(isNaN(el3)){ navnr[key].setAttribute( "onClick", closeextratext+"('"+quizp+"','"+el2+"'); "+"makePage("+key+");" );	} else { navnr[key].setAttribute( "onClick", closeextratext+"('"+quizp+"','"+el+"'); "+"closeextra('"+inextra+"','"+el3+"'); "+"makePage("+key+");" ); } 
			}
		}
		
		if(closeextratextnav)
		{
			document.getElementsByClassName('glyphicon-arrow-left')[0].setAttribute( "onClick", closeextratext+"('"+quizp+"',"+"'"+el+"'"+"); "+document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick") );
			document.getElementsByClassName('glyphicon-arrow-right')[0].setAttribute( "onClick", closeextratext+"('"+quizp+"',"+"'"+el+"'"+"); "+document.getElementsByClassName('glyphicon-arrow-right')[0].getAttribute( "onClick") );
		}
	}
}

function closeextra(extra,el)
{
	inextra=0; el=parseInt(el); var singlesel=0;
	document.getElementById("extraopt").classList.remove("showel");
	document.getElementById("extraopt").classList.add("hidel");
	var subel=quiz[currentp]['options'];
	setTimeout(function() { document.getElementById("extraopt").style.display="none"; }, 300);
	if(quiz[extra]['selected']>=quiz[extra]['done'])
	{ addcheck("opt"+el,currentp); if(quiz[currentp]['options'][extra]['chk']['on']==1){ quiz[currentp]['selected']--; }  quiz[currentp]['options'][extra]['chk']['on']=1; }
	else
	{ removecheck("opt"+el,el);

	document.getElementById("question").innerHTML=quiz[currentp]['question'];

	for (var key in subel) { if(quiz[currentp]["options"][key]["chk"]["on"]==1 && quiz[currentp]["options"][key]["txt"][1]=="single"){ singlesel=1;} } if(singlesel){  quiz[currentp]['selected']=1;  } else { if(quiz[currentp]['options'][extra]['chk']['on']==1){ quiz[currentp]['selected']--; } }  quiz[currentp]['options'][extra]['chk']['on']=0; }

	var navnr=document.getElementsByClassName('nrcircle');
	for (var key=0;key<=maxpage;key++)
	{
		if(navnr[key].getAttribute("onClick")!="")
		{navnr[key].setAttribute( "onClick", "makePage("+key+");" );}
	}

	document.getElementsByClassName('glyphicon-arrow-left')[0].setAttribute( "onClick", document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick").replace("closeextra('"+extra+"','"+el+"'); ","") );
	document.getElementsByClassName('glyphicon-arrow-right')[0].setAttribute( "onClick", document.getElementsByClassName('glyphicon-arrow-right')[0].getAttribute( "onClick").replace("closeextra('"+extra+"','"+el+"'); ","") );
	navigation();
}


function closeextraextra(extra,el)
{
	var singlesel=0; var subel=quiz[inextra]['options'];
	var split=el.split("+"); var el2=parseInt(split[split.length-1]); var el3=parseInt(split[split.length-2]);
	if(quiz[extra]['selected']>=quiz[extra]['done'])
	{ quiz[inextra]['selected']++; if(("opt"+el2).indexOf("extra")==-1) { navigation(); } changeoptions("opt"+el2, inextra,-1); if(quiz[inextra]['options'][extra]['chk']['on']==1){ quiz[inextra]['selected']--; }  quiz[inextra]['options'][extra]['chk']['on']=1; }
	else
	{ 	setTimeout(function() {	document.getElementById("opt"+el2+"chk").style.display="none"; }, 300);	if(("opt"+el2).indexOf("extra")==-1) { navigation(); } changeoptions("opt"+el2, inextra, 1);
	for (var key in subel) { if(quiz[inextra]["options"][key]["chk"]["on"]==1 && quiz[inextra]["options"][key]["txt"][1]=="single"){ singlesel=1;} } if(singlesel){  quiz[inextra]['selected']=1;  } else { if(quiz[inextra]['options'][extra]['chk']['on']==1){ quiz[inextra]['selected']--; } }  quiz[inextra]['options'][extra]['chk']['on']=0; }
	var prevpage=inextra; inextra=0; makeextraPage(prevpage,el3);
	navnr=document.getElementsByClassName('nrcircle');
	
	for (var key=0;key<=maxpage;key++)
	{
		if(navnr[key].getAttribute("onClick")!="")
		{navnr[key].setAttribute( "onClick", "closeextra('"+inextra+"','"+el3+"'); makePage("+key+");" );}
	}
	document.getElementsByClassName('glyphicon-arrow-left')[0].setAttribute( "onClick", document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick").replace("closeextraextra('"+extra+"','"+el+"'); ","") );
	document.getElementsByClassName('glyphicon-arrow-right')[0].setAttribute( "onClick", document.getElementsByClassName('glyphicon-arrow-right')[0].getAttribute( "onClick").replace("closeextraextra('"+extra+"','"+el+"'); ","") );
}

function press(option,el,type,extra)
{
	if(extra){ var opt="extraopt"; var page=extra;} else { var opt="opt"; var page=currentp;}

	if(!inextra || (inextra && extra!=0))
	{
		el=parseInt(el);
		var elvis=document.getElementById(opt+el+"chk").style.display;
		
		if(elvis=="none" || document.getElementById(opt+el+"chk").classList.contains('hidel'))
		{
			if(type.localeCompare("single")==0)
			{
				for(var i=1;i<=Object.keys(quiz[page]["options"]).length;i++)
				{
					if(i!=el)
					{ 
						if(document.getElementById(opt+i+"chk").style.display=="block" || !(document.getElementById(opt+i+"chk").classList.contains('hidel')))
						{
							var subel=quiz[page]['options'];
							for (var key in subel)
							{
								if(key!=option && quiz[page]['options'][key]['txt'][1]!="multiple")
								{ quiz[page]['options'][key]['chk']['on']=0; }
							}
							if(window[opt+i].getAttribute("onclick").indexOf("multiple")==-1)
							{ removecheck(opt+i,page); quiz[page]['selected']=0; var changeselect=0; }
							else
							{ if(window[opt+i].innerHTML.indexOf("checkmark__check")!=-1) { var changeselect=1;  } }
						}
					}
				}
				if(changeselect) { quiz[page]['selected']=1; } 
			}
			addcheck(opt+el,page);
			quiz[page]['options'][option]['chk']['on']=1;
		}
		else
		{ 
			if((elvis=="block" || !(document.getElementById(opt+el+"chk").classList.contains('hidel')))&&(type.localeCompare("single")!=0))
			{
				quiz[page]['options'][option]['chk']['on']=0;
				quiz[page]['selected']--;
				removecheck(opt+el,page);
			}
			else
			{
				if(inextra && type.localeCompare("single")==0)
				{
					quiz[page]['options'][option]['chk']['on']=0;
					quiz[page]['selected']--;
					removecheck(opt+el,page);
				}
			}
		}
	}
}

function addcheck(el,page)
{
	document.getElementById(el+"chk").style.display="block";
	document.getElementById(el+"chk").classList.remove("hidel");
	document.getElementById(el+"img").classList.remove("hoverblue");
	quiz[page]['selected']++;
	if(el.indexOf("extra")==-1)
	{ navigation(); }
	changeoptions(el, page, -1);
}


function removecheck(el,page)
{
	document.getElementById(el+"chk").classList.add("hidel");
    document.getElementById(el+"img").classList.add("hoverblue");
	setTimeout(function() {
		document.getElementById(el+"chk").style.display="none";
	}, 300);
	if(el.indexOf("extra")==-1)
	{ navigation(); }
	changeoptions(el, page, 1);
}

function changeoptshow(page,el,add){ if(quiz[page]['options'][el]['no']<1 || add<1){ quiz[page]['options'][el]['no']+=add; }  }

function changeoptions(el,page,add)
{ //console.log(el); console.log(page); console.log(add);
	switch(page)
	{ 
		case 0:
		{
			switch(el)
			{
				case "opt1": { changeoptshow(1,"lap",add); break; }
				case "opt2": { changeoptshow(1,"bed",add); changeoptshow(1,"house",add); changeoptshow("3dgames","3dgamesmedium",add); changeoptshow("3dgames","3dgameshigh",add); changeoptshow("mmo","mmohigh",add); break; }
				case "opt3": { break; }
			}
			break;
		}
		case 1:
		{ 
			if((window[el].getAttribute("onclick").indexOf("lap")>-1 || window[el].getAttribute("onclick").indexOf("house")>-1 || window[el].getAttribute("onclick").indexOf("bed")>-1)) { quiz["display_size"]['options']['displarge']['no']+=add; }
			if((window[el].getAttribute("onclick").indexOf("lap")>-1))
			{
				changeoptshow("otherfeatures","shdd",add); changeoptshow("otherfeatures","odd",add);
				changeoptshow("mmo","mmohigh",add);
				changeoptshow("3dgames","3dgameshigh",add);
				changeoptshow("3dgames","3dgamesmedium",add); changeoptshow("3dsmaxmaya","3dsmaxmedium",add); changeoptshow("3dsmaxmaya","3dsmaxheavy",add); changeoptshow("solidworks","swmedium",add); changeoptshow("solidworks","swheavy",add);
				changeoptshow("3dmodel","catia",add); changeoptshow("catia","catialight",add); changeoptshow("catia","catiamedium",add); changeoptshow("catia","catiaheavy",add);
				changeoptshow("rhinoceros","rhinomedium",add); changeoptshow("rhinoceros","rhinoheavy",add);
				changeoptshow("3dmodel","cadother",add); changeoptshow("cadother","cadolight",add); changeoptshow("cadother","cadomedium",add); changeoptshow("cadother","cadoheavy",add); 
				//changeoptshow("oldgames","oldgameshigh",add);
			}
			if((window[el].getAttribute("onclick").indexOf("bed")>-1))
			{
				changeoptshow("3dgames","3dgameshigh",add);
				changeoptshow("rhinoceros","rhinomedium",add); changeoptshow("rhinoceros","rhinoheavy",add); changeoptshow("catia","catiamedium",add); changeoptshow("catia","catiaheavy",add);
				changeoptshow("3dsmaxmaya","3dsmaxmedium",add); changeoptshow("3dsmaxmaya","3dsmaxheavy",add); 
				changeoptshow("solidworks","swmedium",add); changeoptshow("solidworks","swheavy",add);
				changeoptshow("cadother","cadomedium",add); changeoptshow("cadother","cadoheavy",add); 
			}
			break;
		}
		case "display_size":
		{
			switch(el)
			{
				case "extraopt1": 
				{
					changeoptshow(3,"sysadmin",add); changeoptshow("otherfeatures","shdd",add); changeoptshow("otherfeatures","odd",add); changeoptshow("vedit","hvedit",add);
					//changeoptshow(3,"games",add); changeoptshow(3,"3dmodel",add);  
					changeoptshow("oldgames","oldgamesmedium",add); changeoptshow("oldgames","oldgameshigh",add);
					changeoptshow("mmo","mmomedium",add); changeoptshow("mmo","mmohigh",add);
					changeoptshow("games","3dgames",add); changeoptshow("3dgames","3dgameslow",add); changeoptshow("3dgames","3dgamesmedium",add); changeoptshow("3dgames","3dgameshigh",add);
					changeoptshow("autocad","autocadmedium",add); changeoptshow("autocad","autocadheavy",add);
					changeoptshow("3dmodel","solidworks",add); changeoptshow("solidworks","swlight",add); changeoptshow("solidworks","swmedium",add); changeoptshow("solidworks","swheavy",add);
					changeoptshow("3dmodel","3dsmaxmaya",add); changeoptshow("3dsmaxmaya","3dsmaxlight",add); changeoptshow("3dsmaxmaya","3dsmaxmedium",add); changeoptshow("3dsmaxmaya","3dsmaxheavy",add);  
					changeoptshow("3dmodel","catia",add); changeoptshow("catia","catialight",add); changeoptshow("catia","catiamedium",add); changeoptshow("catia","catiaheavy",add);
					changeoptshow("3dmodel","rhinoceros",add); changeoptshow("rhinoceros","rhinolight",add); changeoptshow("rhinoceros","rhinomedium",add); changeoptshow("rhinoceros","rhinoheavy",add);
					changeoptshow("3dmodel","cadother",add); changeoptshow("cadother","cadolight",add); changeoptshow("cadother","cadomedium",add); changeoptshow("cadother","cadoheavy",add);
				}
				case "extraopt2":
				{
					changeoptshow("otherfeatures","shdd",add);
					changeoptshow("3dgames","3dgameshigh",add);
					changeoptshow("solidworks","swheavy",add);
					changeoptshow("3dsmaxmaya","3dsmaxmedium",add); changeoptshow("3dsmaxmaya","3dsmaxheavy",add);
					changeoptshow("catia","catiamedium",add); changeoptshow("catia","catiaheavy",add);
					changeoptshow("rhinoceros","rhinoheavy",add);
					changeoptshow("cadother","cadomedium",add); changeoptshow("cadother","cadoheavy",add);
					if(quiz[0]['options']['athome']['chk']['on']==1 ){ changeoptshow("vedit","hvedit",add); }
				}
			}
			break;
		}
		case "otherfeatures":
		{
			if(window[el].getAttribute("onclick").indexOf("stylus")>-1 || window[el].getAttribute("onclick").indexOf("convertible")>-1)
			{ 
				if(quiz['otherfeatures']['options']['convertible']['chk']['on']==1 || quiz['otherfeatures']['options']['stylus']['chk']['on']==1) { add=0;}
				changeoptshow("otherfeatures","shdd",add); changeoptshow("otherfeatures","odd",add);
				for(i=1;i<=6;i++) { if(window['extraopt'+i].getAttribute("onclick").indexOf("odd")>-1) { if(add!=1) { window['extraopt'+i].style.display="none"; } else { window['extraopt'+i].style.display="block";  } } }
				for(i=1;i<=6;i++) { if(window['extraopt'+i].getAttribute("onclick").indexOf("shdd")>-1) { if(add!=1) { window['extraopt'+i].style.display="none"; } else { window['extraopt'+i].style.display="block";  } } }
			}
			
			if(window[el].getAttribute("onclick").indexOf("odd")>-1 || window[el].getAttribute("onclick").indexOf("shdd")>-1)
			{ 
				if(quiz['otherfeatures']['options']['odd']['chk']['on']==1 || quiz['otherfeatures']['options']['shdd']['chk']['on']==1) { add=0;}
				changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add);
				for(i=1;i<=6;i++) { if(window['extraopt'+i].getAttribute("onclick").indexOf("convertible")>-1) { if(add!=1) { window['extraopt'+i].style.display="none"; } else { window['extraopt'+i].style.display="block";  } } }
				for(i=1;i<=6;i++) { if(window['extraopt'+i].getAttribute("onclick").indexOf("stylus")>-1) { if(add!=1) { window['extraopt'+i].style.display="none"; } else { window['extraopt'+i].style.display="block";  } } }
			}
			
			if(window[el].getAttribute("onclick").indexOf("odd")>-1 && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","FHDplus",add); for(i=1;i<=6;i++) { if(window['extraopt'+i].getAttribute("onclick").indexOf("FHDplus")>-1) { if(add!=1) { window['extraopt'+i].style.display="none"; } else { window['extraopt'+i].style.display="block";  } } } }
			
			if(window[el].getAttribute("onclick").indexOf("FHDplus")>-1 && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","convertible",add); for(i=1;i<=6;i++) { if(window['extraopt'+i].getAttribute("onclick").indexOf("odd")>-1) { if(add!=1) { window['extraopt'+i].style.display="none"; } else { window['extraopt'+i].style.display="block";  } } } }
			break;
		}
		case "3dgames":
		{
			if(quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 )
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;
		}
		case "mmo":
		{
			if((el=="extraopt2" || el=="extraopt3" )&&(quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;
		}
		case "oldgames":
		{
			if((el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;
		}
		case "oldgames":
		{
			if((el=="extraopt2" || el=="extraopt3" )&& (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;
		}
		case "autocad":
		{
			if((el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;	
		}
		case "solidworks":
		{
			if((el=="extraopt1" || el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;	
		}
		case "3dsmaxmaya":
		{
			if((el=="extraopt1" || el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;	
		}
		case "catia":
		{
			if((el=="extraopt1" || el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;	
		}
		case "rhinoceros":
		{
			if((el=="extraopt1" || el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;	
		}
		case "cadother":
		{
			if((el=="extraopt1" || el=="extraopt2" || el=="extraopt3" ) && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;	
		}
		case "videoedit":
		{
			if(el=="hvedit" && (quiz[1]['options']['lap']['chk']['on']==1 || quiz['display_size']['options']['dispsmall']['chk']['on']==1 ))
			{ changeoptshow("otherfeatures","odd",add); changeoptshow("otherfeatures","convertible",add); changeoptshow("otherfeatures","stylus",add); }
			break;
		}
	}
	
	if(quiz[1]['options']['lap']['chk']['on']==1 && (quiz['display_size']['options']['dispmedium']['chk']['on']!=1 && quiz['display_size']['options']['displarge']['chk']['on']!=1 && quiz[0]['options']['atwork']['chk']['on']!=1))
	{	
		changeoptshow("mmo","mmomedium",add); changeoptshow("mmo","mmohigh",add);
		changeoptshow("games","3dgames",add); changeoptshow("3dgames","3dgameslow",add); changeoptshow("3dgames","3dgamesmedium",add); changeoptshow("3dgames","3dgameshigh",add);
	}
}

function prequery(str,type) 
{
	$('#loadingNBquiz').show();
	if (str === "") { result = {}; return; }
	else 
	{
		if (window.XMLHttpRequest)  { var	xmlhttp = new XMLHttpRequest(); }
	
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
			{
				result = JSON.parse(xmlhttp.responseText);
				console.log(result);
				$('#loadingNBquiz').hide();
				activequery=1;
				if(type=="b")
				{
					if(result["batlifemax"]<=7.5){ quiz[4]['options']['12hour']['no']=0; } else { quiz[4]['options']['12hour']['no']=1; }
					if(result["batlifemax"]<=5){ quiz[4]['options']['10hour']['no']=0; } else { quiz[4]['options']['10hour']['no']=1; }
					if(result["batlifemax"]<=2.7){ quiz[4]['options']['6hour']['no']=0; } else { quiz[4]['options']['6hour']['no']=1; }
					if(result["batlifemax"]<=0.9){ quiz[4]['options']['2hour']['no']=0; } else { quiz[4]['options']['2hour']['no']=1; }
				}
				
				if(type=="p")
				{
					if(result["budgetmin"]<=500 && result["budgetmax"]>=1){ quiz[5]['options']['b500']['no']=1; } else { quiz[5]['options']['b500']['no']=0; }
					if(result["budgetmin"]<=750 && result["budgetmax"]>=500){ quiz[5]['options']['b750']['no']=1; } else { quiz[5]['options']['b750']['no']=0; }
					if(result["budgetmin"]<=1000 && result["budgetmax"]>=750){ quiz[5]['options']['b1000']['no']=1; } else { quiz[5]['options']['b1000']['no']=0; }
					if(result["budgetmin"]<=1500 && result["budgetmax"]>=1000){ quiz[5]['options']['b1500']['no']=1; } else { quiz[5]['options']['b1500']['no']=0; }
					if(result["budgetmin"]<=2000 && result["budgetmax"]>=1500){ quiz[5]['options']['b2000']['no']=1; } else { quiz[5]['options']['b2000']['no']=0; }
					if(result["budgetmin"]<=3000 && result["budgetmax"]>=2000){ quiz[5]['options']['b3000']['no']=1; } else { quiz[5]['options']['b3000']['no']=0; }
				}
							
				makePage(currentp);
				return;
			}
		}
		console.log(siteroot+"search/qsearch.php?"+str+"&qtype="+type);
		xmlhttp.open("GET",siteroot+"search/qsearch.php?"+str+"&qtype="+type,true);
		xmlhttp.send();
	}
}


function navigation()
{
	if(quiz[currentp]['selected']>=quiz[currentp]['done'])
	{	 if(currentp<maxpage)
		{ document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="inline"; document.getElementById("quiz_submit_btn").style.display="none"; }
		else
		{ if(currentp==maxpage){ document.getElementById("quiz_submit_btn").style.display="block"; } document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="none";	} 
	}
	else
	{ document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="none";	document.getElementById("quiz_submit_btn").style.display="none"; }
	
	if(currentp<=0)
	{ document.getElementsByClassName('glyphicon-arrow-left')[0].style.display="none";}
	else
	{ document.getElementsByClassName('glyphicon-arrow-left')[0].style.display="inline"; }

	
	var navnr=document.getElementsByClassName('nrcircle'); var lastactive=-1; var quizfinal=1;
	for (var key=0;key<=maxpage;key++)
	{
		if(quiz[key]['selected']>=quiz[key]['done'])
		{	
			if(lastactive==(key-1) && quizfinal)
			{
				navnr[key].setAttribute( "onClick", "makePage("+key+");" );
				navnr[key].classList.add("nrcircleactive");
				lastactive=key;
			}
			if(quizfinal) {lastactive=key;}
		}
		else
		{ //navnr[key].classList.remove("nrcircleactive");
			quizfinal=0;
		}
		
		if(key>lastactive && !quizfinal)
		{
			navnr[key].removeAttribute( "onClick", "makePage("+key+");" );
			navnr[key].classList.remove("nrcircleactive");
		}
	}
	if(lastactive>=maxpage)	{ lastactive--;}
	navnr[lastactive+1].classList.add("nrcircleactive");
	navnr[lastactive+1].setAttribute( "onClick", "makePage("+(lastactive+1)+");" );
}


function submit_the_quiz()
{
	var quiz_submit=[]; var i=0;
	for (var key1 in quiz)
	{
		var opt=quiz[key1]['options'];
		for (var key2 in opt)
		{
			var selected=opt[key2];
			if ((typeof selected['chk']) != 'undefined' && selected['chk']['on']==1 && selected['no']>0)
			{ quiz_submit[i]=key2+"=1"; i++; }
		}
	}
	location.href=siteroot+"?search/search.php?quizsearch=1&"+quiz_submit.join("&");
	return "Quiz submission!";
}

function quiz_init() { makePage(0); } quiz_init();

</script>

<link rel="stylesheet" href="search/quiz/quiz.css" type="text/css"/>
<div class="quiz_container">
	<div style="width:100%; height:35px; text-align:center; display: inline-block; padding-top:5px">
		<span id="question" style="font-family: 'arial'; font-size:20px;font-weight: bold;"></span>
	</div>	
	<div class="col-md-12 loadingdivquiz" id="loadingNBquiz" style="display:none" >
		<div class="loadingdivsec loadingQuiz" >
			<div id="loadingNoteB_1" class="loadingNoteB"></div>
			<div id="loadingNoteB_2" class="loadingNoteB"></div>
			<div id="loadingNoteB_3" class="loadingNoteB"></div>
			<div id="loadingNoteB_4" class="loadingNoteB"></div>
			<div id="loadingNoteB_5" class="loadingNoteB"></div>
			<div id="loadingNoteB_6" class="loadingNoteB"></div>
			<div id="loadingNoteB_7" class="loadingNoteB"></div>
			<div id="loadingNoteB_8" class="loadingNoteB"></div>
		</div>
	</div>
	<div class="mainquiz" id="mainquiz">
		<div class="row qtable" align="center" id="icontable">
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="quizr1" style="display: block;">
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt1"  onclick="">
						<div id="opt1img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option1">
						<svg id="opt1chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>											
						<span class="icontext" id="opt1txt"><br></span>
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt2"  onclick="">
						<div id="opt2img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option2">
						<svg id="opt2chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>
						<span class="icontext"  id="opt2txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt3" style="" onclick="">
						<div id="opt3img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option3">
						<svg id="opt3chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>
						<span class="icontext" id="opt3txt"><br></span>						
					</div>
				</div>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="quizr2" style="display: none;">
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt4"  onclick="">
						<div id="opt4img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option4">
						<svg id="opt4chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>
						<span class="icontext"  id="opt4txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt5" onclick="">
						<div id="opt5img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option5">
						<svg id="opt5chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>
						<span class="icontext" id="opt5txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt6" style="" onclick="">
						<div id="opt6img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option6">
						<svg id="opt6chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>
						<span class="icontext" id="opt6txt"><br></span>						
					</div>
				</div>
			</div>
		</div>
		<div id="quiz_noresults" style="display: block;"><span>Sorry, but there are no laptops with your selected features!</span></div>
		<div id="extraopt" class="shadow hidel">
		<div class="row" align="center" id="icontable">
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="display: block; border-top:8px solid; border-color: transparent;">
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt1"  onclick="">
						<div id="extraopt1img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption1">
						<svg id="extraopt1chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
					</div>
						<span class="icontext" id="extraopt1txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt2"  onclick="">
						<div id="extraopt2img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption2"><svg id="extraopt2chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
						</div>						
						<span class="icontext"  id="extraopt2txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt3" style="" onclick="">
						<div id="extraopt3img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption3"><svg id="extraopt3chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
						</div>
						<span class="icontext" id="extraopt3txt"><br></span>						
					</div>
				</div>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="display: block;">
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt4"  onclick="">
						<div id="extraopt4img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption4"><svg id="extraopt4chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
						</div>
						<span class="icontext"  id="extraopt4txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt5"  onclick="">
						<div id="extraopt5img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption5"><svg id="extraopt5chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
						</div>
						<span class="icontext" id="extraopt5txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt6"  onclick="">
						<div id="extraopt6img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption6"><svg id="extraopt6chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
						<img class="img-responsive ieCheckmark" src="search/quiz/res/img/icons/checkmark.svg" alt="checkmark"/>
						</div>
						<span class="icontext" id="extraopt6txt"><br></span>						
					</div>
				</div>
			</div>
		</div>
		<div class="column">
			<div class="extraiconel" id="doneextra" style="display: block; margin-bottom:21px;" onclick="">
				<span id="doneextraimg" class="arow_back"><!-- <img class="img-responsive iconimg" src="search/quiz/res/img/icons/back.svg" alt="DoneExtra"> -->X</span><span class="icontext arow_done" id="doneextratxt">DONE</span>
			</div>
		</div>
	</div>
	<div class="footer_quiz">
		<span class="glyphicon glyphicon-arrow-left arrows1" onclick="makePage(currentp-1);"></span>
		<span class="nrcircle nrcircleactive"></span><span class="nrcircle"></span><span class="nrcircle"></span><span class="nrcircle"></span><span class="nrcircle"></span></span><span class="nrcircle"></span>
		<span class="glyphicon glyphicon-arrow-right arrows #quiza" style="display:none;" onclick="makePage(currentp+1);">			
			<span class="next-text">
				<p><span>Next</span>
				<span class="hidden-xs visible-sm visible-md visible-lg">Question</span>
				</p>	
				<span class="nextTextTail"></span>		
			</span>
		</span>
		<span class="submit_quiz" style="display:none;" id="quiz_submit_btn" onclick="submit_the_quiz();">			
			<span>
				<p>Find your
				laptop!
				</p>			
			</span>
		</span>
	</div>
</div>