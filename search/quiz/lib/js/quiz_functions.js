Number.isInteger = Number.isInteger || function(value) { return typeof value === "number" && isFinite(value) && Math.floor(value) === value; };

function remodel()
{
	var avoidnogo=0;
	for (var key in compatibility)
	{
		avoidnogo=0;
		for(var key2 in compatibility[key]['go'])
		{
			if(avoidnogo<1)
			{
				var count=compatibility[key]['go'][key2].length;
				for(var key3 in compatibility[key]['go'][key2])
				{
					//console.log(key+" "+key2+" "+key3+" "+compatibility[key]['go'][key2][key3]+" "+count);
					if(compatibility[key]['go'][key2][key3]=="permissive" && count==1)
					{
						avoidnogo=-1;
					}
					else
					{
						for(var qkey in quiz)
						{
							for(var qkey2 in quiz[qkey]['options'])
							{
								if(compatibility[key]['go'][key2][key3][0]!=="!")
								{
									if(quiz[qkey]['options'][qkey2]['chk']['on']==1 && qkey2==compatibility[key]['go'][key2][key3])
									{ count--; }
								}
								else
								{
									if(quiz[qkey]['options'][qkey2]['chk']['on']==0 && qkey2==compatibility[key]['go'][key2][key3].substr(1))
									{ count--; }
								}
							}
						}
					}
				}
				if(count==0) { if(avoidnogo==0){ avoidnogo=1; } changeoptshow(key,1); }
			}
		}
		
		var disabled=0;
		if(!(avoidnogo>0))
		{
			for(var key2 in compatibility[key]['nogo'])
			{
				var count=compatibility[key]['nogo'][key2].length;
				for(var key3 in compatibility[key]['nogo'][key2])
				{
					if(compatibility[key]['nogo'][key2][key3]=="all" && avoidnogo!=-1)
					{
						changeoptshow(key,0); disabled=1;
					}
					else
					{
						for(var qkey in quiz)
						{
							for(var qkey2 in quiz[qkey]['options'])
							{
								if(quiz[qkey]['options'][qkey2]['chk']['on']==1 && qkey2==compatibility[key]['nogo'][key2][key3])
								{ count--; }
							}
						}
					}
				}
				if(count==0) { changeoptshow(key,0); disabled=1; }
			}
		}
		if(!disabled){ changeoptshow(key,1); }
	}
	suboptshow();
}

