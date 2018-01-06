<?php if(!isset($quiz_css_addr)){ $quiz_css_addr="search/quiz/"; } else { $quiz_css_addr=""; } ?>
<div class="quiz_container">
	<input id="tab1" type="checkbox"><label for="tab1" class="label_intro1"><span class="startQuiz">Take the Quiz!</span></label>	
	<input id="tab2" type="checkbox"><label for="tab2" class="label_intro2"><span class="startQuiz">Start Quiz!</span></label>		
	<section class="tab1_intro"><p class="h2 text-center quizParagraf1">Find your laptop match</p></section>
	<section class="tab2_intro">
		<!-- <p class="h2 text-center quizParagraf2">How to use our Quiz</p> -->
        <p>Before you begin:</p>       
        <ul>
            <li>The quiz has five main questions.</li>
            <li>Questions with "(multiple choices)" specified in their description accept multiple answers.</li>
            <li>Some questions can be skipped by going to the next question.</li>
            <li>Some answers will open a sub-question for clarification.</li>
            <li>The battery life and budget options depend on previously selected options.</li>
            <li>The quiz primarily focuses on laptops available on the US market.</li>
        </ul>
	</section>
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
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>											
						<span class="icontext" id="opt1txt"><br></span>
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt2"  onclick="">
						<div id="opt2img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option2">
							<svg id="opt2chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext"  id="opt2txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt3" style="" onclick="">
						<div id="opt3img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option3">
							<svg id="opt3chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
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
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext"  id="opt4txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt5" onclick="">
						<div id="opt5img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option5">
							<svg id="opt5chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext" id="opt5txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="iconel" id="opt6" style="" onclick="">
						<div id="opt6img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="option6">
							<svg id="opt6chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext" id="opt6txt"><br></span>						
					</div>
				</div>
			</div>
		</div>
		<div id="quiz_noresults" style="display: block;"><span>Sorry, but there are no laptops currently on the market <br> with your selected features!<br><br><br>Try to change or remove some of your selected options before returning to this step.</span></div>
		<div id="extraopt" class="shadow hidel">
		<div class="row" align="center" id="icontable">
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="display: block; border-top:8px solid; border-color: transparent;">
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt1"  onclick="">
						<div id="extraopt1img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption1">
							<svg id="extraopt1chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext" id="extraopt1txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt2"  onclick="">
						<div id="extraopt2img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption2"><svg id="extraopt2chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>						
						<span class="icontext"  id="extraopt2txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt3" style="" onclick="">
						<div id="extraopt3img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption3"><svg id="extraopt3chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext" id="extraopt3txt"><br></span>						
					</div>
				</div>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="display: block;">
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt4"  onclick="">
						<div id="extraopt4img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption4"><svg id="extraopt4chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext"  id="extraopt4txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt5"  onclick="">
						<div id="extraopt5img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption5"><svg id="extraopt5chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
						</div>
						<span class="icontext" id="extraopt5txt"><br></span>						
					</div>
				</div>
				<div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
					<div class="extraiconel" id="extraopt6"  onclick="">
						<div id="extraopt6img" class="iconcircle hoverblue" style="padding: 13px;"><img class="img-responsive iconimg" src="" alt="extraoption6"><svg id="extraopt6chk" class="checkmark" style="" viewBox="0 0 52 52"><circle class="checkmark__circle" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
							<img class="img-responsive ieCheckmark" src="<?php echo $quiz_css_addr.'res/img/icons/checkmark.svg';?>" alt="checkmark"/>
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
				<p><span>Next</span><span class="hidden-xs visible-sm visible-md visible-lg">Question</span></p>	
				<span class="nextTextTail"></span>		
			</span>
		</span>
		<span class="submit_quiz" style="display:none;" id="quiz_submit_btn" onclick="submit_the_quiz();">			
			<span><p>Find your laptop!</p></span>
		</span>
	</div>
</div>
<script type="text/javascript">$.getScript("<?php echo $quiz_css_addr.'lib/js/quiz_data.js'; ?>").done(function(){ $.getScript("<?php echo $quiz_css_addr.'lib/js/quiz_functions.js'; ?>").done(function(){ var locationPath = location.pathname; if(locationPath.indexOf("/search/quiz/nquiz.php")>=0) {imgadd="res/img/icons/"; } $.getScript("<?php echo $quiz_css_addr.'lib/js/set_quiz.js'; ?>").done(function(){ function quiz_init() { makePage(pagetomake); } quiz_init(); }); }); });</script>