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

header("Content-Type: text/xml");

session_start();

require '../../../config.inc.php';
require '../../../database.inc.php';
require '../../../functions/User.fnc.php';
require '../../../functions/DBGet.fnc.php';
require '../../../functions/Current.php';

require '../classes/Auth.php';
require '../classes/Discipline.php';

$auth = new Auth();
$staffId = User('STAFF_ID');
$profile = User('PROFILE');

if($auth->checkAdmin($profile, $staffId))
{
	$disciplineId   = $_POST['disciplineid'];
	$typeId		    = $_POST['disciplineType'];
	$specialEd      = $_POST['specialEd'];
	$zeroTol        = $_POST['zeroPolicy'];
	$fullExpulsion  = $_POST['fullExpulsion'];
	$shortExpulsion = $_POST['shortExpulsion'];


	$startYear	    = $_POST['startDateYear'];
	$startMonth	    = $_POST['startDateMonth'];
	$startDay	    = $_POST['startDateDay'];


	$endYear        = $_POST['endDateYear'];
	$endMonth       = $_POST['endDateMonth'];
	$endDay         = $_POST['endDateDay'];

	$startDate = $startMonth.'/'.$startDay.'/'.$startYear;
	$endDate   = $endMonth.'/'.$endDay.'/'.$endYear;



	if(Discipline::updateDisciplineAction($disciplineId,$typeId,$startDate,$endDate,$specialEd,$zeroTol,$fullExpulsion,$shortExpulsion)){
		echo '{"result":[{"success":true}]}';
	}
	else{
		echo '{"result":[{"success":false}]}';
	}
}
else
{
	echo '{"result":[{"success":false}]}';
}
?>