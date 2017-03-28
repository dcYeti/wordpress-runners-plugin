<?php

function aahn_meta_raceform( $post ){    //The following section is HTML for the dashboard form to fill out  
	wp_nonce_field( basename(__FILE__), 'aahn_race_nonce');
	$aahn_stored_meta = get_post_meta($post->ID);

	?>
	<h3>Required Fields</h3>
	<div class="left-label">
		<label for="event_name">Event Name</label>
	</div>
	<input type="text" name="event_name" size="45" value = "<?php 
	if (!empty($aahn_stored_meta['event_name'])) echo esc_attr($aahn_stored_meta['event_name'][0]); ?> " />		
	<label class="form_label" for="event_year">    Year</label>
	<input type="text" name="event_year" maxlength="4" size="4" value = "<?php 
	if (!empty($aahn_stored_meta['event_year'])) echo esc_attr($aahn_stored_meta['event_year'][0]); ?> " /><br/>
	<div class="left-label">
		<label for="race_typing">Race Type</label>
	</div>
	<select name="race_typing" required>
	<?php
		 //if race_typing already has a value, get the term_id
		if (!empty($aahn_stored_meta['race_typing'])) $typeName = get_term($aahn_stored_meta['race_typing'][0])->name;

		 //fetch current list of race_types for selection
		 $racetypes = get_terms(array('taxonomy'=>'race_type', 'hide_empty' => false));
		 foreach($racetypes as $racetype){
		 	if ($racetype->name == $typeName) {	$ifSelected = 'selected="selected"';	}
		 		else 	{	$ifSelected = ""; 	}
		 	echo "<option " . $ifSelected . " value=" . "'" . $racetype->term_id . "'>" . $racetype->name . "</option>";
		 }
	?>
	</select>
	<label class="form_label" for="race_location">Race Location</label>
		<input type="text" name="race_location" size="20" value = "<?php 
	if (!empty($aahn_stored_meta['race_location'])) echo esc_attr($aahn_stored_meta['race_location'][0]); ?>" /><br/>
	<div class="left-label">
		<label for="race_distance">Race Distance</label>
	</div>	
	<input type="text" name="race_distance" maxlength="5" size="5" value = "<?php 
	if (!empty($aahn_stored_meta['race_distance'])) echo esc_attr($aahn_stored_meta['race_distance'][0]); ?>"/>
	<?php //The following php will set up variables used to select the correct distance units(mi or km)
		$kmSelect = ""; $miSelect = ""; $distType = "";
		if (!empty($aahn_stored_meta['distance_type'])) $distType = $aahn_stored_meta['distance_type'][0];
		if ($distType == "kilometer") { $kmSelect = 'selected = "selected" '; }
			else if ($distType == "miles") { $miSelect = 'selected = "selected" '; }
	?>		
	<select name="distance_type" required>
		<option <?php echo $kmSelect; ?> value="kilometer">km</option>
		<option <?php echo $miSelect; ?> value="miles">mi</option> 
	</select>
	<label class="form_label" for="race_date">Date of Event</label>
		<input type="text" name="race_date" maxlength="20" value = "<?php 
	if (!empty($aahn_stored_meta['race_date'])) echo esc_attr($aahn_stored_meta['race_date'][0]); ?>" /><br/>
	<div class="left-label">
		<label for="race_finish">I finished </label>	
	</div>
		<input type="text" name="race_finish" maxlength="5" size="5" value = "<?php 
	if (!empty($aahn_stored_meta['race_finish'])) echo esc_attr($aahn_stored_meta['race_finish'][0]); ?>" />
	<label class="form_label" for="race_finishers"> out of </label>
		<input type="text" name="race_finishers" maxlength="6" size="6" value = "<?php 
	if (!empty($aahn_stored_meta['race_finishers'])) echo esc_attr($aahn_stored_meta['race_finishers'][0]); ?>" />
	<label class="form_label" for="race_entrants"> total finishers, and </label>
		<input type="text" name="race_entrants" maxlength="6" size="6" value = "<?php 
	if (!empty($aahn_stored_meta['race_entrants'])) echo esc_attr($aahn_stored_meta['race_entrants'][0]); ?> "/>
		<span> total entrants </span><br/>
	<div class="left-label-extended">
		<label for="finish_time_chip">Finish Time Chip</label>
	</div>
		<input type="text" name="finish_time_chip" maxlength="8" size="8" value = "<?php 
	if (!empty($aahn_stored_meta['finish_time_chip'])) echo esc_attr($aahn_stored_meta['finish_time_chip'][0]); ?> "/>
	<label class="form_label" for="finish_time_gun">Finish Time Gun [optional]</label>
		<input type="text" name="finish_time_gun" maxlength="8" size="8" value = "<?php 
	if (!empty($aahn_stored_meta['finish_time_gun'])) echo esc_attr($aahn_stored_meta['finish_time_gun'][0]); ?>" /><br/>
	<div class="left-label-extended">
		<label for="mile_pace">Mile Pace (MM:SS)</label>
	</div>
		<input type="text" name="mile_pace" maxlength="8" size="8" value = "<?php 	
	if (!empty($aahn_stored_meta['mile_pace'])) echo esc_attr($aahn_stored_meta['mile_pace'][0]); ?> "/>
	<h3>Optional Fields</h3>

	<div class="left-label-extended">
		<label for="bib_no">Bib Number</label> 
	</div>	
		<input type="text" name="bib_no" size="8" maxlength="8" value = "<?php 
	if (!empty($aahn_stored_meta['bib_no'])) echo esc_attr($aahn_stored_meta['bib_no'][0]); ?>" /><br/>
	<div class="left-label-extended">
		<label for="weather_cond">Weather Conditions</label> 
	</div>	
		<input type="text" name="weather_cond" size="40" value = "<?php 
	if (!empty($aahn_stored_meta['weather_cond'])) echo esc_attr($aahn_stored_meta['weather_cond'][0]); ?>" /><br/>
	<div class="left-label-extended">
		<label for="race_infosite">Race Info Website</label>
	</div>	 
		<input type="text" name="race_infosite" size="40" value = "<?php 
	if (!empty($aahn_stored_meta['race_infosite'])) echo esc_attr($aahn_stored_meta['race_infosite'][0]); ?>" /><br/>
	<div class="left-label-extended">
		<label for="race_resultsite">Race Results Site</label> 
	</div>
		<input type="text" name="race_resultsite" size="40" value = "<?php 
	if (!empty($aahn_stored_meta['race_resultsite'])) echo esc_attr($aahn_stored_meta['race_resultsite'][0]); ?>" /><br/>
	<?php //The following php will set up variables used to select the correct distance units(mi or km)
		$maleSelect = ""; $femaleSelect = ""; $genderType = "";
		if (!empty($aahn_stored_meta['gender'])) $genderType = $aahn_stored_meta['gender'][0];
		if ($genderType == "male") { $maleSelect = 'selected = "selected" '; }
			else if ($genderType == "female") { $femaleSelect = 'selected = "selected" '; }
	?>	
	<h4>Gender Finish</h4>
		<select name="gender">
			<option <?php echo $maleSelect; ?> value="male">Male</option>
			<option <?php echo $femaleSelect; ?> value="female">Female</option>
		</select>
	<label for="gender_rank">I finished </label>
		<input type="text" name="gender_rank" maxlength="5" size="5" value = "<?php 
	if (!empty($aahn_stored_meta['gender_rank'])) echo esc_attr($aahn_stored_meta['gender_rank'][0]); ?>" />
		<span>out of </span>
		<input type="text" name="gender_finishers" maxlength="5" size="5" value = "<?php 
	if (!empty($aahn_stored_meta['gender_finishers'])) echo esc_attr($aahn_stored_meta['gender_finishers'][0]); ?>" />
		<span>finishers</span><br/>
	<h4>Age Group Finish</h4>
	<label for="age_rank">I finished </label>
		<input type="text" name="age_rank" maxlength="5" size="5" value = "<?php 
	if (!empty($aahn_stored_meta['age_rank'])) echo esc_attr($aahn_stored_meta['age_rank'][0]); ?>" />
		<span>out of </span>
		<input type="text" name="age_finishers" maxlength="5" size="5" value = "<?php 
	if (!empty($aahn_stored_meta['age_finishers'])) echo esc_attr($aahn_stored_meta['age_finishers'][0]); ?>" />
		<span>finishers</span> in age group
		<input type="text" name="age_group" maxlength="20" size ="20" value = "<?php 
	if (!empty($aahn_stored_meta['age_group'])) echo esc_attr($aahn_stored_meta['age_group'][0]); ?>" /><br/>
	
	<h4>Enter Splits (enter up to 4)</h4>
	<label for="split1time">Enter Split 1 (HH:MM:SS): </label>
		<input type="text" name="split1time" maxlength="8" size="8" value = "<?php 
	if (!empty($aahn_stored_meta['split1time'])) echo esc_attr($aahn_stored_meta['split1time'][0]); ?>" />
	<label for="split1distance"> at </label>
		<input type="text" name="split1distance" maxlength="4" size="4" value = "<?php 
	if (!empty($aahn_stored_meta['split1distance'])) echo esc_attr($aahn_stored_meta['split1distance'][0]); ?>" />
	<?php //The following php will set up variables used to select the correct distance units(mi or km)
		$kmSelect = ""; $miSelect = ""; $distType = "";
		if (!empty($aahn_stored_meta['split1type'])) $distType = $aahn_stored_meta['split1type'][0];
		if ($distType == "kilometer") { $kmSelect = ' selected = "selected" '; }
			else { $miSelect = ' selected = "selected" '; }
	?>
	<select name="split1type">
		<option<?php echo $kmSelect; ?> value="kilometer">km</option>
		<option<?php echo $miSelect; ?> value="miles">mi</option>
	</select><br/>

	<label for="split2time">Enter Split 2 (HH:MM:SS): </label>
		<input type="text" name="split2time" maxlength="8" size="8" value = "<?php 
	if (!empty($aahn_stored_meta['split2time'])) echo esc_attr($aahn_stored_meta['split2time'][0]); ?>" />
	<label for="split2distance"> at </label>
		<input type="text" name="split2distance" maxlength="4" size="4" value = "<?php 
	if (!empty($aahn_stored_meta['split2distance'])) echo esc_attr($aahn_stored_meta['split2distance'][0]); ?>" />
	<?php //The following php will set up variables used to select the correct distance units(mi or km)
		$kmSelect = ""; $miSelect = ""; $distType = "";
		if (!empty($aahn_stored_meta['split2type'])) $distType = $aahn_stored_meta['split2type'][0];
		if ($distType == "kilometer") { $kmSelect = ' selected = "selected" '; }
			else { $miSelect = ' selected = "selected" '; }
	?>
	<select name="split2type">
		<option<?php echo $kmSelect; ?> value="kilometer">km</option>
		<option<?php echo $miSelect; ?> value="miles">mi</option>
	</select><br/>

	<label for="split3time">Enter Split 3 (HH:MM:SS): </label>
		<input type="text" name="split3time" maxlength="8" size="8" value = "<?php 
	if (!empty($aahn_stored_meta['split3time'])) echo esc_attr($aahn_stored_meta['split3time'][0]); ?>" />
	<label for="split3distance"> at </label>
		<input type="text" name="split3distance" maxlength="4" size="4" value = "<?php 
	if (!empty($aahn_stored_meta['split3distance'])) echo esc_attr($aahn_stored_meta['split3distance'][0]); ?>" />
	<?php //The following php will set up variables used to select the correct distance units(mi or km)
		$kmSelect = ""; $miSelect = ""; $distType = "";
		if (!empty($aahn_stored_meta['split3type'])) $distType = $aahn_stored_meta['split3type'][0];
		if ($distType == "kilometer") { $kmSelect = ' selected = "selected" '; }
			else { $miSelect = ' selected = "selected" '; }
	?>
	<select name="split3type">
		<option<?php echo $kmSelect; ?> value="kilometer">km</option>
		<option<?php echo $miSelect; ?> value="miles">mi</option>
	</select><br/>	

	<label for="split4time">Enter Split 4 (HH:MM:SS): </label>
		<input type="text" name="split4time" maxlength="8" size="8" value = "<?php 
	if (!empty($aahn_stored_meta['split4time'])) echo esc_attr($aahn_stored_meta['split4time'][0]); ?>" />
	<label for="split4distance"> at </label>
		<input type="text" name="split4distance" maxlength="4" size="4" value = "<?php 
	if (!empty($aahn_stored_meta['split4distance'])) echo esc_attr($aahn_stored_meta['split4distance'][0]); ?>" />
	<?php //The following php will set up variables used to select the correct distance units(mi or km)
		$kmSelect = ""; $miSelect = ""; $distType = "";
		if (!empty($aahn_stored_meta['split4type'])) $distType = $aahn_stored_meta['split4type'][0];
		if ($distType == "kilometer") { $kmSelect = ' selected = "selected" '; }
			else { $miSelect = ' selected = "selected" '; }
	?>
	<select name="split4type">
		<option<?php echo $kmSelect; ?> value="kilometer">km</option>
		<option<?php echo $miSelect; ?> value="miles">mi</option>
	</select><br/>	

	<h3>Tell us about your race</h3>
	<?php
		//Configure and call WP Editor
		$content = get_post_meta($post->ID, 'racestory', true);
		$editor = 'racestory';
		$settings = array(
			'textarea_rows' => 7,
			'media_buttons' => true,
		);
		wp_editor($content, $editor, $settings);
	

}


