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

if(User('PROFILE') == 'admin' || User('STAFF_ID') == 1)
{
	$_REQUEST['modname'] = 'Discipline/dashboard.php';
}
else
{
	$_REQUEST['modname'] = 'Discipline/dashboard.php';
}

if($_REQUEST['modname'])
{
	echo "<SCRIPT language=javascript>parent.help.location=\"Bottom.php?modcat=$modcat&modname=$_REQUEST[modname]\";</SCRIPT>";
	include("modules/$_REQUEST[modname]");
}

?>