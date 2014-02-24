<?php
#*************************************************************************
#
# Discipline Module for Opensis
# Copyright (C) 2008 Billboard.Net
# Designer(s): Christopher Whiteley
# Contributor(s): Russell Holmes
#
#*************************************************************************
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, version 2 of the License. See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#**************************************************************************

require_once('classes/IncidentCode.php');

/*
modules
null = incidentEditor
1    = perpetrator
*/
$module = $_GET['module'];
$identifier = $_GET['identifier'];

if($module == null){

	require_once('classes/Discipline.php');

	$edit = false;
	$date;
	$incidentId;
	$incidentDesc;
	$locationId;
	$locationDesc;
	$schoolId;
	$schoolDesc;
	$timeId;
	$timeDesc;
	$facilitiesId;
	$facilitiesDesc;
	$injuryId;
	$injuryDesc;
	$weaponId;
	$weaponDesc;
	$reporterId;
	$reporterDesc;
	$relatedAlcohol;
	$relatedDrug;
	$relatedHate;
	$relatedWeapon;
	$relatedGang;
	$relatedBully;
	$reportedLaw;
	$month;
	$day;
	$year;
	$openClosed;

	if($identifier != null){
		$edit = true;

		$query = "SELECT
				  r.record_date AS record_date,
				  r.incident_id,
				  i.incident_description,
				  r.location_id,
				  l.location_description,
				  r.school_id,
				  s.school_description,
				  r.time_id,
				  t.time_description,
				  r.facilities_id,
				  f.facilities_description,
				  r.injury_id,
				  inj.injury_description,
				  r.weapon_id,
				  w.weapon_description,
				  r.reporter_id,
				  re.reporter_description,
				  r.related_alcohol,
				  r.related_drug,
				  r.related_hate,
				  r.related_weapon,
				  r.related_gang,
				  r.related_bully,
				  r.reported_law,
				  r.cost,
				  r.open_closed
				  FROM
				  DISCIPLINE_WEAPON_LKUP w,
				  DISCIPLINE_REPORTER_LKUP re,
				  DISCIPLINE_INJURY_LKUP inj,
				  DISCIPLINE_TIME_LKUP t,
				  DISCIPLINE_RECORD r,
				  DISCIPLINE_FACILITIES_LKUP f,
				  DISCIPLINE_INCIDENT_LKUP i,
				  DISCIPLINE_LOCATION_LKUP l,
				  DISCIPLINE_SCHOOL_LKUP s
				  WHERE lower(r.record_identifier) = lower('$identifier')
				  AND r.reporter_id   = re.reporter_id
				  AND w.weapon_id     = r.weapon_id
				  AND inj.injury_id   = r.injury_id
				  AND t.time_id       = r.time_id
				  AND i.incident_id   = r.incident_id
				  AND l.location_id   = r.location_id
				  AND s.school_id     = r.school_id
				  AND f.facilities_id = r.facilities_id;";

		$result = DBQuery($query);
		$row = db_fetch_row($result);

		$date           = $row['RECORD_DATE'];
		$incidentId     = $row['INCIDENT_ID'];
		$incidentDesc   = $row['INCIDENT_DESCRIPTION'];
		$locationId     = $row['LOCATION_ID'];
		$locationDesc   = $row['LOCATION_DESCRIPTION'];
		$schoolId	    = $row['SCHOOL_ID'];
		$schoolDesc     = $row['SCHOOL_DESCRIPTION'];
		$timeId		    = $row['TIME_ID'];
		$timeDesc       = $row['TIME_DESCRIPTION'];
		$facilitiesId   = $row['FACILITIES_ID'];
		$facilitiesDesc = $row['FACILITIES_DESCRIPTION'];
		$injuryId	    = $row['INJURY_ID'];
		$injuryDesc     = $row['INJURY_DESCRIPTION'];
		$weaponId	    = $row['WEAPON_ID'];
		$weaponDesc     = $row['WEAPON_DESCRIPTION'];
		$reporterId	    = $row['REPORTER_ID'];
		$reporterDesc   = $row['REPORTER_DESCRIPTION'];
		$relatedAlcohol = $row['RELATED_ALCOHOL'];
		$relatedDrug    = $row['RELATED_DRUG'];
		$relatedHate    = $row['RELATED_HATE'];
		$relatedWeapon  = $row['RELATED_WEAPON'];
		$relatedGang    = $row['RELATED_GANG'];
		$relatedBully   = $row['RELATED_BULLY'];
		$reportedLaw    = $row['REPORTED_LAW'];
		$cost           = $row['COST'];
		$openClosed     = $row['OPEN_CLOSED'];

	}

	if($date != null){
		$index = strpos($date, '-');
		$month = substr($date,0,$index);
		$date = substr($date,$index+1);

		$index = strpos($date, '-');
		$day = substr($date,0,$index);

		$year = substr($date,$index+1);
	}

	$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
	$monthAbr = array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");

	echo '<table cellspacing="0" cellpadding="0"><tbody><tr><td width="9"/><td class="block_stroke" align="left"><table class="tab_header_bg_active" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr id="tab[]" class="tab_header_bg_active"><td class="tab_header_left_active"/><td class="drawtab_header" align="left" valign="middle">Incident Details</td><td class="tab_header_right_active"/></tr></tbody></table>';

	if($identifier != null){
				echo '<table class="tab_header_bg" style="cursor:pointer;" onclick="discipline.showPerpetrator(\''.$identifier.'\');" cellspacing="0" cellpadding="0" border="0" align="left">
							<tbody>
							<tr id="tab[]" class="tab_header_bg">
							<td class="tab_header_left"/>
							<td class="drawinactivetab_header" align="left" valign="middle">Perpetrators</td>
							<td class="tab_header_right"/>
							</tr>
							</tbody>
				</table>
				<table class="tab_header_bg" cellspacing="0" cellpadding="0" border="0" align="left" style="cursor:pointer;" onclick="discipline.showVictim(\''.$identifier.'\');">
										<tbody>
										<tr id="tab[]" class="tab_header_bg">
										<td class="tab_header_left"/>
										<td class="drawinactivetab_header" align="left" valign="middle">Victim</td>
										<td class="tab_header_right"/>
										</tr>
										</tbody>
				</table>
				<table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" border="0" onclick="discipline.showDiscipline(\''.$identifier.'\');" align="left">
										<tbody>
										<tr id="tab[]" class="tab_header_bg">
										<td class="tab_header_left"/>
										<td class="drawinactivetab_header" align="left" valign="middle">Discipline</td>
										<td class="tab_header_right"/>
										</tr>
										</tbody>
				</table>';
	}
	echo '</td></tr><tr><td class="block_topleft_corner"/><td class="block_topmiddle"/><td class="block_topright_corner"/></tr><tr><td class="block_left" rowspan="2"/><td class="block_bg"/><td class="block_right" rowspan="2"/></tr><tr><td><table class="block_bg" width="100%" cellspacing="0" cellpadding="5"><tbody><tr><td class="block_bg">';

	$html = '<h2>Incident Details</h2><form id="incidentFrm" onsubmit="return false;";>';

	if($edit){
			$html = $html.'<input type="hidden" name="identifier" id="identifierHidden" value="'.strtoupper($identifier).'" />';
	}

	$html = $html.'<table style="width:800px;">';

	if($edit){
		$html = $html.'<tr>
					   <td>Incident Identifier</td>
					   <td align="left" id="identifierDisplay" name="identifierDisplay">'.strtoupper($identifier).'</td>
					   <td>&nbsp;</td></tr>';
	}

	$html = $html.'<tr><td style="width:150px">Date</td><td style="width:210px" align="left"><select size="1" id="monthSelect99" name="incidentMonth">';

	$counter = 1;
	foreach($months as $month_loc){
		$abr = $monthAbr[$counter-1];
		if($counter < 10){
			$counter = '0'.$counter;
		}
		if($edit){
			if($counter == $month){
				$html = $html.'<option selected="true" value="'.$abr.'">'.$month_loc.'</option>';
			}
			else{
				$html = $html.'<option value="'.$abr.'">'.$month_loc.'</option>';
			}
		}
		else{
			if($counter == date('n')){
				$html = $html.'<option selected="true" value="'.$abr.'">'.$month_loc.'</option>';
			}
			else{
				$html = $html.'<option value="'.$abr.'">'.$month_loc.'</option>';
			}
		}
		$counter++;
	}

	$html = $html.'</select><select size="1" id="daySelect99" name="incidentDay">';

	for($i = 1; $i < 32; $i++)
	{
		if($i < 10){
			$i = "0".$i;
		}
		if($edit){
			if($i == $day){
				$html = $html.'<option selected="true" value="'.$i.'">'.$i.'</option>';
			}
			else{
				$html = $html.'<option value="'.$i.'">'.$i.'</option>';
			}
		}
		else{

			if($i == date('d')){
				$html = $html.'<option selected="true" value="'.$i.'">'.$i.'</option>';
			}
			else{
				$html = $html.'<option value="'.$i.'">'.$i.'</option>';
			}
		}
	}

	$html = $html.'</select><select size="1" id="yearSelect99" name="incidentYear">';

	$dateObj = date('Y')+10;
	for($i = $dateObj; $i > (date('Y')-2); $i--){
		if($edit){
			if($year == $i){
				$html = $html.'<option selected="true" value="'.$i.'">'.$i.'</option>';
			}
			else{
				$html = $html.'<option value="'.$i.'">'.$i.'</option>';
			}
		}
		else{
			if($i == date('Y')){
				$html = $html.'<option selected="true" value="'.$i.'">'.$i.'</option>';
			}
			else{
				$html = $html.'<option value="'.$i.'">'.$i.'</option>';
			}
		}
	}

	$html = $html.'</select><img onclick="MakeDate(\'99\',this);" id="calSelect" style="cursor:pointer;" src="assets/jscalendar/img.gif"/></td><td style="width:420px">&nbsp;</td></tr>';

	$options = array();
	$query = "SELECT school_id, school_description FROM DISCIPLINE_SCHOOL_LKUP WHERE hidden != 1 ORDER BY school_id";
	$result = DBQuery($query);
	while($row = db_fetch_row($result)){
		$id   = $row['SCHOOL_ID'];
		$name = $row['SCHOOL_DESCRIPTION'];

		$ddo  = new DropDownOption($name, $name, $id);
		array_push($options, $ddo);
	}
	$html = $html.IncidentCode::buildTableRow(150, 'school', 'school', $options, 'School Name', $schoolId, $schoolDesc);

	$options = array();
		$query = "SELECT time_id, time_description, time_display FROM DISCIPLINE_TIME_LKUP WHERE hidden != 1 ORDER BY time_code";
		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$id   = $row['TIME_ID'];
			$desc = $row['TIME_DESCRIPTION'];
			$display   = $row['TIME_DISPLAY'];

			$ddo  = new DropDownOption($display, $desc, $id);
			array_push($options, $ddo);
		}
	$html = $html.IncidentCode::buildTableRow(150, 'time', 'time', $options, 'Time', $timeId, $timeDesc);

	$options = array();
			$query = "SELECT location_id, location_description, location_display FROM DISCIPLINE_LOCATION_LKUP WHERE hidden != 1 ORDER BY location_code";
			$result = DBQuery($query);
			while($row = db_fetch_row($result)){
				$id   = $row['LOCATION_ID'];
				$desc = $row['LOCATION_DESCRIPTION'];
				$display   = $row['LOCATION_DISPLAY'];

				$ddo  = new DropDownOption($display, $desc, $id);
				array_push($options, $ddo);
			}
	$html = $html.IncidentCode::buildTableRow(150, 'location', 'location', $options, 'Location', $locationId, $locationDesc);

	$options = array();
				$query = "select facilities_id, facilities_description, facilities_display from DISCIPLINE_FACILITIES_LKUP where hidden != 1 order by facilities_code";
				$result = DBQuery($query);
				while($row = db_fetch_row($result)){
					$id   = $row['FACILITIES_ID'];
					$desc = $row['FACILITIES_DESCRIPTION'];
					$display   = $row['FACILITIES_DISPLAY'];

					$ddo  = new DropDownOption($display, $desc, $id);
					array_push($options, $ddo);
				}
	$html = $html.IncidentCode::buildTableRow(150, 'facilities', 'facilities', $options, 'Facilities Code', $facilitiesId, $facilitiesDesc);

	$options = array();
	$query = "SELECT reporter_id, reporter_description, reporter_display FROM DISCIPLINE_REPORTER_LKUP WHERE hidden != 1 ORDER BY reporter_code";
	$result = DBQuery($query);
	while($row = db_fetch_row($result)){
			$id   = $row['REPORTER_ID'];
			$desc = $row['REPORTER_DESCRIPTION'];
			$display   = $row['REPORTER_DISPLAY'];

			$ddo  = new DropDownOption($display, $desc, $id);
			array_push($options, $ddo);
	}
	$html = $html.IncidentCode::buildTableRow(150, 'reporter', 'reporter', $options, 'Reporter', $reporterId, $reporterDesc);

	$options = array();
		$query = "SELECT weapon_id, weapon_description, weapon_display FROM DISCIPLINE_WEAPON_LKUP WHERE hidden != 1 ORDER BY weapon_code";
		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
				$id   = $row['WEAPON_ID'];
				$desc = $row['WEAPON_DESCRIPTION'];
				$display   = $row['WEAPON_DISPLAY'];

				$ddo  = new DropDownOption($display, $desc, $id);
				array_push($options, $ddo);
		}
	$html = $html.IncidentCode::buildTableRow(150, 'weapon', 'weapon', $options, 'Weapon', $weaponId, $weaponDesc);

	$options = array();
			$query = "SELECT injury_id, injury_description, injury_display FROM DISCIPLINE_INJURY_LKUP WHERE hidden != 1 ORDER BY injury_code";
			$result = DBQuery($query);
			while($row = db_fetch_row($result)){
					$id   = $row['INJURY_ID'];
					$desc = $row['INJURY_DESCRIPTION'];
					$display   = $row['INJURY_DISPLAY'];

					$ddo  = new DropDownOption($display, $desc, $id);
					array_push($options, $ddo);
				}
	$html = $html.IncidentCode::buildTableRow(150, 'injury', 'injury', $options, 'Injury', $injuryId, $injuryDesc);

	$options = array();
					$query = "SELECT incident_id, incident_description, incident_display FROM DISCIPLINE_INCIDENT_LKUP WHERE hidden != 1 ORDER BY incident_code";
					$result = DBQuery($query);
					while($row = db_fetch_row($result)){
							$id   = $row['INCIDENT_ID'];
							$desc = $row['INCIDENT_DESCRIPTION'];
							$display   = $row['INCIDENT_DISPLAY'];

							$ddo  = new DropDownOption($display, $desc, $id);
							array_push($options, $ddo);
					}
	$html = $html.IncidentCode::buildTableRow(150, 'incident', 'incident', $options, 'Incident Code', $incidentId, $incidentDesc);

	$html = $html.IncidentCode::buildYesNoTableRow(75, 'alcoholRelated', 'alcoholRelated', 'Related to Alcohol', $relatedAlcohol);
	$html = $html.IncidentCode::buildYesNoTableRow(75, 'drugRelated', 'drugRelated', 'Related to Drug', $relatedDrug);
	$html = $html.IncidentCode::buildYesNoTableRow(75, 'gangRelated', 'gangRelated', 'Related to Gang', $relatedGang);
	$html = $html.IncidentCode::buildYesNoTableRow(75, 'hateRelated', 'hateRelated', 'Related to Hate', $relatedHate);
	$html = $html.IncidentCode::buildYesNoTableRow(75, 'weaponRelated', 'weaponRelated', 'Related to Weapon', $relatedWeapon);
	$html = $html.IncidentCode::buildYesNoTableRow(75, 'bullyingRelated', 'bullyingRelated', 'Related to Bullying', $relatedBully);
	$html = $html.IncidentCode::buildYesNoTableRow(75, 'reportedLaw', 'reportedLaw', 'Reported to Law Enforcement', $reportedLaw);
	$html = $html.'<tr><td>Cost</td><td align="left">';
	if($edit){
		$html = $html.'<input style="width:75px;" name="cost" type="text" value="'.$cost.'" />';
	}
	else{
		$html = $html.'<input style="width:75px;" name="cost" type="text" value="0.00" />';
	}
	$html = $html.'</td><td>&nbsp;</td></tr>';

	$html= $html.'<tr>';
	if($edit){
		$html= $html.'<tr><td>Open | Closed</td><td><select name="openClosed">';
		if($openClosed == 1){
			$html= $html.'<option value="1" selected="true">Open</option><option value="2">Closed</option></select>';
		}
		else{
			$html= $html.'<option value="1">Open</option><option value="2" selected="true">Closed</option></select>';
		}
		$html= $html.'</td><td>&nbsp;</td></tr>';
		$html= $html.'<tr><td colspan="3" align="center"><input type="button" value="Save" onclick="discipline.save();"/>';
	}
	else{
		$html= $html.'<td colspan="3" align="center"><input type="button" value="Save" onclick="discipline.createNew();"/>';
	}

	if(!$edit){
		$html= $html.' | <input type="button" value="Reset" onclick="discipline.reset();" />';
	}
	else{
		$html= $html.' | <input type="button" value="New" onclick="discipline.reset();" />';
	}

	$html= $html.'</td></tr></table></form>';

	echo($html);

	echo '</td></tr></tbody></table></td></tr><tr><td class="block_left_corner"/><td class="block_middle"/><td class="block_right_corner"/></tr><tr><td class="clear" colspan="3"/></tr></tbody></table>';

}
else
if($module == 1){
	require_once('classes/Perpetrator.php');

	echo '<table cellspacing="0" cellpadding="0"><tbody><tr><td width="9"/><td class="block_stroke" align="left">';

	echo '<table class="tab_header_bg" style="cursor:pointer" onclick="discipline.showDetails(\''.$identifier.'\');" cellspacing="0" cellpadding="0" border="0" align="left">
			<tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
			<td class="drawinactivetab_header" align="left" valign="middle">Incident Details</td>
			<td class="tab_header_right"/></tr>
		  </tbody></table>
		  <table class="tab_header_bg_active" cellspacing="0" cellpadding="0" onclick="discipline.showPerpetrator(\''.$identifier.'\');" border="0" align="left">
			<tbody><tr id="tab[]" class="tab_header_bg_active">
			<td class="tab_header_left_active"/><td class="drawtab_header" align="left" valign="middle">Perpetrators</td>
			<td class="tab_header_right_active"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" onclick="discipline.showVictim(\''.$identifier.'\');" border="0" align="left">
			<tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
			<td class="drawinactivetab_header" align="left" valign="middle">Victim</td>
			<td class="tab_header_right"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" onclick="discipline.showDiscipline(\''.$identifier.'\');" border="0" align="left">
		  <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
		  <td class="drawinactivetab_header" align="left" valign="middle">Discipline</td>
		  <td class="tab_header_right"/></tr></tbody>
		  </table>';
	echo '</td></tr><tr><td class="block_topleft_corner"/><td class="block_topmiddle"/><td class="block_topright_corner"/></tr><tr><td class="block_left" rowspan="2"/><td class="block_bg"/><td class="block_right" rowspan="2"/></tr><tr><td><table class="block_bg" width="100%" cellspacing="0" cellpadding="5"><tbody><tr><td class="block_bg">';


	if($identifier != null){
		$html = '<h2>Perpetrators</h2><table style="width:800px;">';

		$result = Perpetrator::getPerpetratorsPage($identifier);
		while($row = db_fetch_row($result)){
			$id  		  = $row['PERPETRATOR_ID'];
			$name         = $row['PERPETRATOR_NAME'];
			$perpDisplay  = $row['PERPETRATOR_DISPLAY'];
			$injury       = $row['INJURY_DISPLAY'];

			$html = $html.'<tr><td><hr/></td></tr><tr><td>';

			$html = $html.'<table style="width:300px;padding:2px 2px 2px 2px;">
					<tr><td style="width:130px;">Perpetrator</td><td style="width:130px;">'.$name.'</td><td style="width:40px;" align=""right"><img onclick="discipline.removePerpetrator('.$id.');" style="cursor:pointer;" src="modules/Discipline/images/remove_button.gif" /></td></tr>
					<tr><td>Perpetrator Type</td><td colspan="2">'.$perpDisplay.'</td></tr>
					<tr><td>Injury</td><td colspan="2"> '.$injury.'</td></tr>
				    </table>';

			$html = $html.'</td></tr>';

		}

		$html = $html.'<tr><td><hr/></td></tr><tr><td>
					   	<table><input type="hidden" id="identifier" value="'.$identifier.'" />
							<tr><td colspan="2" style="font-size:14px;font-weight:bold;">Add Perpetrator</td></tr>
							<tr><td>Perpetrator Type</td><td>'.IncidentCode::buildPerpetratorSelect().'</td></tr>
							<tr id="perpetratorTR" style="display:none"><td>Perpetrator</td><td><input type="hidden" name="perpId" id="perpIdHI" /><input type="text" id="perpInput" name="perpName" style="width:150px;" />&nbsp;<input type="button" style="display:none;cursor:pointer;" id="searchBtn" onclick="discipline.searchUsers();" value="Search" /></td></tr>
							<tr><td colspan="2" id="searchResults" style="display:none"></td></tr>
							<tr id="injuryTR" style="display:none"><td>Injury</td><td>'.IncidentCode::buildInjurySelect().'</td></tr>
							<tr id="buttonsTR" style="display:none"><td colspan="2"><input style="cursor:pointer;" type="button" onclick="discipline.addPerp();"  value="Save" /></td></tr>
					   	</table>
					   </td></tr><tr><td><hr/></td></tr>';

		$html = $html.'</table>';

		echo $html;
	}

	echo '</td></tr></tbody></table></td></tr><tr><td class="block_left_corner"/><td class="block_middle"/><td class="block_right_corner"/></tr><tr><td class="clear" colspan="3"/></tr></tbody></table>';

}
else
if($module == 2){
	require_once('classes/Victim.php');

	echo '<table cellspacing="0" cellpadding="0"><tbody><tr><td width="9"/><td class="block_stroke" align="left">';

	echo '<table class="tab_header_bg" cellspacing="0" style="cursor:pointer;" cellpadding="0" border="0" onclick="discipline.showDetails(\''.$identifier.'\');" align="left">
		    <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
		    <td class="drawinactivetab_header" align="left" valign="middle">Incident Details</td>
		    <td class="tab_header_right"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" border="0" onclick="discipline.showPerpetrator(\''.$identifier.'\');" align="left">
		  		    <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
		  		    <td class="drawinactivetab_header" align="left" valign="middle">Perpetrator</td>
		  		    <td class="tab_header_right"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg_active" cellspacing="0" cellpadding="0" border="0" align="left">
		      <tbody><tr id="tab[]" class="tab_header_bg_active">
		  	  <td class="tab_header_left_active"/><td class="drawtab_header" align="left" valign="middle">Victim</td>
		  	  <td class="tab_header_right_active"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" border="0" onclick="discipline.showDiscipline(\''.$identifier.'\');" align="left">
			  <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
			  <td class="drawinactivetab_header" align="left" valign="middle">Discipline</td>
			  <td class="tab_header_right"/></tr></tbody>
		  </table>';
	echo '</td></tr><tr><td class="block_topleft_corner"/><td class="block_topmiddle"/><td class="block_topright_corner"/></tr><tr><td class="block_left" rowspan="2"/><td class="block_bg"/><td class="block_right" rowspan="2"/></tr><tr><td><table class="block_bg" width="100%" cellspacing="0" cellpadding="5"><tbody><tr><td class="block_bg">';


	if($identifier != null){
		$html = '<h2>Victims</h2><table style="width:800px;">';

		$result = Victim::getVictims($identifier);
		while($row = db_fetch_row($result)){
			$id  		  = $row['VICTIM_ID'];
			$name         = $row['VICTIM_NAME'];
			$victimDisplay  = $row['VICTIM_DISPLAY'];
			$injury       = $row['INJURY_DISPLAY'];

			$html = $html.'<tr><td><hr/></td></tr><tr><td>';

			$html = $html.'<table style="width:300px;padding:2px 2px 2px 2px;">
					<tr><td style="width:130px;">Victim</td><td style="width:130px;">'.$name.'</td><td style="width:40px;" align=""right"><img onclick="discipline.removeVictim('.$id.');" style="cursor:pointer;" src="modules/Discipline/images/remove_button.gif" /></td></tr>
					<tr><td>Victim Type</td><td colspan="2">'.$victimDisplay.'</td></tr>
					<tr><td>Injury</td><td colspan="2"> '.$injury.'</td></tr>
				    </table>';

			$html = $html.'</td></tr>';

		}

		$html = $html.'<tr><td><hr/></td></tr><tr><td>
					   	<table><input type="hidden" id="identifier" value="'.$identifier.'" />
							<tr><td colspan="2" style="font-size:14px;font-weight:bold;">Add Victim</td></tr>
							<tr><td>Victim Type</td><td>'.IncidentCode::buildVictimSelect().'</td></tr>
							<tr><td>Victim</td><td><input type="text" id="victimName" style="width:150px;" /></td></tr>
							<tr><td>Injury</td><td>'.IncidentCode::buildInjurySelect().'</td></tr>
							<tr><td colspan="2"><input style="cursor:pointer;" type="button" onclick="discipline.addVictim();"  value="Save" /></td></tr>
					   	</table>
					   </td></tr><tr><td><hr/></td></tr>';

		$html = $html.'</table>';

		echo $html;
	}

	echo '</td></tr></tbody></table></td></tr><tr><td class="block_left_corner"/><td class="block_middle"/><td class="block_right_corner"/></tr><tr><td class="clear" colspan="3"/></tr></tbody></table>';
}
else
if($module == 3){
	require_once('classes/Discipline.php');
	require_once('classes/Perpetrator.php');

	echo '<table cellspacing="0" cellpadding="0"><tbody><tr><td width="9"/><td class="block_stroke" align="left">';

	echo '<table class="tab_header_bg" cellspacing="0" style="cursor:pointer;" cellpadding="0" border="0" onclick="discipline.showDetails(\''.$identifier.'\');" align="left">
		    <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
		    <td class="drawinactivetab_header" align="left" valign="middle">Incident Details</td>
		    <td class="tab_header_right"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" border="0" onclick="discipline.showPerpetrator(\''.$identifier.'\');" align="left">
		  		    <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
		  		    <td class="drawinactivetab_header" align="left" valign="middle">Perpetrator</td>
		  		    <td class="tab_header_right"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg" cellspacing="0" cellpadding="0" style="cursor:pointer;" border="0" onclick="discipline.showVictim(\''.$identifier.'\');" align="left">
		  		  		    <tbody><tr id="tab[]" class="tab_header_bg"><td class="tab_header_left"/>
		  		  		    <td class="drawinactivetab_header" align="left" valign="middle">Victim</td>
		  		  		    <td class="tab_header_right"/></tr></tbody>
		  </table>
		  <table class="tab_header_bg_active" cellspacing="0" cellpadding="0" border="0" align="left">
		      <tbody><tr id="tab[]" class="tab_header_bg_active">
		  	  <td class="tab_header_left_active"/><td class="drawtab_header" align="left" valign="middle">Discipline</td>
		  	  <td class="tab_header_right_active"/></tr></tbody>
		  </table>';
	echo '</td></tr><tr><td class="block_topleft_corner"/><td class="block_topmiddle"/><td class="block_topright_corner"/></tr><tr><td class="block_left" rowspan="2"/><td class="block_bg"/><td class="block_right" rowspan="2"/></tr><tr><td><table class="block_bg" width="100%" cellspacing="0" cellpadding="5"><tbody><tr><td class="block_bg">';


	if($identifier != null){
		$html = '<input type="hidden" value="'.$identifier.'" id="identifierHi" /><table style="width:800px;">';

		$perps = Perpetrator::getPerpetrators_Discipline($identifier);

		foreach($perps as $perp){
			$html = $html.'<tr><td style="font-weight:bold;font-size:16px;">'.$perp->name.'</td></tr>';
			$html = $html.'<tr><td><hr/></td></tr>';
			$html = $html.'<tr><td id="currentDisciplines_'.$perp->id.'" ><table>';

			$result = Discipline::getDisciplineActionsDisplay($identifier, $perp->id);
			while($row = db_fetch_row($result)){

				$id        = $row['ID'];
				$display   = $row['DISPLAY'];
				$startDate = $row['START_DATE'];
				$endDate   = $row['END_DATE'];
				$specialEd = $row['ED'];
				$policy	   = $row['POLICY'];
				$full  	   = $row['FULL'];
				$short     = $row['SHORT'];
				$type      = $row['TYPE'];


				$html = $html.'<tr><td><a id="showDetialsA_'.$id.'" href="javascript:void(\'0\');" onclick="discipline.getDisciplineActionDetails('.$id.', '.$perp->id.');" style="text-decoration:none;">[+]</a></td><td>'.$display.'</td>
				<td>'.$startDate.' - '.$endDate.'</td></tr>';
				$html = $html.'<tr><td>&nbsp;</td><td colspan="2" id="disciplineDetails_'.$id.'"></td</tr>
							   <tr><td colspan="3" id="editDisciplineArea_'.$id.'" style="display:none;">
							   <form id="editDisciplineFrm_'.$id.'">
							   <table>
								<tr><td>Disciplinary Action</td><td>'.IncidentCode::buildDisciplineSelect($id.$perp->id).'</td></tr>
								<tr><td>Start Date of Discipline Action</td><td>'.buildDateSelect('startDate', $id.$perp->id.'99').'</td></tr>
								<tr><td>End Date of Discipline Action</td><td>'.buildDateSelect('endDate', $id.$perp->id.'98').'</td></tr>
								<tr><td>Related to Special Education<br/>Manifestation Hearing</td><td><select id="specialEd_'.$id.$perp->id.'" name="specialEd"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
								<tr><td>Related to Zero Tolerance<br/>Policy</td><td><select name="zeroPolicy" id="zeroPolicy_'.$id.$perp->id.'"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
								<tr><td>Full Year Expulsion</td><td><select name="fullExpulsion" id="fullExp_'.$id.$perp->id.'"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
								<tr><td>Shortened Expulsion</td><td><select name="shortExpulsion" id="shortExp_'.$id.$perp->id.'"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
								<tr><td colspan="2" style="font-size:16px;">
								<input type="button" id="saveFrmBtn_'.$id.$perp->id.'" style="cursor:pointer;" value="Update" /> | <a href="javascript:discipline.cancelEditDisciplinaryAction('.$id.', '.$perp->id.');">Cancel</a>
								</td></tr>
							   </table>
							   </form>
							   </td></tr>';
			}

			$html = $html.'</table></td></tr>';
			$html = $html.'<tr id="addDiscplineBtn_'.$perp->id.'"><td><a style="text-decoration:none;" href="javascript:discipline.ShowAddDisciplineAction('.$perp->id.');" >(Add Disciplinary Action)</a></td></tr>
						   <tr id="disciplineWorkArea_'.$perp->id.'" style="display:none;" ><td>
					       <form id="newDisciplineFrm_'.$perp->id.'">
					       <input type="hidden" value="'.$identifier.'" id="identifier" name="identifier" />
					       <input type="hidden" value="'.$perp->id.'" name="perpid" />
					       <table>
						   	<tr><td>Disciplinary Action</td><td>'.IncidentCode::buildDisciplineSelect($perp->id).'</td></tr>
					        <tr><td>Start Date of Discipline Action</td><td>'.buildDateSelect('startDate', $perp->id.'99').'</td></tr>
					        <tr><td>End Date of Discipline Action</td><td>'.buildDateSelect('endDate', $perp->id.'98').'</td></tr>
					        <tr><td>Related to Special Education<br/>Manifestation Hearing</td><td><select id="specialEd_'.$perp->id.'" name="specialEd"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
					       	<tr><td>Related to Zero Tolerance<br/>Policy</td><td><select name="zeroPolicy" id="zeroPolicy_'.$perp->id.'"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
					        <tr><td>Full Year Expulsion</td><td><select name="fullExpulsion" id="fullExp_'.$perp->id.'"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
					       	<tr><td>Shortened Expulsion</td><td><select name="shortExpulsion" id="shortExp_'.$perp->id.'"><option value="2">No</option><option value="1">Yes</option></select></td></tr>
					       	<tr><td colspan="2" style="font-size:16px;">
					       	<a id="saveFrmBtn_'.$perp->id.'" href="javascript:void(\'0\');">Add</a> | <a href="javascript:discipline.hideDisciplineWorkarea('.$perp->id.');">Cancel</a>
					        </td></tr>
					       </table>
					       </form>
					       </td></tr><tr><td>&nbsp;</td></tr>';
		}

		$html = $html.'</table>';

		echo $html;
	}

	echo '</td></tr></tbody></table></td></tr><tr><td class="block_left_corner"/><td class="block_middle"/><td class="block_right_corner"/></tr><tr><td class="clear" colspan="3"/></tr></tbody></table>';
}

function buildDateSelect($name, $id){
		$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
		$monthAbr = array("JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");

		$html = '<select size="1" id="monthSelect'.$id.'" name="'.$name.'Month">';

		$counter = 1;

		foreach($months as $month_loc){
			$abr = $monthAbr[$counter-1];
			if($counter < 10){
				$counter = '0'.$counter;
			}

			$html = $html.'<option value="'.$abr.'">'.$month_loc.'</option>';
			$counter++;
		}

		$html = $html.'</select><select size="1" id="daySelect'.$id.'" name="'.$name.'Day">';

		for($i = 1; $i < 32; $i++)
		{
			if($i < 10){
				$i = "0".$i;
			}
			$html = $html.'<option value="'.$i.'">'.$i.'</option>';
		}

		$html = $html.'</select><select size="1" id="yearSelect'.$id.'" name="'.$name.'Year">';

		$dateObj = date('Y')+10;
		for($i = $dateObj; $i > (date('Y')-2); $i--){
			if($i == date('Y')){
				$html = $html.'<option selected="true" value="'.$i.'">'.$i.'</option>';
			}
			else{
				$html = $html.'<option value="'.$i.'">'.$i.'</option>';
			}
		}

	$html = $html.'</select><img onclick="MakeDate(\''.$id.'\',this);" id="calSelect_'.$id.'" style="cursor:pointer;" src="assets/jscalendar/img.gif"/>';
	return $html;
}
?>