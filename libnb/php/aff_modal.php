<?php ?>
<div class="modal"  tabindex="-1" role="dialog" id="affil-popup" data-keyboard="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" id="modal-affil-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-affil-btn">
					<span aria-hidden="true"<i class="fas fa-times"></i></span>
				</button>
			</div>
			<div class="modal-body" id="affil-popup-body" style="transition: all .5s linear">
				<p><b><span style="font-weight: 900; color:#0066cb;">Let the stores know you came from noteb?</span></b> <br/><span style="color:#636363; padding-top:20px;display: inline-block;">Your gratitude keeps us up and running. </span></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="yes-affil-btn" onclick="choice_affil(1);">Yes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="no-affil-btn" onclick="choice_affil(0);">No</button>
			</div>
			<span id="learn-more-affil-btn" style="color:#000000;"><a href="#" style="color:#0066cb;">Learn More</a></span>
		</div>
	</div>
</div>
<?php ?>