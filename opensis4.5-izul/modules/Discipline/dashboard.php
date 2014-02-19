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

$schoolId   = $_GET['schoolid'];
$timeId     = $_GET['timeid'];
$timestamp  = $_GET['timestamp'];
$identifier = $_GET['identifier'];
$openClosed = $_GET['openClosed'];



echo '<table cellspacing="0" cellpadding="0">
		<tbody>
		<tr>
		<td width="9"/>
		<td class="block_stroke" align="left">
			<table class="tab_header_bg_active" cellspacing="0" cellpadding="0" border="0" align="left">
			<tbody>
			<tr id="tab[]" class="tab_header_bg_active">
			<td class="tab_header_left_active"/>
			<td class="drawtab_header" align="left" valign="middle">Dashboard</td>
			<td class="tab_header_right_active"/>
			</tr>
			</tbody>
			</table>
		</td>
		</tr>
		<tr>
		<td class="block_topleft_corner"/>
		<td class="block_topmiddle"/>
		<td class="block_topright_corner"/>
		</tr>
		<tr>
		<td class="block_left" rowspan="2"/>
		<td class="block_bg"/>
		<td class="block_right" rowspan="2"/>
		</tr>
		<tr><td >
		<table class="block_bg" width="100%" cellspacing="0" cellpadding="5">
		<tbody>
		<tr>
	<td class="block_bg">';

	$html = '<table cellspacing="0" cellpadding="0" width="800px">
				<tr style="font-size:20px;font-weight:bold;">
		        	<td>Incidents</td>
		        	<td>School</td>
		        	<td>Date</td>
		        	<td>Time</td>
		        	<td>&nbsp;</td>
	        	</tr>
	        	<tr >
					<td style="width:130px;"><select style="width:130px;" onchange="discipline.filterDashboard();" id="openClsoedFilter">';
	if($openClosed == 1){
		$html = $html.'<option value="0">All Incidents</option>
					   <option value="1" selected="true">Open Incidents</option>
					   <option value="2">Closed Incidents</option>';
	}
	else
	if($openClosed == 2){
		$html = $html.'<option value="0">All Incidents</option>
					   <option value="1">Open Incidents</option>
					   <option value="2" selected="true">Closed Incidents</option>';
	}
	else{
		$html = $html.'<option value="0">All Incidents</option>
					   <option value="1">Open Incidents</option>
					   <option value="2">Closed Incidents</option>';
	}

	$html = $html.'</select></td>';

	$html = $html.'<td style="width:150px;"><select style="width:150px;" onchange="discipline.filterDashboard();" id="schoolFilter"><option>All Schools</option>';

	$query = "SELECT school_id, school_description FROM DISCIPLINE_SCHOOL_LKUP WHERE hidden != 1 ORDER BY school_id";
	$result  = DBQuery($query);
	while($row = db_fetch_row($result)){

		if($schoolId == $row['SCHOOL_ID']){
			$html = $html.'<option value="'.$row['SCHOOL_ID'].'" selected="true">'.$row['SCHOOL_DESCRIPTION'].'</option>';
		}
		else{
			$html = $html.'<option value="'.$row['SCHOOL_ID'].'">'.$row['SCHOOL_DESCRIPTION'].'</option>';
		}

	}

	$dateSelect = array("All Dates",
						"Last Six Months",
						"Last Three Months",
						"Last Two Months",
						"This Month",
						"This Week",
						"Yesterday",
						"Today");

	$html = $html.'</select></td><td style="width:130px;"><select onchange="discipline.filterDashboard();" id="timestampFilter" style="width:130px;">';

	$counter = 0;
	foreach($dateSelect as $option){
		if($counter == $timestamp){
			$html = $html.'<option value="'.$counter.'" selected="true">'.$option.'</option>';
		}
		else{
			$html = $html.'<option value="'.$counter.'">'.$option.'</option>';
		}
		$counter++;
	}

	$html = $html.'</select></td><td style="width:210px;"><select style="width:210px;" onchange="discipline.filterDashboard();" id="timeFilter"><option>All Time Periods</option>';

		$query = "select time_id, time_display from DISCIPLINE_TIME_LKUP where hidden != 1";
		$result  = DBQuery($query);
		while($row = db_fetch_row($result)){

			if($timeId == $row['TIME_ID']){
				$html = $html.'<option value="'.$row['TIME_ID'].'" selected="true">'.$row['TIME_DISPLAY'].'</option>';
			}
			else{
				$html = $html.'<option value="'.$row['TIME_ID'].'">'.$row['TIME_DISPLAY'].'</option>';
			}
		}

	$html = $html.'</select></td><td width="180px">';
	if($identifier != null){
		$html = $html.'<input type="text" style="width:130px;" onblur="discipline.checkIdentifier(this);" onfocus="discipline.clearIdentifier(this);" id="searchIdentifier" value="'.$identifier.'" />';
	}
	else{
		$html = $html.'<input type="text" style="width:130px;" onblur="discipline.checkIdentifier(this);" onfocus="discipline.clearIdentifier(this);" id="searchIdentifier" value="Indentifier Search" />';
	}


	$html = $html.'&nbsp;<a href="javascript:discipline.searchIdentifier();">Search</a></td>
	        	   </tr><tr><td colspan="5">&nbsp;</td></tr></table><table cellspacing="0" cellpadding="0" width="800px">';

	$query = "SELECT
			  r.record_identifier,
			  t.time_display,
			  r.open_closed,
			  s.school_description,
			  r.record_date AS record_date
			  FROM
			  DISCIPLINE_SCHOOL_LKUP s,
			  DISCIPLINE_TIME_LKUP t,
			  DISCIPLINE_RECORD r
			  WHERE
			  s.school_id = r.school_id
			  AND t.time_id = r.time_id";

	if($schoolId != null && $schoolId != 0){
		$query = $query." AND r.school_id = $schoolId";
	}

	if($timeId != null && $timeId != 0){
		$query = $query." AND r.time_id = $timeId";
	}

	if($timestamp != null && $timestamp != 0){
				$query = $query.buildTimeQuery($timestamp);
	}

	if($identifier != null && $identifier != ''){
		$query = $query." AND lower(r.record_identifier) LIKE lower('%$identifier%')";
	}

	if($openClosed != null && $openClosed != 0){
			$query = $query." AND r.open_closed = $openClosed";
	}

	$query = $query." ORDER BY r.record_date asc;";

	$counter = 0;
	$result  = DBQuery($query);
	while($row = db_fetch_row($result)){

		$identifer  = $row['RECORD_IDENTIFIER'];
		$time       = $row['TIME_DISPLAY'];
		$date       = $row['RECORD_DATE'];
		$school     = $row['SCHOOL_DESCRIPTION'];
		$openClosed = $row['OPEN_CLOSED'];

		if($openClosed == 1){
			$openClosed = "Open";
		}
		else{
			$openClosed = "Closed";
		}

		if($counter % 2 == 0){
			$html = $html.'<tr style="background-color:#FFFF99;cursor:pointer;" onclick="discipline.editIncident(\''.$identifer.'\');" onmouseover="this.style.backgroundColor = \'yellow\'" onmouseout="this.style.backgroundColor=\'#FFFF99\'">
								<td style="width:130px;">'.$openClosed.'</td>
								<td style="width:150px;">'.$school.'</td>
								<td style="width:130px;">'.$date.'</td>
								<td style="width:180px;">'.$time.'</td>
								<td style="width:210px;">'.$identifer.'</td>
	        				</tr>';
		}
		else{
			$html = $html.'<tr style="cursor:pointer;" onclick="discipline.editIncident(\''.$identifer.'\');" onmouseover="this.style.backgroundColor = \'yellow\'" onmouseout="this.style.backgroundColor=\'\'">
								<td style="width:130px;">'.$openClosed.'</td>
								<td style="width:150px;">'.$school.'</td>
								<td style="width:130px;">'.$date.'</td>
								<td style="width:180px;">'.$time.'</td>
								<td style="width:210px;">'.$identifer.'</td>
	        			   </tr>';
		}
		$counter++;
	}

	$html = $html.'</table>';

	echo $html;

