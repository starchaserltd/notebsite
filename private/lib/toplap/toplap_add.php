<form action="lib/toplap/toplap_valid.php" method="post">
	<div class="title"><p><b>Add Top laptops</b></p></div>
	<div style="margin-left:30px;">
		<span style="display: inline-block;">Type</span>
		<select  id="type" name="type">
			<option value="Business" <?php if(isset($selected["Business"])&&$selected["Business"]!==""){ echo 'selected="selected"';} ?> >Business</option>
			<option value="Gaming" <?php if(isset($selected["Gaming"])&&$selected["Gaming"]!==""){ echo 'selected="selected"';} ?> >Gaming</option>
			<!-- <option value="Ultrabooks" <?php if(isset($selected["Ultraportable"])&&$selected["Ultraportable"]!==""){ echo 'selected="selected"';} ?> >Ultrabooks</option> -->
			<option value="HomeStudent" <?php if(isset($selected["HomeStudent"])&&$selected["HomeStudent"]!==""){ echo 'selected="selected"';} ?> >HomeStudent</option>
		</select><br><br>
	</div>
	<span>Conf ID</span><input type="text"  autocomplete="off" spellcheck="false" name="conf_id"> <br><br> 
	<span style="display: inline-block;margin-right: 15px;">Price</span><input type="text"  autocomplete="off" spellcheck="false" name="price"><br><br>
	<span style="display: inline-block;margin-right: 15px;">Add model with price range</span><input type="checkbox" name="price_range" value="1"><br><br> 
	<input class="button" type="submit" value="Insert" style="display: block;width: 60px; margin: 0 auto;">
</form>