function aahn_create_race_meta(){
	add_meta_box(
		'aahn_raceform',
		'Add Race Information',
		'aahn_meta_raceform',
		'race_report',
		'normal',
		'high');
}

add_action('add_meta_boxes','aahn_create_race_meta');



function aahn_process_race_metabox ( $post_id ) {
	//The following ensures that data is not written to database unless "Publish" or "update" are selected
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['aahn_race_nonce'] ) && wp_verify_nonce( $_POST['aahn_race_nonce'], basename(__FILE__))) ? 'true':'false';

	//Exits script if any of the above conditions are met
	if ($is_autosave || $is_revision || !$is_valid_nonce) {
		return;
	}

	//Write required fields into database
	$eventYear = "";
	if ( isset($_POST['event_year'])){
		$eventYear = sanitize_text_field($_POST['event_year']);
		update_post_meta($post_id, 'event_year', $eventYear);
	}

	if ( isset($_POST['event_name'])){
		$eventName = sanitize_text_field($_POST['event_name']);
		update_post_meta($post_id, 'event_name', $eventName);
		
		//Update Title for _posts table - the below is necessary because updating fires save_post, which causes infinite loop
		$postTitle = trim(trim($eventYear) . " " . trim($eventName));
		if ( ! wp_is_post_revision( $post_id ) ){
			//args array
			$postTableArgs = array('ID'=>$post_id, 'post_title'=>$postTitle);
			// unhook this function so it doesn't loop infinitely
			remove_action('save_post', 'aahn_process_race_metabox');
			// update the post, which calls save_post again
			wp_update_post( $postTableArgs);
			// re-hook this function
			add_action('save_post', 'aahn_process_race_metabox');
		}
	}
	if ( isset($_POST['race_typing'])){
		update_post_meta($post_id, 'race_typing', sanitize_text_field($_POST['race_typing']));
	}
	if ( isset($_POST['race_location'])){
		update_post_meta($post_id, 'race_location', sanitize_text_field($_POST['race_location']));
	}
	if ( isset($_POST['race_distance'])){
		update_post_meta($post_id, 'race_distance', sanitize_text_field($_POST['race_distance']));
	}
	if ( isset($_POST['distance_type'])){
		update_post_meta($post_id, 'distance_type', sanitize_text_field($_POST['distance_type']));
	}
	if ( isset($_POST['race_date'])){
		update_post_meta($post_id, 'race_date', sanitize_text_field($_POST['race_date']));
	}
	if ( isset($_POST['race_finish'])){
		update_post_meta($post_id, 'race_finish', sanitize_text_field($_POST['race_finish']));
	}
	if ( isset($_POST['race_finishers'])){
		update_post_meta($post_id, 'race_finishers', sanitize_text_field($_POST['race_finishers']));
	}
	if ( isset($_POST['race_finishers'])){
		update_post_meta($post_id, 'race_finishers', sanitize_text_field($_POST['race_finishers']));
	}
	if ( isset($_POST['race_entrants'])){
		update_post_meta($post_id, 'race_entrants', sanitize_text_field($_POST['race_entrants']));
	}
	if ( isset($_POST['finish_time_gun'])){
		update_post_meta($post_id, 'finish_time_gun', sanitize_text_field($_POST['finish_time_gun']));
	}
	if ( isset($_POST['mile_pace'])){
		update_post_meta($post_id, 'mile_pace', sanitize_text_field($_POST['mile_pace']));
	}
	if ( isset($_POST['racestory'])){
		update_post_meta($post_id, 'racestory', wp_kses_post($_POST['racestory']));		
	}

	//Process optional fields and write if existing
	if ( isset($_POST['finish_time_chip']) && !empty($_POST['finish_time_chip'])){
		update_post_meta($post_id, 'finish_time_chip', sanitize_text_field($_POST['finish_time_chip']));
	}
	if ( isset($_POST['bib_no']) && !empty($_POST['bib_no'])){
		update_post_meta($post_id, 'bib_no', sanitize_text_field($_POST['bib_no']));
	}
	if ( isset($_POST['weather_cond']) && !empty($_POST['weather_cond'])){
		update_post_meta($post_id, 'weather_cond', sanitize_text_field($_POST['weather_cond']));
	}
	if ( isset($_POST['race_infosite']) && !empty($_POST['race_infosite'])){
		update_post_meta($post_id, 'race_infosite', sanitize_text_field($_POST['race_infosite']));
	}
	if ( isset($_POST['race_resultsite']) && !empty($_POST['race_resultsite'])){
		update_post_meta($post_id, 'race_resultsite', sanitize_text_field($_POST['race_resultsite']));
	}

	//For optional fields that are grouped together, we will use boolean flags to turn on/off displays on front end
	$opt_genderfinish = 'false'; $opt_agefinish = 'false'; $opt_split1 = 'false';
	$opt_split2 = 'false'; $opt_split3 = 'false'; $opt_split4 = 'false';

	if ( isset($_POST['gender_rank']) && isset($_POST['gender_finishers']) 
		&& !empty($_POST['gender_rank']) && !empty($_POST['gender_finishers'])) {
		update_post_meta($post_id, 'gender', sanitize_text_field($_POST['gender']));
		update_post_meta($post_id, 'gender_rank', sanitize_text_field($_POST['gender_rank']));
		update_post_meta($post_id, 'gender_finishers', sanitize_text_field($_POST['gender_finishers']));
		$opt_genderfinish = 'true';
	}
	update_post_meta($post_id, 'opt_genderfinish', $opt_genderfinish);

	if ( isset($_POST['age_rank']) && isset($_POST['age_finishers']) && isset($_POST['age_group'])
		 && !empty($_POST['age_rank']) && !empty($_POST['age_finishers']) && !empty($_POST['age_group'])){
		update_post_meta($post_id, 'age_rank', sanitize_text_field($_POST['age_rank']));
		update_post_meta($post_id, 'age_finishers', sanitize_text_field($_POST['age_finishers']));
		update_post_meta($post_id, 'age_group', sanitize_text_field($_POST['age_group']));
		$opt_agefinish = 'true';		
	}
	update_post_meta($post_id, 'opt_agefinish', $opt_agefinish);

	if ( isset($_POST['split1time']) && isset($_POST['split1distance']) 
		&& !empty($_POST['split1time']) && !empty($_POST['split1distance'])) {
		update_post_meta($post_id, 'split1time', sanitize_text_field($_POST['split1time']));
		update_post_meta($post_id, 'split1distance', sanitize_text_field($_POST['split1distance']));
		update_post_meta($post_id, 'split1type', sanitize_text_field($_POST['split1type']));
		$opt_split1 = 'true';
	}
	update_post_meta($post_id, 'opt_split1', $opt_split1);

	if ( isset($_POST['split2time']) && isset($_POST['split2distance'])
		 && !empty($_POST['split2time']) && !empty($_POST['split2distance'])) {
		update_post_meta($post_id, 'split2time', sanitize_text_field($_POST['split2time']));
		update_post_meta($post_id, 'split2distance', sanitize_text_field($_POST['split2distance']));
		update_post_meta($post_id, 'split2type', sanitize_text_field($_POST['split2type']));
		$opt_split2 = 'true';
	}
	update_post_meta($post_id, 'opt_split2', $opt_split2);

	if ( isset($_POST['split3time']) && isset($_POST['split3distance'])
		 && !empty($_POST['split3time']) && !empty($_POST['split3distance'])) {
		update_post_meta($post_id, 'split3time', sanitize_text_field($_POST['split3time']));
		update_post_meta($post_id, 'split3distance', sanitize_text_field($_POST['split3distance']));
		update_post_meta($post_id, 'split3type', sanitize_text_field($_POST['split3type']));
		$opt_split3 = 'true';
	}
	update_post_meta($post_id, 'opt_split3', $opt_split3);

	if ( isset($_POST['split4time']) && isset($_POST['split4distance'])
		 && !empty($_POST['split4time']) && !empty($_POST['split4distance'])) {
		update_post_meta($post_id, 'split4time', sanitize_text_field($_POST['split4time']));
		update_post_meta($post_id, 'split4distance', sanitize_text_field($_POST['split4distance']));
		update_post_meta($post_id, 'split4type', sanitize_text_field($_POST['split4type']));
		$opt_split4 = 'true';
	}
	update_post_meta($post_id, 'opt_split4', $opt_split4);
}

add_action('save_post', 'aahn_process_race_metabox');