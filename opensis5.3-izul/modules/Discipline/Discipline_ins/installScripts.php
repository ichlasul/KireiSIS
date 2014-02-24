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

error_reporting(1);

require_once '../../../functions/PopTable.php';
require_once '../../../functions/DrawTab.fnc.php';
require_once '../../../config.inc.php';
require_once '../../../database.inc.php';


function runScripts()
{
		try{

			$dbconn = db_start();

			echo 'UDAH LEWAT 0';

			$myFile = "sql/setupDB.sql";
			$sql = file_get_contents($myFile);
			echo 'UDAH LEWAT 1';
			if(!$result = mysqli_execute($sql)){
				echo 'setup Failure';
				echo  $result;
				return false;
			}

			echo 'UDAH LEWAT 2';

			$myFile = "sql/disciplineInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'discipien fail';
				return false;
			}

			$myFile = "sql/incidentInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'incidents fail';
				return false;
			}

			$myFile = "sql/injuryInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'injury fail';
				return false;
			}

			$myFile = "sql/locationInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'loc fail';
				return false;
			}

			$myFile = "sql/perpetratorInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'perp fail';
				return false;
			}

			$myFile = "sql/victimInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'victim fail';
				return false;
			}

			$myFile = "sql/reporterInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'reporter fail';
				return false;
			}

			$myFile = "sql/timeInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'time fail';
				return false;
			}

			$myFile = "sql/weaponInserts.sql";
			$sql = file_get_contents($myFile);
			if(!$result = mysqli_execute($sql)){
				//echo 'weapon fail';
				return false;
			}
		}
		catch(Exception $e){
			pg_close($dbconn);
			return false;
		}
		pg_close($dbconn);
		return true;
}
?>