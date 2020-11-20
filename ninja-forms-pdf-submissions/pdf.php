<?php
error_reporting(E_ALL);

/**
 * PDF Included With Form Submission
 * 
 * This version is customized for form #3 to provide a printed PDF copy
 * that looks like the original PDF form.
 *
 * Created 23/01/2020
 * 
 * @version     1.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
// Form info at bottom
$form_footer_top = '<p style="color:#e30101;font-size: 16px;margin-bottom: 0;">Required fields in red - Campi obbligatori in rosso</p>';
$form_footer_bottom ='<p style="font-weight: bold;font-size: 12px;">MOD_52_GYRO_CUSTOMER_DATA_REV_00_01_12_2019</p>';

// Radio button fields - match these with what is in the form
$radio_fields = array(
	'imperial_metric' => array (
		'imperial' => 'IMPERIAL',
		'metric' => 'METRIC'
	),
	'application' => array (
		'pleasure_yacht' => 'Pleasure yacht',
		'charter_yacht' => 'Charter yacht',
		'sportfish' => 'Sportfish <em>(Pesca)</em>',
		'commercial' => 'Commercial <em>(Commerciale)</em>',
		'military' => 'Militare <em>(Military)</em>'
	),
	'available_power_supply' => array (
		'110v' => '110V',
		'220v' => '220V',
		'12v' => '12V'
	),
	'hull_type' => array (
		'hard_chine' => 'Hard Chine <em>(Planante)</em>',
		'round_bilge' => 'Round Bilge <em>(Dislocante)</em>'
	),
	'vessel_info' => array (
		'refit' => 'Refit',
		'new_build' => 'New Build <em>(Nuova costruzione)</em>'
	),
	'sea_profile' => array (
		'closed_sea' => 'CLOSED SEA <em>(Mare chiuso)</em>',
		'ocean' => 'OCEAN <em>(Oceano)</em>',
		'lake' => 'LAKE <em>(Lago)</em>'
	)
);

// Check if it is form id 4
if($form_ID == '4') {

	foreach($fields as $key => $field) {
		if($field['admin_label'] != '') {
			$sorted_fields[$field['admin_label']] = $field;
		}
	}

	$image_dir = site_url() . '/wp-content/themes/bridge-child/ninja-forms-pdf-submissions/';
	?>

	<html><head>
		<link type="text/css" href="<?php echo $image_dir . '/custom-pdf.css'; ?>" rel="stylesheet" />
	</head><body>
	<table class="custom-pdf-wrapper">
		<tr class="outer-row heading-row-first">
			<td valign="middle" colspan="2">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="one-fourth">
							<img width="200" height="27" src="<?php echo $image_dir . '/quick_spa.png';?>" />
						</td>
						<td valign="middle" class="one-half align-center">
						</td>
						<td valign="middle" class="one-fourth align-right">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="outer-row heading-row-second">
			<td valign="middle" colspan="2">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="one-fourth">
							
						</td>
						<td valign="middle" class="one-half align-center">
							<img width="310" height="39" src="<?php echo $image_dir . 'form_mc2.png';?>" />
							<h2 class="blue-head">CUSTOMER DATA</h2>
							<h2 class="blue-subhead" style="font-size: 18px;"><em>DATI CLIENTE</em></h2>
						</td>
						<td valign="middle" class="one-fourth align-right">
							<img width="58" height="57" src="<?php echo $image_dir . 'user_icon.png';?>" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php 
								// wl($sorted_fields['name']);
							echo trim($sorted_fields['name']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['name']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['company']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['company']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['phone']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['phone']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['address']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['address']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>


		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['city']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['city']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['state']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['state']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>


		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['email']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['email']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label"> 
							<p><?php echo trim($sorted_fields['website']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['website']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row vessel-row">
			<td valign="middle" colspan="2">
				<table autosize="1" class="inner-row">
					<tr>
						<td valign="middle" class="one-fourth">
							<table class="radio-table">									
								<?php 
									foreach ($radio_fields['imperial_metric'] as $option_key => $option) {
										?>
										<tr>
											<td valign="middle" class="radio-item">
												<?php 
													if($sorted_fields['imperial_metric']['value'] == $option_key) {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio_checked.png" />';
													} else {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio.png" />';
													}
												?>
											</td>
											<td valign="middle" class="radio-label">
												<p class="blue-bold"><?php echo $option; ?></p>
											</td>
										</tr>
										<?php
									}						
								?>
							</table>
						</td>
						<td valign="middle" class="one-half align-center">
							<h2 class="blue-head">VESSEL INFORMATION</h2>
							<h2 class="blue-subhead" style="font-size: 18px;"><em>INFORMAZIONI BARCA</em></h2>
						</td>
						<td valign="middle" class="one-fourth align-right">
							<img width="78" height="55" src="<?php echo $image_dir . '/boat_icon.png';?>" />
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row wider">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['shipyard']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['shipyard']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['model']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['model']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['boat_name']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['boat_name']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label">
							<p><?php echo trim($sorted_fields['year']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<p><?php echo trim($sorted_fields['year']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row application-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="top" class="pdf-label wide-label">
							<p><?php echo trim($sorted_fields['application']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							 <table class="radio-table">									
								<?php 
									foreach ($radio_fields['application'] as $option_key => $option) {
										?>
										<tr>
											<td valign="middle" class="radio-item">
												<?php 
													if($sorted_fields['application']['value'] == $option_key) {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio_checked.png" />';
													} else {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio.png" />';
													}
												?>
											</td>
											<td valign="middle" class="radio-label">
												<p><?php echo $option; ?></p>
											</td>
										</tr>
										<?php
									}						
								?>
							</table>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="top" class="pdf-right" width="50%">
				<table class="right-of-application-wrapper">
						<tr>
							<td valign="middle" class="border-col">
								<table class="inner-row">
									<tr> 

										<td valign="middle" class="pdf-label wide-label">
											<p><?php echo trim($sorted_fields['hull_type']['label']); ?></p>
										</td>
										<td valign="middle" class="pdf-content">
											<table class="radio-table">									
												<?php 
													foreach ($radio_fields['hull_type'] as $option_key => $option) {
														?>
														<tr>
															<td valign="middle" class="radio-item">
																<?php 
																	if($sorted_fields['hull_type']['value'] == $option_key) {
																		echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio_checked.png" />';
																	} else {
																		echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio.png" />';
																	}
																?>
															</td>
															<td valign="middle" class="radio-label">
																<p><?php echo $option; ?></p>
															</td>
														</tr>
														<?php
													}						
												?>
											</table>
										</td>


									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td valign="middle" class="border-col">
								<table class="inner-row">
									<tr> 
										
										<td valign="middle" class="pdf-label wide-label">
											<p><?php echo trim($sorted_fields['vessel_info']['label']); ?></p>
										</td>
										<td valign="middle" class="pdf-content">
											<table class="radio-table">									
												<?php 
													foreach ($radio_fields['vessel_info'] as $option_key => $option) {
														?>
														<tr>
															<td valign="middle" class="radio-item">
																<?php 
																	if($sorted_fields['vessel_info']['value'] == $option_key) {
																		echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio_checked.png" />';
																	} else {
																		echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio.png" />';
																	}
																?>
															</td>
															<td valign="middle" class="radio-label">
																<p><?php echo $option; ?></p>
															</td>
														</tr>
														<?php
													}						
												?>
											</table>
										</td>	
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<!--end new-->
				
			</td>
		</tr>

		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="top" class="pdf-label wider-label">
							<p><?php echo trim($sorted_fields['available_power_supply']['label']); ?></p>
						</td>
						<td valign="midde" class="pdf-content">
							<table class="radio-table">									
								<?php 
									foreach ($radio_fields['available_power_supply'] as $option_key => $option) {
										?>
										<tr>
											<td valign="middle" class="radio-item">
												<?php 
													if($sorted_fields['available_power_supply']['value'] == $option_key) {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio_checked.png" />';
													} else {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio.png" />';
													}
												?>
											</td>
											<td valign="middle" class="radio-label">
												<p><?php echo $option; ?></p>
											</td>
										</tr>
										<?php
									}						
								?>
							</table>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="top" class="pdf-label wide-label">
							<p><?php echo trim($sorted_fields['sea_profile']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content">
							<table class="radio-table">									
								<?php 
									foreach ($radio_fields['sea_profile'] as $option_key => $option) {
										?>
										<tr>
											<td valign="top" class="radio-item">
												<?php 
													if($sorted_fields['sea_profile']['value'] == $option_key) {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio_checked.png" />';
													} else {
														echo '<img class="radio" width="20" height="20" src="' . $image_dir . '/radio.png" />';
													}
												?>
											</td>
											<td valign="middle" class="radio-label">
												<p><?php echo $option; ?></p>
											</td>
										</tr>
										<?php
									}						
								?>
							</table>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row boat-diagram">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="left-of-diagram-wrapper">
					<tr>
						<td valign="top" class="border-col">
							<table class="inner-row">
								<tr> 
									<td valign="middle" class="pdf-label required widest-label">
										<p style="color: #e30101;"><?php echo trim($sorted_fields['length_overall']['label']); ?></p>
									</td>
									<td valign="middle" class="pdf-content align-right">
										<p><?php echo trim($sorted_fields['length_overall']['value']); ?></p>
									</td>	
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" class="border-col">
							<table class="inner-row">
								<tr>
									<td valign="middle" class="pdf-label required widest-label">
										<p style="color: #e30101;"><?php echo trim($sorted_fields['beam_overall']['label']); ?></p>
									</td>
									<td valign="middle" class="pdf-content align-right">
										<p><?php echo trim($sorted_fields['beam_overall']['value']); ?></p>
									</td>	
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" class="border-col">
							<table class="inner-row">
								<tr>
									<td valign="middle" class="pdf-label widest-label">
										<p><?php echo trim($sorted_fields['transverse_metacentric_height']['label']); ?></p>
									</td>
									<td valign="middle" class="pdf-content align-right">
										<p><?php echo trim($sorted_fields['transverse_metacentric_height']['value']); ?></p>
									</td>	
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" class="border-col">
							<table>
								<tr>
									<td valign="middle" class="pdf-label widest-label">
										<p><?php echo trim($sorted_fields['center_of_gravity_of_hull']['label']); ?></p>
									</td>
									<td valign="middle" class="pdf-content align-right">
										<p><?php echo trim($sorted_fields['center_of_gravity_of_hull']['value']); ?></p>
									</td>	
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" class="border-col">
							<table>
								<tr>
									<td valign="middle" class="pdf-label widest-label">
										<p><?php echo trim($sorted_fields['center_of_buoyancy']['label']); ?></p>
									</td>
									<td valign="middle" class="pdf-content align-right">
										<p><?php echo trim($sorted_fields['center_of_buoyancy']['value']); ?></p>
									</td>	
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="middle" class="border-col">
							<table>
								<tr>
									<td valign="middle" class="pdf-label widest-label">
										<p><?php echo trim($sorted_fields['length_waterline']['label']); ?></p>
									</td>
									<td valign="middle" class="pdf-content align-right">
										<p><?php echo trim($sorted_fields['length_waterline']['value']); ?></p>
									</td>	
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right boat-diagram" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle">
							<img width="360" height="265" src="<?php echo $image_dir . '/boat_diagram.png';?>"/>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label required widest-label">
							<p style="color: #e30101;"><?php echo trim($sorted_fields['full_load_displacement']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content align-right">
							<p><?php echo trim($sorted_fields['full_load_displacement']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label widest-label">
							<p><?php echo trim($sorted_fields['draft_without_appendages']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content align-right">
							<p><?php echo trim($sorted_fields['draft_without_appendages']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row">
			<td valign="middle" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label widest-label">
							<p><?php echo trim($sorted_fields['natural_roll_period']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content align-right">
							<p><?php echo trim($sorted_fields['natural_roll_period']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label required widest-label">
							<p style="color: #e30101;"><?php echo trim($sorted_fields['hours_of_operation']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content align-right">
							<p><?php echo trim($sorted_fields['hours_of_operation']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

		<tr class="outer-row final-row">
			<td valign="bottom" class="pdf-left" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="no-margin form-info">
							<?php echo trim($form_footer_top); ?>
							<?php echo trim($form_footer_bottom); ?>
						</td>	
					</tr>
				</table>
			</td>
			<td valign="middle" class="pdf-right" width="50%">
				<table class="inner-row">
					<tr>
						<td valign="middle" class="pdf-label align-right wider-label  date-label">
							<p><?php echo trim($sorted_fields['date']['label']); ?></p>
						</td>
						<td valign="middle" class="pdf-content align-right date-field">
							<p><?php echo trim($sorted_fields['date']['value']); ?></p>
						</td>	
					</tr>
				</table>
			</td>
		</tr>

	</table>

	</body></html>
	<?php	
} // end if form_ID
	else {
		// This is the original, standard Ninja Forms PDF code
		?>
			<html><head>
				<link type="text/css" href="<?php echo $css_path; ?>" rel="stylesheet" />
			</head><body>
				<?php if (strlen($header) > 0) { ?>
					<div><?php echo $header;?></div>
				<?php } ?>
				<h1 class="document_title"><?php echo $title; ?></h1>
				<?php echo $table; ?>
			</body></html>
			<?php
} //end if
?>