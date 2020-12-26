var set_quiz_data=window.location.href;
pagetomake=0;
for(var qkey in quiz)
{
	quiz[qkey]['selected']=0;
	for(var qkey2 in quiz[qkey]['options'])
	{
		if(set_quiz_data.indexOf(qkey2+"=1", 10)>0)
		{
			quiz[qkey]['options'][qkey2]['chk']['on']=1;
			quiz[qkey]['selected']++;
			pagetomake=5;
		}
		else if(set_quiz_data.indexOf("&"+qkey2+"=no", 10)>0)
		{
			quiz[qkey]['options'][qkey2]['no']=0;
		}
	}
}
if(pagetomake!=0)
{
	document.getElementsByClassName('startQuiz');
	document.getElementsByClassName('tab1_intro')[0].style.display='none';
	document.getElementsByClassName('tab2_intro')[0].style.display='none';
	[...document.getElementsByClassName('startQuiz')].forEach((button) => {
		button.style.display='none'
	});
}
remodel();