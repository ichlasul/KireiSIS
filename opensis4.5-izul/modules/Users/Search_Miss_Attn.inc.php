<?php
#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  schools from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************


if(User('PROFILE')=='admin')
{
		if(!$_REQUEST['next_modname'])
			$_REQUEST['next_modname'] = 'Users/User.php';

		#if(!isset($_CENTRE['DrawHeader'])) DrawHeaderHome('Please select a user');
		$staff_RET = GetStaffList_Miss_Atn($extra);
		if($extra['profile'])
		{
			$options = array('admin'=>'Administrator','teacher'=>'Teacher','parent'=>'Parent','none'=>'No Access');
			$singular = $options[$extra['profile']];
			$plural = $singular.($options[$extra['profile']]=='none'?'es':'s');
			$columns = array('FULL_NAME'=>$singular,'STAFF_ID'=>'Staff ID');
		}
		else
		{
			$singular = 'User';
			$plural = 'Users';
			$columns = array('FULL_NAME'=>'Staff Member','PROFILE'=>'Profile','STAFF_ID'=>'Staff ID');
		}
		if(is_array($extra['columns_before']))
			$columns = $extra['columns_before'] + $columns;
		if(is_array($extra['columns_after']))
			$columns += $extra['columns_after'];
		if(is_array($extra['link']))
			$link = $extra['link'];
		else
		{
			$link['FULL_NAME']['link'] = "Modules.php?modname=$_REQUEST[next_modname]";
			$link['FULL_NAME']['variables'] = array('staff_id'=>'STAFF_ID');
		}
		if(count($staff_RET))
			echo '<font color=red><b>Following teachers have missing attendance!</b></font>';
		
		ListOutput($staff_RET,$columns,$singular,$plural,$link,false,$extra['options']);
}

?>
