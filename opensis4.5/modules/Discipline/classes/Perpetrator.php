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

class Perpetrator{

	var $id;
	var $userId;
	var $name;

	public function Perpetrator($perpId){
		$query = "SELECT
				  perpetrator_name,
				  perpetrator_user_id
				  FROM
				  DISCIPLINE_PERPETRATOR
				  WHERE
				  perpetrator_id = $perpId";

		$result = DBQuery($query);
		$row = db_fetch_row($result);

		$this->id = $perpId;
		$this->userId = $row['PERPETRATOR_USER_ID'];
		$this->name   = $row['PERPETRATOR_NAME'];
	}

	public static function getPerpetrators_Discipline($identifier){
		$perps = array();
		$query = "SELECT
				  perpetrator_id
				  FROM
				  DISCIPLINE_PERPETRATOR
				  WHERE
				  incident_identifier = '$identifier'
				  AND hidden != 1";

		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$perp = new Perpetrator($row['PERPETRATOR_ID']);
			array_push($perps, $perp);
		}
		return $perps;
	}

	public static function removePerpetrator($perpId){
		$query = "UPDATE DISCIPLINE_PERPETRATOR
				  SET hidden = 1 WHERE perpetrator_id = $perpId";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function getPerpetratorsPage($identifier){
			$query = "SELECT
					  p.perpetrator_id,
					  p.perpetrator_name,
					  pl.perpetrator_display,
					  i.injury_display
					  FROM
					  DISCIPLINE_PERPETRATOR p,
					  DISCIPLINE_PERPETRATOR_LKUP pl,
					  DISCIPLINE_INJURY_LKUP i
					  WHERE
					  p.incident_identifier = '$identifier'
					  AND pl.perpetrator_id = p.perpetrator_type_id
					  AND i.injury_id = p.injury_id
					  AND p.hidden != 1;";

			$result = DBQuery($query);
			return $result;
	}

	public static function addPerpetrator($identifier, $name, $injuryId, $userId, $typeCode){
		$typeId = Perpetrator::getPerpetratorId($typeCode);

		$query = "INSERT INTO DISCIPLINE_PERPETRATOR
				 (
				  perpetrator_id,
				  incident_identifier,
				  perpetrator_name,
				  perpetrator_user_id,
				  perpetrator_type_id,
				  injury_id
				 )
				 VALUES
				 (
				  nextval('DISCIPLINE_PERPETRATOR_add_seq'),
				  '$identifier',
				  '$name',
				  $userId,
				  $typeId,
				  $injuryId
				 )";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function getPerpetratorId($code){
		$query = "SELECT perpetrator_id FROM DISCIPLINE_PERPETRATOR_LKUP WHERE perpetrator_code = '$code'";
		$result = DBQuery($query);
		$row = db_fetch_row($result);
		return $row['PERPETRATOR_ID'];
	}

	public static function processSearchRequest($type, $value){
		if($type <= 100){
			return Perpetrator::searchStudents($value);
		}
		else{
			if($type > 100 && $type <= 200){
				$profileId = 2;
			}
			else{
				$profileId = 1;
			}

			return Perpetrator::searchStaff($value, $profileId);
		}
	}

	public static function searchStaff($value, $profileId){
		$json = '"users":[';
		$query = "SELECT
				  staff_id,
				  first_name,
				  last_name,
				  middle_name
				  FROM
				  STAFF
				  WHERE
				  profile_id = $profileId
				  AND
				  (
				  lower(last_name) LIKE lower('%$value%')
				  OR lower(first_name) LIKE lower('%$value%')
				  OR lower(concat(first_name, ' ', last_name)) LIKE lower('%$value%')";
		if(is_numeric($value)){
			$query = $query." OR staff_id = $value";
		}
		$query = $query." )";

		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$lastName  = $row['LAST_NAME'];
			$firstName = $row['FIRST_NAME'];
			$middle    = $row['MIDDLE_NAME'];
			$id        = $row['STAFF_ID'];

			$json = $json.'{
							"id":"'.$id.'",
						    "first":"'.$firstName.'",
						    "last":"'.$lastName.'",
						    "middle":"'.$middle.'"},';
		}
        $json = rtrim($json, ",");
		$json = $json.']';
		return $json;
	}

	public static function searchStudents($value){
		$json = '"users":[';
		$query = "SELECT
				  s.last_name,
				  s.first_name,
				  s.middle_name,
				  s.student_id,
				  gl.title
				  FROM
				  SCHOOL_GRADELEVELS gl,
				  STUDENTS s,
				  STUDENT_ENROLLMENT se
				  WHERE
				  s.student_id = se.student_id
				  AND se.grade_id = gl.id
				  AND
				  (
				  lower(s.last_name) LIKE lower('%$value%')
				  OR lower(s.first_name) LIKE lower('%$value%')
				  OR lower(concat(s.first_name, ' ', s.last_name)) LIKE lower('%$value%')";
				  if(is_numeric($value)){
				  		$query = $query." OR s.student_id = $value";
				  }

		$query = $query." )";

		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$lastName  = $row['LAST_NAME'];
			$firstName = $row['FIRST_NAME'];
			$middle    = $row['MIDDLE_NAME'];
			$id        = $row['STUDENT_ID'];
			$grade     = $row['TITLE'];

			$json = $json.'{
							"id":"'.$id.'",
						    "first":"'.$firstName.'",
						    "last":"'.$lastName.'",
						    "middle":"'.$middle.'",
						    "grade":"'.$grade.'"},';
		}
        $json = rtrim($json, ",");
		$json = $json.']';
		return $json;
	}
}
?>