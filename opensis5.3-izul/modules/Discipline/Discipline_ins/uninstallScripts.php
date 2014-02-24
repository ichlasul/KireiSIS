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


function runUninstallScripts()
{
		try{

			$dbconn = db_start();

			$myFile = "sql/uninstall.sql";
			$sql = file_get_contents($myFile);
			$result = pg_exec($sql);

		}
		catch(Exception $e){
			pg_close($dbconn);
			return false;
		}
		pg_close($dbconn);
		return true;
}
?>