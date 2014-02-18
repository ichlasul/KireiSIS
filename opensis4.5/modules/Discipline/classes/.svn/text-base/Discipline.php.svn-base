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

Class Discipline
{
	public static function generateIdentifier(){
		$date = Date(ymdHis);
		$token = md5(uniqid());
		$better_token = md5(uniqid(rand(), true)+$date);
		$key = strtoupper($better_token);

		$key = substr($key,0,24);

		return $key;
	}

	public static function createIncident(){
		$identifier     = Discipline::generateIdentifier();
		$month			= $_POST['incidentMonth'];
		$day			= $_POST['incidentDay'];
		$year			= $_POST['incidentYear'];
		$incidentId	    = $_POST['incident'];
		$locationId		= $_POST['location'];
		$schoolId		= $_POST['school'];
		$timeId			= $_POST['time'];
		$facilitiesId	= $_POST['facilities'];
		$injuryId		= $_POST['injury'];
		$weaponId		= $_POST['weapon'];
		$reporterId		= $_POST['reporter'];
		$relatedAlcohol = $_POST['alcoholRelated'];
		$relatedDrug	= $_POST['drugRelated'];
		$relatedHate	= $_POST['hateRelated'];
		$relatedWeapon  = $_POST['weaponRelated'];
		$relatedGang	= $_POST['gangRelated'];
		$relatedBully	= $_POST['bullyingRelated'];
		$reportedLaw	= $_POST['reportedLaw'];
		$cost           = $_POST['cost'];

		$date = $month.'/'.$day.'/'.$year;

		$query = "INSERT INTO DISCIPLINE_RECORD
				  (
				   record_identifier,
				   record_date,
				   incident_id,
				   location_id,
				   school_id,
				   time_id,
				   facilities_id,
				   injury_id,
				   weapon_id,
				   reporter_id,
				   related_alcohol,
				   related_drug,
				   related_hate,
				   related_weapon,
				   related_gang,
				   related_bully,
				   reported_Law,
				   cost
				  )
				  values
				  (
				   '$identifier',
				   '".date('Y-m-d',strtotime($date))."',
				   $incidentId,
				   $locationId,
				   $schoolId,
				   $timeId,
				   $facilitiesId,
				   $injuryId,
				   $weaponId,
				   $reporterId,
				   $relatedAlcohol,
				   $relatedDrug,
				   $relatedHate,
				   $relatedWeapon,
				   $relatedGang,
				   $relatedBully,
				   $reportedLaw,
				   '$cost'
				  )";
		if(DBQuery($query)){
			return $identifier;
		}
		else{
			return 0;
		}
	}

	public static function updateIncident(){
			$identifier     = $_POST['identifier'];
			$month			= $_POST['incidentMonth'];
			$day			= $_POST['incidentDay'];
			$year			= $_POST['incidentYear'];
			$incidentId	    = $_POST['incident'];
			$locationId		= $_POST['location'];
			$schoolId		= $_POST['school'];
			$timeId			= $_POST['time'];
			$facilitiesId	= $_POST['facilities'];
			$injuryId		= $_POST['injury'];
			$weaponId		= $_POST['weapon'];
			$reporterId		= $_POST['reporter'];
			$relatedAlcohol = $_POST['alcoholRelated'];
			$relatedDrug	= $_POST['drugRelated'];
			$relatedHate	= $_POST['hateRelated'];
			$relatedWeapon  = $_POST['weaponRelated'];
			$relatedGang	= $_POST['gangRelated'];
			$relatedBully	= $_POST['bullyingRelated'];
			$reportedLaw	= $_POST['reportedLaw'];
			$cost           = $_POST['cost'];
			$openClosed     = $_POST['openClosed'];

			$date = $month.'/'.$day.'/'.$year;

			$query = "UPDATE DISCIPLINE_RECORD
					  SET
					  record_date     = '".date('Y-m-d',strtotime($date))."',
					  incident_id     = $incidentId,
					  location_id     = $locationId,
					  school_id       = $schoolId,
					  time_id         = $timeId,
					  facilities_id   = $facilitiesId,
					  injury_id       = $injuryId,
					  weapon_id       = $weaponId,
					  reporter_id     = $reporterId,
					  related_alcohol = $relatedAlcohol,
					  related_drug    = $relatedDrug,
					  related_hate    = $relatedHate,
					  related_weapon  = $relatedWeapon,
					  related_gang    = $relatedGang,
					  related_bully   = $relatedBully,
					  reported_Law    = $reportedLaw,
					  cost            = '$cost',
					  open_closed     = $openClosed
					  WHERE
					  record_identifier = '$identifier'";

			if(DBQuery($query)){
				return true;
			}
			else{
				return false;
			}
	}

	public static function getDisciplineActionsDisplay($identifier, $perpId){
			$query = "SELECT
					  d.discipline_id as id,
					  dl.discipline_display AS display,
					  dl.discipline_description,
					  d.start_date AS start_date,
					  d.end_date AS end_date,
					  d.related_special_ed AS ed,
					  d.related_zero_policy AS policy,
					  d.full_year_expulsion AS full,
					  d.short_expulsion AS short,
					  d.discipline_id_type AS type
					  FROM
					  DISCIPLINE d,
					  DISCIPLINE_DISCIPLINE_LKUP dl
					  WHERE
					  d.discipline_id_type = dl.discipline_id
					  AND
					  d.incident_identifier = '$identifier'
					  AND
					  d.perpetrator_id = $perpId
					  AND
                      d.hidden != 1
					  ORDER BY
                      d.discipline_id";
			$result = DBQuery($query);
			return $result;
	}

	public static function getDisciplineActionsDetailsJson($id){
			$json = '"disciplines":[';
			$query = "SELECT
					  d.discipline_id,
					  dl.discipline_description,
					  d.start_date AS start_date,
					  d.end_date AS end_date,
					  d.related_special_ed,
					  d.related_zero_policy,
					  d.full_year_expulsion,
					  d.short_expulsion,
					  d.discipline_id_type
					  FROM
					  DISCIPLINE d,
					  DISCIPLINE_DISCIPLINE_LKUP dl
					  WHERE
					  d.discipline_id_type = dl.discipline_id
					  AND
					  d.discipline_id = $id
					  AND
                      d.hidden != 1";
			$result = DBQuery($query);
			while($row = db_fetch_row($result)){
				$disciplineDisplay = $row['DISCIPLINE_DESCRIPTION'];
				$disciplineTypeId  = $row['DISCIPLINE_ID_TYPE'];
				$disciplineId      = $row['DISCIPLINE_ID'];
				$endDate           = $row['END_DATE'];
				$startDate         = $row['START_DATE'];
				$specialEd		   = $row['RELATED_SPECIAL_ED'];
				$zeroTol		   = $row['RELATED_ZERO_POLICY'];
				$fullExpulsion	   = $row['FULL_YEAR_EXPULSION'];
				$shortExpulsion    = $row['SHORT_EXPULSION'];

				if($specialEd == 1){
					$specialEd = 'Yes';
				}
				else{
					$specialEd = 'No';
				}

				if($zeroTol == 1){
					$zeroTol = 'Yes';
				}
				else{
					$zeroTol = 'No';
				}
				if($fullExpulsion == 1){
					$fullExpulsion = 'Yes';
				}
				else{
					$fullExpulsion = 'No';
				}
				if($shortExpulsion == 1){
					$shortExpulsion = 'Yes';
				}
				else{
					$shortExpulsion = 'No';
				}
				$json = $json.'{
								"display":"'.$disciplineDisplay.'",
							    "typeId":"'.$disciplineTypeId.'",
							    "id":"'.$disciplineId.'",
							    "endDate":"'.$endDate.'",
							    "startDate":"'.$startDate.'",
							    "specialEd":"'.$specialEd.'",
							    "zeroTol":"'.$zeroTol.'",
							    "fullExp":"'.$fullExpulsion.'",
							    "shortExp":"'.$shortExpulsion.'"},';
			}

            $json = rtrim($json, ",");
			$json = $json.']';
			return $json;
	}

	public static function removeDisciplineAction($disciplineId){
		$query = "UPDATE DISCIPLINE
				  SET hidden = 1
				  WHERE discipline_id = $disciplineId";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function updateDisciplineAction($disciplineId,
												  $typeId,
												  $startDate,
												  $endDate,
												  $specialEd,
												  $zeroTol,
												  $fullExpulsion,
												  $shortExpulsion){
		$query = "UPDATE DISCIPLINE
				  SET discipline_id_type = $typeId,
				   start_date = '".date('Y-m-d',strtotime($startDate))."',
				   end_date = '".date('Y-m-d',strtotime($endDate))."',
				   related_special_ed = $specialEd,
				   related_zero_policy = $zeroTol,
				   full_year_expulsion = $fullExpulsion,
				   short_expulsion = $shortExpulsion
				   WHERE
                   discipline_id = $disciplineId";

		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}

	}

	public static function addDisciplineAction($identifier,
										       $perpetrator,
										       $typeId,
										       $startDate,
										       $endDate,
										       $specialEd,
										       $zeroTol,
										       $fullExpulsion,
										       $shortExpulsion
										       ){
		$query = "INSERT INTO DISCIPLINE
				  (discipline_id,
				   incident_identifier,
				   perpetrator_id,
				   discipline_id_type,
				   start_date,
				   end_date,
				   related_special_ed,
				   related_zero_policy,
				   full_year_expulsion,
				   short_expulsion)
				  VALUES
				  (nextval('discipline_discipline_add_seq'),
				   '$identifier',
				   $perpetrator,
				   $typeId,
                   '".date('Y-m-d',strtotime($startDate))."',
                   '".date('Y-m-d',strtotime($endDate))."',
				   $specialEd,
				   $zeroTol,
				   $fullExpulsion,
				   $shortExpulsion
				  )";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

}

Class DropDownOption
{
	var $display;
	var $desc;
	var $id;

	public function DropDownOption($display, $desc, $id){

		$this->display = $display;
		$this->desc    = $desc;
		$this->id      = $id;
	}

	public static function getDescription($id, $tableName){
		$query = "SELECT ".$tableName."_description FROM DISCIPLINE_".strtoupper($tableName)."_LKUP where ".$tableName."_id = $id";
		$result = DBQuery($query);
		$row = db_fetch_row($result);

		$tableName = strtoupper($tableName);
		$rowName = $tableName.'_DESCRIPTION';

		$desc = $row[$rowName];

		return $desc;
	}
}

?>