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

class School{

	public static function addSchool($schoolCode, $schoolDesc, $stateCode, $districtCode, $hidden){
			$query = "INSERT INTO DISCIPLINE_SCHOOL_LKUP
					  (school_id,school_code, school_description, state_code, district_code, hidden)
					  VALUES
					  (nextval('discipline_school_seq'), '$schoolCode', '$schoolDesc', '$stateCode', '$districtCode', $hidden)";
			if(DBQuery($query)){
				return true;
			}
			else{
				return false;
			}
	}

	public static function updateSchool($schoolId, $schoolCode, $schoolDesc, $stateCode, $districtCode, $hidden){
		$query = "UPDATE DISCIPLINE_SCHOOL_LKUP
				  SET school_code = '$schoolCode',
				  school_description = '$schoolDesc',
				  district_code = '$districtCode',
				  hidden = $hidden,
				  state_code = '$stateCode'
				  WHERE school_id = $schoolId";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function getAllSchools(){
		echo '{"result":[{"success":true}], "schools":[';

		$query = "SELECT
				  school_code,
				  school_id,
				  school_description,
				  district_code,
				  state_code,
				  hidden
				  FROM
				  DISCIPLINE_SCHOOL_LKUP ORDER BY school_id";

		$result = DBQuery($query);
		while($row = db_fetch_row($result)){
			$schoolCode   = $row['SCHOOL_CODE'];
			$schoolId     = $row['SCHOOL_ID'];
			$schoolDesc   = $row['SCHOOL_DESCRIPTION'];
			$stateCode    = $row['STATE_CODE'];
			$districtCode = $row['DISTRICT_CODE'];
			$hidden       = $row['HIDDEN'];

			$json += '{
				   "schoolCode"   :"'.$schoolCode.'",
				   "schoolId"     :"'.$schoolId.'",
				   "desc"         :"'.$schoolDesc.'",
				   "stateCode"    :"'.$stateCode.'",
				   "districtCode" :"'.$districtCode.'",
				   "hidden"       :"'.$hidden.'"},';
		}

        $json = rtrim($json, ",");
		echo ']}';
	}

}

?>