echo '</td></tr></tbody></table></td></tr><tr><td class="block_left_corner"/><td class="block_middle"/><td class="block_right_corner"/></tr><tr><td class="clear" colspan="3"/></tr></tbody></table>';


function buildTimeQuery($timestamp){
	/*
	0 = All Dates
	1 = Last Six Months
	2 = Last Three Months
	3 = Last Two Months
	4 = This Month
	5 = This Week
	6 = Yesterday
	7 = Today
	*/

	$query;
	switch($timestamp){
		case 1:
					return " and r.record_date > current_timestamp - interval '180 days' and r.record_date < current_timestamp";
		break;
		case 2:
					return " and r.record_date > current_timestamp - interval '90 days' and r.record_date < current_timestamp";
		break;
		case 3:
					return " and r.record_date > current_timestamp - interval '60 days' and r.record_date < current_timestamp";
		break;
		case 4:
					return " and r.record_date > current_timestamp - interval '30 days' and r.record_date < current_timestamp";
		break;
		case 5:
					return " and r.record_date > current_timestamp - interval '1 week' and r.record_date < current_timestamp";
		break;
		case 6:
					return " and r.record_date = current_timestamp - interval '1 day'";
		break;
		case 7:
					return " and r.record_date > current_timestamp - interval '1 day' and r.record_date < current_timestamp + interval '1 day'";
		break;
		default:
			return '';
		break;
	}
}

?>