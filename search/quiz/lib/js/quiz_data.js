var imgadd="search/quiz/res/img/icons/"; var currentp=0; var maxpage=5; var inextra=0; var activequery=0; var inmaking=0;

var quiz = {
        0:{
            'question': 'You will use your laptop mainly for:<br>(multiple choices)',
            'options': {
                'casual' : { 'txt':['internet<br>and office','multiple'], 'img':['internet2.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'content' : { 'txt':['photo and<br>video editing','mltiple'], 'img':['pvedit.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'coding' : { 'txt':['coding and<br>it management','multiple'], 'img':['itstuff.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'business' : { 'txt':['business','multiple'], 'img':['briefcase.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'gaming' : { 'txt':['gaming','multiple'], 'img':['gaming.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'cad3d' : { 'txt':['CAD/3D<br>content','multiple'], 'img':['cad3d.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        1:{
            'question': 'You will keep it mainly:<br>(multiple choices)',
            'options': {
                'desk' : { 'txt':['on a desk','multiple'], 'img':['desk.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'lap' : { 'txt':['on the go','multiple'], 'img':['onlap.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'bed' : { 'txt':['in bed','multiple'], 'img':['bed.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'house' : { 'txt':['around the<br>house or office','multiple'], 'img':['aroundhouse.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'bag' : { 'txt':['in a bag or<br>backpack','multiple'], 'img':['backpack.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'display_size' : { 'txt':['or directly<br>select its size','multiple'], 'img':['display.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['display_size'],'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        2:{
            'question': 'Give more details on your choices:<br>(optional,multiple choices)',
            'options': {
				'office' : { 'txt':['office<br>activities','multiple'], 'img':['office.svg',''],'chk':{'on':0,'style':['display:none;']},'extra':['office'],'no':1 },
                'displayq' : { 'txt':['display<br>quality','multiple'], 'img':['displayopt.svg',''],'chk':{'on':0,'style':['display:none;']},'extra':['displayq'],'no':1 },
				'vms' : { 'txt':['virtual machine<br>usage','multiple'], 'img':['vms.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['vms'],'no':1 },
				'games' : { 'txt':['gaming<br>quality','multiple'], 'img':['games.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['games'],'no':1 },
                'vedit' : { 'txt':['video editing<br>activity','multiple'], 'img':['videoedit.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['vedit'],'no':1 },
                '3dmodel' : { 'txt':['CAD / 3D<br>modeling','multiple'], 'img':['3dmodel.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['3dmodel'],'no':1 }
            },
            'selected': 0,
            'done': 0
        },
        3:{
            'question': 'Other uses and features:<br>(multiple choices)',
            'options': {
				'comm' : { 'txt':['video calls','multiple'], 'img':['communication.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'media' : { 'txt':['enjoying<br>movies<br>and music','multiple'], 'img':['movies.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'convertible' : { 'txt':['tablet<br>mode','multiple'], 'img':['2in1.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['convertible'],'no':1 },
				'metal' : { 'txt':['durable<br>build materials','multiple'], 'img':['metal.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'otherfeatures' : { 'txt':['<span style="font-size:12px;">other<br>features</span>','multiple'], 'img':['other.svg',''], 'chk':{'on':0},'extra':['otherfeatures'],'no':1 }
            },
            'selected': 0,
            'done': 0
        },
        4: {
            'question': 'Minimum desired battery life ...',
            'options': {
                '2hour' : { 'txt':['1 hour','single'], 'img':['clock02.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                '6hour' : { 'txt':['3 hours','single'], 'img':['clock26.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                '10hour' : { 'txt':['6 hours','single'], 'img':['clock610.svg',''], 'chk':{'on':0,'style':['display:none; margin-left: 4px;']}, 'no':1 },
                '12hour' : { 'txt':['more than<br>9 hours','single'], 'img':['clock10.svg',''], 'chk':{'on':0,'style':['display:none; margin-left: 5px;']}, 'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        5:{
            'question': 'Available budget for your options (multiple choices): ',
            'options': {
                'b500' : { 'txt':['under $500','multiple'], 'img':['budget1.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                'b750' : { 'txt':['$500 - $750','multiple'], 'img':['budget2.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                'b1000' : { 'txt':['$750 - $1000','multiple'], 'img':['budget3.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                'b1500' : { 'txt':['$1000 - $1500','multiple'], 'img':['budget4.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                'b2000' : { 'txt':['$1500 - $2000','multiple'], 'img':['budget5.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
                'b3000' : { 'txt':['over $2000','multiple'], 'img':['budget6.svg',''], 'chk':{'on':0,'style':['display:none;']}, 'no':1 },
            },
            'selected': 0,
            'done': 1
        },
        'games':{
            'question': 'Type of games you will play (multiple choices): ',
            'options': {
                '2dgames' : { 'txt':['<span style="font-size:13px;">non-3D games</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['2dgames.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'oldgames' : { 'txt':['<span style="font-size:13px;">older games</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['oldgames.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['oldgames'],'no':1 },
                'mmo' : { 'txt':['<span style="font-size:13px;">multiplayer<br>games</span>','multiple'], 'img':['mmo.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['mmo'],'no':1 },
                '3dgames' : { 'txt':['<span style="font-size:12px;">latest<br>releases</span>','multiple'], 'img':['performance.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['3dgames'],'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        '3dmodel':{
            'question': 'CAD / 3D modeling programs used (multiple choices): ',
            'options': {
                'autocad' : { 'txt':['<span style="font-size:13px;">AutoCAD</span>','multiple'], 'img':['autocad.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['autocad'],'no':1 },
                'solidworks' : { 'txt':['<span style="font-size:13px;">SolidWorks</span>','multiple'], 'img':['solidworks.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['solidworks'],'no':1 },
                '3dsmaxmaya' : { 'txt':['<span style="font-size:13px;">3Ds Max<br>or Maya</span>','multiple'], 'img':['3dsmax.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['3dsmaxmaya'],'no':1 },
                'catia' : { 'txt':['<span style="font-size:13px;">CATIA</span>','multiple'], 'img':['catia.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['catia'],'no':1 },
                'rhinoceros' : { 'txt':['<span style="font-size:13px;">Rhinoceros</span>','multiple'], 'img':['rhinoceros.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['rhinoceros'],'no':1 },
                'cadother' : { 'txt':['<span style="font-size:13px;">Other</span>','multiple'], 'img':['cadother.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['cadother'],'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        '2dgames':{
            'question': 'Minimal graphics quality: ',
            'options': {
                '2dgameslow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '2dgamesmedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '2dgameshigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'oldgames':{
            'question': 'Minimal graphics quality: ',
            'options': {
                'oldgameslow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'oldgamesmedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'oldgameshigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'mmo':{
            'question': 'Minimal graphics quality: ',
            'options': {
                'mmolow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'mmomedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'mmohigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        '3dgames':{
            'question': 'Minimal graphic quality: ',
            'options': {
                '3dgameslow' : { 'txt':['<span style="font-size:13px;">low<br>quality</span>','single'], 'img':['lowq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '3dgamesmedium' : { 'txt':['<span style="font-size:13px;">normal<br>quality</span>','single'], 'img':['medq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '3dgameshigh' : { 'txt':['<span style="font-size:13px;">high<br>quality</span>','single'], 'img':['highq.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'autocad':{
            'question': 'AutoCAD model complexity: ',
            'options': {
                'autocadlight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'autocadmedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'autocadheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
            'solidworks':{
            'question': 'SolidWorks model complexity: ',
            'options': {
                'swlight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'swmedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'swheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
            'catia':{
            'question': 'CATIA model complexity: ',
            'options': {
                'catialight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'catiamedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'catiaheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
            '3dsmaxmaya':{
            'question': '3Ds Max / Maya model complexity: ',
            'options': {
                '3dsmaxlight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '3dsmaxmedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '3dsmaxheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
            'rhinoceros':{
            'question': 'Rhinoceros model complexity: ',
            'options': {
                'rhinolight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'rhinomedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'rhinoheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
            'cadother':{
            'question': 'General CAD/3D model complexity: ',
            'options': {
                'cadolight' : { 'txt':['<span style="font-size:13px;">simple<br>models</span>','single'], 'img':['cadlight.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'cadomedium' : { 'txt':['<span style="font-size:13px;">average<br>models</span>','single'], 'img':['cadmedium.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'cadoheavy' : { 'txt':['<span style="font-size:13px;">complex<br>models</span>','single'], 'img':['cadheavy.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'otherfeatures':{
            'question': 'Other special features (multiple choices): ',
            'options': {
                'shdd' : { 'txt':['<span style="font-size:12px;">secondary<br>HDD</span><span style="color: #ffffff"><br>-</span>','multiple'], 'img':['shdd.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'odd' : { 'txt':['<span style="font-size:12px;">optical<br>drive</span>','multiple'], 'img':['odd.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'srgb':{
            'question': 'Color reproduction quality: ',
            'options': {
                '60srgb' : { 'txt':['<span style="font-size:13px;">normal<br>colour gamut</span>','single'], 'img':['ngamut.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                '90srgb' : { 'txt':['<span style="font-size:13px;">high<br>colour gamut</span>','single'], 'img':['hgamut.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'vedit':{
            'question': 'Your video editing activities will be: ',
            'options': {
                'lvedit' : { 'txt':['<span style="font-size:13px;">casual<br>editing<span>','single'], 'img':['lvideoedit.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'hvedit' : { 'txt':['<span style="font-size:13px;">heavy<br>editing</span>','single'], 'img':['hvideoedit.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
        'display_size':{
            'question': 'Select display size:<br>(multiple choices)',
            'options': {
                'dispxsmall' : { 'txt':['<span style="font-size:13px;">10 - 13 inch</span>','multiple'], 'img':['xsmall.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1  },
                'dispsmall' : { 'txt':['<span style="font-size:13px;">13 - 14 inch</span>','multiple'], 'img':['small.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'dispmedium' : { 'txt':['<span style="font-size:13px;">14 - 16 inch</span>','multiple'], 'img':['normal.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'displarge' : { 'txt':['<span style="font-size:13px;">17+ inch</span>','multiple'], 'img':['large.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
		'displayq':{
            'question': 'Dispay quality and features:<br>(multiple choices)',
            'options': {
                'FHD' : { 'txt':['<span style="font-size:13px;">normal<br>resolution</span>','multiple'], 'img':['fhd.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'FHDplus' : { 'txt':['<span style="font-size:13px;">high<br>resolution</span>','multiple'], 'img':['fhdplus.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'srgb' : { 'txt':['<span style="font-size:13px;">color<br>quality</span>','multiple'], 'img':['srgb.svg',''], 'chk':{'on':0,'style':['display:none;']},'extra':['srgb'],'no':1 }
            },
            'selected': 0,
            'done': 1
        },
		'office':{
            'question': 'Some office activities:<br>(multiple choices)',
            'options': {
                'relax' : { 'txt':['<span style="font-size:13px;">normal<br>office work</span>','multiple'], 'img':['relax.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1  },
                'calc' : { 'txt':['<span style="font-size:13px;">managing large<br>spreadsheets</span>','multiple'], 'img':['sheet.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'heavybrowsing' : { 'txt':['<span style="font-size:13px;">heavy<br>browsing</span>','multiple'], 'img':['heavybrowse.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        },
		'vms':{
            'question': 'Number of active virtual machines:<br>',
            'options': {
                'vmsmall' : { 'txt':['<span style="font-size:13px;">1 - 2 active<br>VMs</span>','single'], 'img':['vms1.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1  },
                'vmmedium' : { 'txt':['<span style="font-size:13px;">2 - 4 active<br>VMs</span>','single'], 'img':['vms2.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
                'vmheavy' : { 'txt':['<span style="font-size:13px;">4+ active<br>VMs</span>','single'], 'img':['vms3.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 },
				'vmnone' : { 'txt':['<span style="font-size:13px;">no active<br>VMs</span>','single'], 'img':['vms0.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1  }
            },
            'selected': 0,
            'done': 1
        },
		'convertible':{
            'question': 'Touchscreen requirements:<br>',
            'options': {
                'ntouch' : { 'txt':['<span style="font-size:13px;">normal<br>touchscreen</span>','single'], 'img':['ntouch.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1  },
                'stylus' : { 'txt':['<span style="font-size:12px;">stylus<br>support</span>','single'], 'img':['stylus.svg',''], 'chk':{'on':0,'style':['display:none;']},'no':1 }
            },
            'selected': 0,
            'done': 1
        }
    };


var compatibility={
	'relax' : { 'nogo':[['all']], 'go':[['casual','permissive'],['business','permissive'],['coding','permissive']]},
	'calc' : { 'nogo':[['all']], 'go':[['casual','permissive'],['business','permissive']]},
	'heavybrowsing' : { 'nogo':[['all']], 'go':[['casual','permissive'],['business','permissive']]},
	'60srgb' : { 'nogo':[['all']], 'go':[['gaming','permissive'],['cad3d','permissive'],['content','permissive']]},
	'90srgb' : { 'nogo':[['all']], 'go':[['gaming','permissive'],['cad3d','permissive'],['content','permissive']]},
	'vmnone' : { 'nogo':[['all']], 'go':[['coding','permissive']]},
	'vmsmall' : { 'nogo':[['all']], 'go':[['coding','permissive']]},
	'vmmedium' : { 'nogo':[['all']], 'go':[['coding','permissive']]},
	'vmheavy' : { 'nogo':[['all'],['dispxsmall']], 'go':[['dispsmall','coding'],['displarge','coding'],['dispmedium','coding'],['coding','permissive']]},
	'lvedit' : { 'nogo':[['all'],['odd','business'],['stylus','business'],['ntouch','business'],['dispxsmall']], 'go':[['dispsmall','content'],['displarge','content'],['dispmedium','content'],['content','permissive']]},
	'hvedit' : { 'nogo':[['all'],['odd','business'],['stylus','business'],['ntouch','business'],['dispxsmall']], 'go':[['dispsmall','content'],['displarge','content'],['dispmedium','content'],['content','permissive']]},
	'2dgameslow' : { 'nogo':[['all']], 'go':[['gaming','permissive']]},
	'2dgamesmedium' : { 'nogo':[['all']], 'go':[['gaming','permissive']]},
	'2dgameshigh' : { 'nogo':[['all']], 'go':[['gaming','permissive']]},
	'oldgameslow' : { 'nogo':[['all']], 'go':[['gaming','permissive']]},
	'oldgamesmedium' : { 'nogo':[['all'],['dispxsmall']], 'go':[['dispsmall','gaming'],['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'oldgameshigh' : { 'nogo':[['all'],['dispxsmall']], 'go':[['dispsmall','gaming'],['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'mmolow' : { 'nogo':[['all']], 'go':[['gaming','permissive']]},
	'mmomedium' : { 'nogo':[['all'],['dispxsmall']], 'go':[['dispsmall','gaming'],['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'mmohigh' : { 'nogo':[['all'],['dispxsmall'],['ntouch'],['stylus']], 'go':[['dispsmall','gaming'],['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'3dgameslow' : { 'nogo':[['all'],['dispxsmall']], 'go':[['dispsmall','gaming'],['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'3dgamesmedium' : { 'nogo':[['all'],['dispxsmall'],['ntouch'],['stylus']], 'go':[['dispsmall','gaming'],['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'3dgameshigh' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['ntouch'],['stylus']], 'go':[['displarge','gaming'],['dispmedium','gaming'],['gaming','permissive']]},
	'autocadlight' : { 'nogo':[['all']], 'go':[['cad3d','permissive']]},
	'autocadmedium' : { 'nogo':[['all'],['dispxsmall'],['dispsmall','business']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'autocadheavy' : { 'nogo':[['all'],['dispxsmall'],['dispsmall','business'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'swlight' : { 'nogo':[['all'],['dispxsmall'],['dispsmall','business']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','!business','cad3d'],['cad3d','permissive']]},
	'swmedium' : { 'nogo':[['all'],['dispxsmall'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'swheavy' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'3dsmaxlight' : { 'nogo':[['all'],['dispxsmall']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'3dsmaxmedium' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'3dsmaxheavy' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['bed'],['lap'],['house'],['bag'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'catialight' : { 'nogo':[['all'],['dispxsmall'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'catiamedium' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'catiaheavy' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['bed'],['lap'],['house'],['bag'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'rhinolight' : { 'nogo':[['all'],['dispxsmall']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'rhinomedium' : { 'nogo':[['all'],['dispxsmall'],['dispsmall','business'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','!business','cad3d'],['cad3d','permissive']]},
	'rhinoheavy' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['bed'],['lap'],['house'],['bag'],['ntouch'],['stylus']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'cadolight' : { 'nogo':[['all'],['dispxsmall']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['dispsmall','cad3d'],['cad3d','permissive']]},
	'cadomedium' : { 'nogo':[['all'],['dispxsmall'],['dispsmall']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'cadoheavy' : { 'nogo':[['all'],['dispxsmall'],['dispsmall'],['bed'],['lap'],['house'],['bag']], 'go':[['displarge','cad3d'],['dispmedium','cad3d'],['cad3d','permissive']]},
	'stylus' : { 'nogo':[['mmohigh'],['3dgamesmedium'],['3dgameshigh'],['autocadheavy'],['swmedium'],['swheavy'],['3dsmaxmedium'],['3dsmaxheavy'],['catialight'],['catiamedium'],['catiaheavy'],['rhinomedium'],['rhinoheavy'],['cadolight'],['cadomedium'],['cadoheavy'],['odd'],['hvedit','business']], 'go':[['']]},
	'ntouch' : { 'nogo':[['mmohigh'],['3dgamesmedium'],['3dgameshigh'],['autocadheavy'],['swmedium'],['swheavy'],['3dsmaxmedium'],['3dsmaxheavy'],['catialight'],['catiamedium'],['catiaheavy'],['rhinomedium'],['rhinoheavy'],['cadolight'],['cadomedium'],['cadoheavy'],['odd'],['hvedit','business']], 'go':[['']]},
	'odd' : { 'nogo':[['all'],['swheavy'],['stylus'],['ntouch'],['vmheavy'],['hvedit','business'],['FHDplus','business']], 'go':[['dispsmall','!gaming','!cad3d','!vmheavy','!hvedit'],['dispmedium','permissive'],['displarge','permissive'],['desk','!dispxsmall','!dispsmall','permissive'],['bed','!dispxsmall','!dispsmall','permissive'],['bag','!dispxsmall','!dispsmall','permissive'],['house','!dispxsmall','!dispsmall','permissive']]},
	'shdd' : { 'nogo':[['dispxsmall']], 'go':[['dispsmall'],['displarge'],['dispmedium']]},
	'media' : { 'nogo':[['all']], 'go':[['casual','permissive'],['gaming','permissive'],['cad3d','permissive'],['content','permissive']]},
};
