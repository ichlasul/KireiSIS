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

class Victim{


	public static function removeVictim($victimId){
		$query = "UPDATE DISCIPLINE_VICTIM
				  SET hidden = 1 WHERE victim_id = $victimId";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function getVictims($identifier){
			$query = "SELECT
					  v.victim_id,
					  v.victim_name,
					  vl.victim_display,
					  i.injury_display
					  FROM
					  DISCIPLINE_VICTIM v,
					  DISCIPLINE_VICTIM_LKUP vl,
					  DISCIPLINE_INJURY_LKUP i
					  WHERE
					  v.incident_identifier = '$identifier'
					  AND vl.victim_id = v.victim_type_id
					  AND i.injury_id = v.injury_id
					  AND v.hidden != 1;";

			$result = DBQuery($query);
			return $result;
	}

	public static function addVictim($identifier, $name, $injuryId, $victimId){
		$query = "INSERT INTO DISCIPLINE_VICTIM
				 (
				  victim_id,
				  incident_identifier,
				  victim_name,
				  victim_type_id,
				  injury_id
				 )
				 VALUES
				 (
				  nextval('discipline_victim_add_seq'),
				  '$identifier',
				  '$name',
				  $victimId,
				  $injuryId
				 )";
		if(DBQuery($query)){
			return true;
		}
		else{
			return false;
		}
	}
}

?>