function changeoptshow(option,add)
{
	for(var qkey in quiz)
	{
		for(var qkey2 in quiz[qkey]['options'])
		{
			if(qkey2==option)
			{
				quiz[qkey]['options'][qkey2]['no']=add;
				
				for(var i=1;i<=6;i++)
				{
					if(window["opt"+i].getAttribute('onclick')!=="" && window["opt"+i].getAttribute('onclick').match(/press\(['"](.*?)['"]/)!==null && window["opt"+i].getAttribute('onclick').match(/press\(['"](.*?)['"]/)[1]==option)
					{
						if(add==1){ window['opt'+i].style.display="block"; }
						if(add==0){ window['opt'+i].style.display="none"; }
					}
					if(window["extraopt"+i].getAttribute('onclick')!=="" && window["extraopt"+i].getAttribute('onclick').match(/press\(['"](.*?)['"]/)!==null && window["extraopt"+i].getAttribute('onclick').match(/press\(['"](.*?)['"]/)[1]==option)
					{
						if(add==1){ window['extraopt'+i].style.display="block"; }
						if(add==0){ window['extraopt'+i].style.display="none"; }
					}
				}
			}
		}
	}
}

function suboptshow()
{
	var graph={};
	var keystoskip=[];
	for(var key in quiz)
	{
		graph[key]={};
		graph[key]['no']=0;
		for(var key2 in quiz[key]['options'])
		{
			graph[key][key2]={};
			if(key2 in quiz)
			{
				for(var key3 in quiz[key2]['options'])
				{
					graph[key][key2][key3]={};
					graph[key][key2][key3]["no"]=quiz[key2]['options'][key3]['no'];
					keystoskip.push(key2);
					delete graph.key2;
				}
			}
			else
			{ graph[key][key2]["no"]=quiz[key]['options'][key2]['no']; }
		}
	}
	
	function getChildrenValues(tree){ return Object.keys(tree).map(function(label) { if (label !== "no") { return tree[label]["no"]; } }); }
	function getChildrenLabels(tree) { return Object.keys(tree).filter(function(label) { return label !== "no" }); }
	function isLeaf(tree) { return getChildrenLabels(tree).length === 0; }
	function updateValues(tree, f)
	{
		if (isLeaf(tree)) { return tree; }
		else 
		{
			var newTree = {};
			getChildrenLabels(tree).map(function(key) { newTree[key] = updateValues(tree[key], f); });
			newTree["no"] = f(getChildrenValues(newTree));
			return newTree;
		}
	}

	function or(xs)
	{	
		function or_(a, b) { return a || b; }
		return xs.reduce(or_, 0);
	}
	
	graph=updateValues(graph,or);
	for(var key in quiz)
	{
		for(var key2 in quiz[key]['options'])
		{
			if(graph[key2]!==undefined && graph[key2]!==null && quiz[key]['options'][key2]['no']!=graph[key2]["no"])
			{  changeoptshow(key2,graph[key2]["no"]); }
		}
	}
}


function makePage(quizp)
{
    if(quizp<0){quizp=0;} if((quizp<=currentp&&quizp==maxpage-1) || (quizp==maxpage && quizp==pagetomake)){ activequery=1; pagetomake=-1;}
    currentp=quizp; quiz[quizp]['selected']=0; inmaking=1;
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
            activequery=0;  var elms = document.getElementsByClassName('iconel');
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
                    if(obj['chk']['on']==1) { addcheck("opt"+i,quizp); }
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
    inmaking=0;
}

function makeextraPage(quizp,el)
{
    if(!inextra || (inextra && !(Number.isInteger(el))))
    {
        var closeextratextnav=1; inmaking=1;
        if(!inextra) { inextra=quizp; closeextratext="closeextra"; if(document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick").indexOf("closeextra(")>=0) { closeextratextnav=0;  } } else { closeextratext="closeextraextra"; }
        //FADEIN CODE
        document.getElementById("extraopt").classList.add("showel");
        document.getElementById("extraopt").style.display="block";
        document.getElementById("question").innerHTML=quiz[quizp]['question'];
        setTimeout(function() { document.getElementById("extraopt").classList.remove("hidel");},10);
        
        var elms = document.getElementsByClassName('extraiconel'); quiz[quizp]['selected']=0;
        for (var i = 0; i < elms.length; i++) { elms[i].style.display="none"; elms[i].setAttribute("onClick",""); }
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
                if(obj['chk']['on']==1) { addcheck("extraopt"+i,quizp); }
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
                if(isNaN(el3)){ navnr[key].setAttribute( "onClick", closeextratext+"('"+quizp+"','"+el2+"'); "+"makePage("+key+");" );  } else { navnr[key].setAttribute( "onClick", closeextratext+"('"+quizp+"','"+el+"'); "+"closeextra('"+inextra+"','"+el3+"'); "+"makePage("+key+");" ); } 
            }
            navnr[key].style.display="none";
        }
        document.getElementsByClassName('glyphicon-arrow-left')[0].style.display="none";
        document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="none";
        
        if(closeextratextnav)
        {
            document.getElementsByClassName('glyphicon-arrow-left')[0].setAttribute( "onClick", closeextratext+"('"+quizp+"',"+"'"+el+"'"+"); "+document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick") );
            document.getElementsByClassName('glyphicon-arrow-right')[0].setAttribute( "onClick", closeextratext+"('"+quizp+"',"+"'"+el+"'"+"); "+document.getElementsByClassName('glyphicon-arrow-right')[0].getAttribute( "onClick") );
        }
        inmaking=0;
    }
}

function closeextra(extra,el)
{
    inextra=0; el=parseInt(el); var singlesel=0; inmaking=1;
    document.getElementById("extraopt").classList.remove("showel");
    document.getElementById("extraopt").classList.add("hidel");
    var subel=quiz[currentp]['options'];
    setTimeout(function() { document.getElementById("extraopt").style.display="none"; }, 300);
    if(quiz[extra]['selected']>=quiz[extra]['done'])
    { addcheck("opt"+el,currentp); if(quiz[currentp]['options'][extra]['chk']['on']==1){ quiz[currentp]['selected']--; }  quiz[currentp]['options'][extra]['chk']['on']=1; remodel(); }
    else
    { removecheck("opt"+el,el);

    document.getElementById("question").innerHTML=quiz[currentp]['question'];

    for (var key in subel) { if(quiz[currentp]["options"][key]["chk"]["on"]==1 && quiz[currentp]["options"][key]["txt"][1]=="single"){ singlesel=1;} } if(singlesel){  quiz[currentp]['selected']=1;  } else { if(quiz[currentp]['options'][extra]['chk']['on']==1){ quiz[currentp]['selected']--; } }  quiz[currentp]['options'][extra]['chk']['on']=0; }

    var navnr=document.getElementsByClassName('nrcircle');
    for (var key=0;key<=maxpage;key++)
    {
        if(navnr[key].getAttribute("onClick")!=""){ navnr[key].setAttribute( "onClick", "makePage("+key+");" ); }
        navnr[key].style.display="";
    }

    document.getElementsByClassName('glyphicon-arrow-left')[0].setAttribute( "onClick", document.getElementsByClassName('glyphicon-arrow-left')[0].getAttribute( "onClick").replace("closeextra('"+extra+"','"+el+"'); ","") );
    document.getElementsByClassName('glyphicon-arrow-right')[0].setAttribute( "onClick", document.getElementsByClassName('glyphicon-arrow-right')[0].getAttribute( "onClick").replace("closeextra('"+extra+"','"+el+"'); ","") );
	navigation();
	makePage(currentp);
	inmaking=0;
}


function closeextraextra(extra,el)
{
    var singlesel=0; var subel=quiz[inextra]['options'];
    var split=el.split("+"); var el2=parseInt(split[split.length-1]); var el3=parseInt(split[split.length-2]);
    if(quiz[extra]['selected']>=quiz[extra]['done'])
    { quiz[inextra]['selected']++; if(("opt"+el2).indexOf("extra")==-1) { navigation(); } remodel(); if(quiz[inextra]['options'][extra]['chk']['on']==1){ quiz[inextra]['selected']--; }  quiz[inextra]['options'][extra]['chk']['on']=1; remodel(); }
    else
    {   setTimeout(function() { document.getElementById("opt"+el2+"chk").style.display="none"; }, 300); if(("opt"+el2).indexOf("extra")==-1) { navigation(); } remodel();
    for (var key in subel) { if(quiz[inextra]["options"][key]["chk"]["on"]==1 && quiz[inextra]["options"][key]["txt"][1]=="single"){ singlesel=1;} } if(singlesel){  quiz[inextra]['selected']=1;  } else { if(quiz[inextra]['options'][extra]['chk']['on']==1){ quiz[inextra]['selected']--; } }  quiz[inextra]['options'][extra]['chk']['on']=0; remodel(); }
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
                                { quiz[page]['options'][key]['chk']['on']=0; remodel(); }
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
			quiz[page]['options'][option]['chk']['on']=1;
            addcheck(opt+el,page); 
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
    if(!inmaking){ remodel(); }
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
    if(!inmaking){ remodel(); }
}

function prequery(str,type) 
{
    $('#loadingNBquiz').show();
    if (str === "") { result = {}; return; }
    else 
    {
        if (window.XMLHttpRequest)  { var   xmlhttp = new XMLHttpRequest(); }
        xmlhttp.onreadystatechange = function() 
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
            {
                result = JSON.parse(xmlhttp.responseText);
				//console.log(result);
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
                    if(result["budgetmin"]<500 && result["budgetmax"]>=1){ quiz[5]['options']['b500']['no']=1; } else { quiz[5]['options']['b500']['no']=0; }
                    if(result["budgetmin"]<750 && result["budgetmax"]>=500){ quiz[5]['options']['b750']['no']=1; } else { quiz[5]['options']['b750']['no']=0; }
                    if(result["budgetmin"]<1000 && result["budgetmax"]>=750){ quiz[5]['options']['b1000']['no']=1; } else { quiz[5]['options']['b1000']['no']=0; }
                    if(result["budgetmin"]<1500 && result["budgetmax"]>=1000){ quiz[5]['options']['b1500']['no']=1; } else { quiz[5]['options']['b1500']['no']=0; }
                    if(result["budgetmin"]<2000 && result["budgetmax"]>=1500){ quiz[5]['options']['b2000']['no']=1; } else { quiz[5]['options']['b2000']['no']=0; }
                    if(result["budgetmin"]<3000 && result["budgetmax"]>=2000){ quiz[5]['options']['b3000']['no']=1; } else { quiz[5]['options']['b3000']['no']=0; }
                }
                            
                makePage(currentp);
                return;
            }
        }
        //console.log(siteroot+"search/qsearch.php?"+str+"&qtype="+type);
        xmlhttp.open("GET",siteroot+"search/qsearch.php?"+str+"&qtype="+type,true);
        xmlhttp.send();
    }
}


function navigation()
{
    if(quiz[currentp]['selected']>=quiz[currentp]['done'] && inextra==0)
    {    if(currentp<maxpage)
        { document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="inline"; document.getElementById("quiz_submit_btn").style.display="none"; }
        else
        { if(currentp==maxpage){ document.getElementById("quiz_submit_btn").style.display="block"; } document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="none";  } 
    }
    else
    { document.getElementsByClassName('glyphicon-arrow-right')[0].style.display="none"; document.getElementById("quiz_submit_btn").style.display="none"; }
    
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
		{ quizfinal=0; }
		
        if(key>lastactive && !quizfinal)
        {
			navnr[key].removeAttribute( "onClick", "makePage("+key+");" );
            navnr[key].classList.remove("nrcircleactive");
        }
    }
    if(lastactive>=maxpage) { lastactive--;}
    navnr[lastactive+1].classList.add("nrcircleactive");
    navnr[lastactive+1].setAttribute( "onClick", "makePage("+(lastactive+1)+");" );
}


function submit_the_quiz()
{
    var quiz_submit=[]; var i=0; var disable_items=[]; var j=0; var glue_string="";
    for (var key1 in quiz)
    {
        var opt=quiz[key1]['options'];
        for (var key2 in opt)
        {
            var selected=opt[key2];
            if ((typeof selected['chk']) != 'undefined' && selected['chk']['on']==1 && selected['no']==1)
            { quiz_submit[i]=key2+"=1"; i++; }
		
		    if ((typeof selected['chk']) != 'undefined' && (key1==4 || key1==5) && selected['no']==0)
            { disable_items[j]=key2+"=no"; j++; glue_string="&"; }
        }
    }
	if(ref!=null&&ref!="") { quiz_submit[i++]="ref="+ref; }
	var neworigstring=location.href.split(/[&|?]quizsearch=1/m)[0].replace("ref="+ref,"")+"?quizsearch=1&"+quiz_submit.join("&")+glue_string+disable_items.join("&"); neworigstring=neworigstring.replace("??","?");
	history.replaceState({back : neworigstring}, 'NoteBrother' + ' quiz submit', neworigstring); currentPage = neworigstring;
    location.href=siteroot+"?search/search.php?quizsearch=1&"+quiz_submit.join("&");
    return "Quiz submission!";
}