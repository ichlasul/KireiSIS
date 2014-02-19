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

Class Auth
{
	var $ADMIN = 'admin';
	var $PARENT = 'parent';
	var $STUDENT = 'student';
	var $TEACHER = 'teacher';
	var $STUDENT_ID = 0;
	var $ADMIN_ID = 1;
	var $PARENT_ID = 3;
	var $TEACHER_ID = 2;

	function Auth()
	{

	}

	function checkAdmin($profile, $staffId)
	{
		if($profile == $this->ADMIN)
		{
			if($staffId == $this->ADMIN_ID)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function checkParent($profile, $staffId)
	{
		if($profile == $this->PARENT)
		{
			if($staffId == $this->PARENT_ID)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function checkStudent($profile, $staffId)
	{
		if($profile == $this->STUDENT)
		{
			if($staffId == $this->STUDENT_ID)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function checkTeacher($profile, $staffId)
	{
		if($profile == $this->TEACHER)
		{
			if($staffId == $this->TEACHER_ID)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

}
?>