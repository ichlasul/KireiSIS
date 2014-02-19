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

#######################################################################################################################
	if($_REQUEST['modfunc']=='print_all' && $_REQUEST['report'])
	{
			$sql = "select 
				(select title from COURSE_SUBJECTS where subject_id=(select subject_id from COURSES where 						course_id=COURSE_PERIODS.course_id)) as subject,
				(select title from COURSES where course_id=COURSE_PERIODS.course_id) as COURSE_TITLE,
				 short_name, 
				(select title from SCHOOL_PERIODS where period_id=COURSE_PERIODS.period_id) as period, 
				marking_period_id, 
				(select CONCAT(LAST_NAME,' ',FIRST_NAME,' ',MIDDLE_NAME,' ') from STAFF where staff_id=COURSE_PERIODS.teacher_id) as teacher, 
				room as location,days,course_period_id,course_id
				from COURSE_PERIODS where school_id='".UserSchool()."' and syear='".UserSyear()."' ".$where." order by subject,COURSE_TITLE";
					
			$ret = DBGet(DBQuery($sql));
		if(count($ret))
		{
			foreach($ret as $s_id)
			{
			echo '<div align="center">';
			
			echo '<table border="0" width="97%" align="center"><tr><td><font face=verdana size=-1><b>'.$s_id['SUBJECT'].'</b></font></td></tr>';
			echo '<tr><td align="right"><table border="0" width="97%"><tr><td><font face=verdana size=-1><b>'.$s_id['COURSE_TITLE'].'</b></font></td></tr>';
			echo '<tr><td colspan="2" valign="top" align="right"><table border="0" width="97%"><tr><td>';
			echo '</td></tr></table></td></tr></table></td></tr></table></td></tr>';
			echo '</table></div>';
			echo "<div style=\"page-break-before: always;\"></div>";
			}
		}
	}
	else
	{
		PopTable('header','Print all Courses','width=700');
		DrawHeader('<div align="center">Report Generated</div>');
		echo "<FORM name=exp id=exp action=for_export.php?modname=$_REQUEST[modname]&modfunc=print_all&_CENTRE_PDF=true&report=true method=POST target=_blank>";
		echo '<table width=100%><tr><td align="center"><INPUT type=submit class=btn_medium value=\'Print\'></td></tr></table>';
		echo '</form>';
		PopTable('footer');
	}

?>
