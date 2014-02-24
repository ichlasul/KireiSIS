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

Class IncidentCode
{
	function IncidentCode()
	{

	}

	public static function buildYesNoTableRow($width, $id, $name, $fieldName, $setId){
		$html = '<tr><td>'.$fieldName.'</td><td align="left">
				 <select style="width:'.$width.'px;" name="'.$name.'" id="'.$id.'">';
			 	 if($setId == 2){
			 	 	$html = $html.'<option value="3">No</option>
			 	 	               <option value="2" selected="true">Yes</option>';
			 	 }
			 	 else{
			 	 	$html = $html.'<option value="3">No</option>
			 	 				   <option value="2">Yes</option>';
			 	 }

		$html = $html.'</select></td><td>&nbsp;</td></tr>';

		return $html;
	}

	public static function buildTableRow($width, $id, $name, $options, $fieldName, $setId, $desc=''){
		$html = '<tr><td style="vertical-align:top;">'.$fieldName.'</td><td align="left" style="vertical-align:top;">
				<select onchange="discipline.getDesc(this)" id="'.$id.'" name="'.$name.'" style="width:'.$width.'px;">
				<option value="0">Select</option>';

		foreach($options as $option){
			if($option->id == $setId){
				$html = $html.'<option value="'.$option->id.'" selected="true">'.$option->display.'</option>';
			}
			else{
				$html = $html.'<option value="'.$option->id.'">'.$option->display.'</option>';
			}

		}
		$html = $html.'</select></td><td id="'.$id.'_td">'.$desc.'</td></tr>';
		return $html;
	}

	public static function buildPerpetratorSelect(){
		$html = '<select name="perpetratorType" id="perpTypeSel" onchange="discipline.selectPerpType(this);"><option value="0">Select Perpetrator Type</option>';

		$query = "SELECT
				  perpetrator_display,
				  perpetrator_code
				  FROM DISCIPLINE_PERPETRATOR_LKUP WHERE hidden != 1 ORDER BY perpetrator_code";
		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$html = $html.'<option value="'.$row['PERPETRATOR_CODE'].'">'.$row['PERPETRATOR_DISPLAY'].'</option>';
		}

		$html = $html.'</select>';
		return $html;
	}

	public static function buildVictimSelect(){
			$html = '<select name="victimType" id="victimTypeSel" onchange=""><option value="0">Select Victim Type</option>';

			$query = "SELECT
					  victim_display,
					  victim_id
					  FROM DISCIPLINE_VICTIM_LKUP WHERE hidden != 1 ORDER BY victim_code";
			$result = DBQuery($query);
			while($row = db_fetch_row($result)){
				$html = $html.'<option value="'.$row['VICTIM_ID'].'">'.$row['VICTIM_DISPLAY'].'</option>';
			}

			$html = $html.'</select>';
			return $html;
	}

	public static function buildInjurySelect(){
		$html = '<select id="injuryType">';

		$query = "SELECT injury_display, injury_id FROM DISCIPLINE_INJURY_LKUP WHERE hidden != 1 ORDER BY injury_code";
		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$html = $html.'<option value="'.$row['INJURY_ID'].'">'.$row['INJURY_DISPLAY'].'</option>';
		}

		$html = $html.'</select>';
		return $html;

	}

	public static function buildDisciplineSelect($id){
		$html = '<select name="disciplineType" id="disciplineType_'.$id.'">';

		$query = "SELECT discipline_display, discipline_id FROM DISCIPLINE_DISCIPLINE_LKUP WHERE hidden != 1 ORDER BY discipline_code";
		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$html = $html.'<option value="'.$row['DISCIPLINE_ID'].'">'.$row['DISCIPLINE_DISPLAY'].'</option>';
		}

		$html = $html.'</select>';
		return $html;
	}

	public static function getTableName($codeType){
		$tableName;
		switch($codeType){
					case 1:
						$tableName = "facilities";
					break;
					case 2:
						$tableName = "incident";
					break;
					case 3:
						$tableName = "injury";
					break;
					case 4:
						$tableName = "location";
					break;
					case 5:
						$tableName = "reporter";
					break;
					case 6:
						$tableName = "time";
					break;
					case 7:
						$tableName = "weapon";
					break;
					case 8:
						$tableName = "perpetrator";
					break;
					case 9:
						$tableName = "victim";
					break;
					case 10:
						$tableName = "discipline";
					break;
		}
		return $tableName;
	}

	public static function addCode($codeType, $code, $display, $desc, $hidden){
		$tableName = IncidentCode::getTableName($codeType);

		$desc    = mysql_escape_string($desc);
		$display = mysql_escape_string($display);

		$query = "INSERT INTO DISCIPLINE_".strtoupper($tableName)."_LKUP
				  (".$tableName."_code, ".$tableName."_display, ".$tableName."_description, hidden, ".$tableName."_id)
				  VALUES
				  ('$code', '$display', '$desc', $hidden, nextval('discipline_".$tableName."_seq'))";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function updateCode($codeType, $code, $display, $desc, $id, $hidden){
		$tableName = IncidentCode::getTableName($codeType);

		$query = "UPDATE DISCIPLINE_".strtoupper($tableName)."_LKUP
		          SET
		          ".$tableName."_code = '$code',
				  ".$tableName."_display = '$display',
				  ".$tableName."_description = '$desc',
				  hidden = $hidden
				  WHERE ".$tableName."_id = $id";

		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function getCodes($codeType){
		$tableName = IncidentCode::getTableName($codeType);
		$json = '"codes":[';

		$query = "SELECT
		          ".$tableName."_id,
				  ".$tableName."_code,
				  ".$tableName."_display,
				  ".$tableName."_description,
				  hidden
				  FROM DISCIPLINE_".strtoupper($tableName)."_LKUP";

		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$id      = $row[strtoupper($tableName).'_ID'];
			$code    = $row[strtoupper($tableName).'_CODE'];
			$display = $row[strtoupper($tableName).'_DISPLAY'];
			$desc    = $row[strtoupper($tableName).'_DESCRIPTION'];
			$hidden  = $row['HIDDEN'];
			$desc    = str_replace('"','\\"',$desc);
			$display = str_replace('"','\\"',$display);
			$json = $json.'{
							"id":"'.$id.'",
						    "code":"'.$code.'",
						    "display":"'.$display.'",
						    "desc":"'.$desc.'",
						    "hidden":"'.$hidden.'"},';
		}
        $json = rtrim($json, ",");
		$json = $json.']';
		return $json;
	}
}
?>