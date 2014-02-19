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
	if($_REQUEST['modfunc']=='print' && $_REQUEST['report'])
	{
	
		if($_REQUEST['marking_period_id'])
			$where = ' AND MARKING_PERIOD_ID='.$_REQUEST['marking_period_id'];

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
			/*echo '<tr><td height=10></td></tr>';
			echo '<tr><TD align="right"><table border="0" width="97%"><tr><td width="13%" valign="top"><font face=verdana size=-1><b>Overview :</b></font></TD>';
			echo '<td valign="top" width="87%" align="left"><small>'.$s_id['OVERVIEW_OF_GROUPS'].'</small></td></tr>';
			echo '<tr><td height=10></td></tr>';
			echo '<tr><TD valign="top"><font face=verdana size=-1><b>Focus of Groups :</b></font></TD>';
			echo '<td valign="bottom" align="left"><small>'.$s_id['GROUP_GOALS'].'</small></td></tr>';
			echo '<tr><td height=10></td></tr>';
			echo '<tr><TD valign="top"><font face=verdana size=-1><b>Treatment Track :</b></font></TD>';
			echo '<td valign="bottom" align="left"><small>'.$s_id['STAGE_OF_CHANGE'].'</small></td></tr>';
			echo '<tr><td height=10></td></tr>';
			echo '<tr><TD valign="top"><font face=verdana size=-1><b>Referral Criteria :</b></font></TD>';
			echo '<td valign="bottom" align="left"><small>'.$s_id['REFERRAL_CRITERIA'].'</small></td></tr>';
			echo '<tr><td height=10></td></tr>';
			echo '<tr><TD valign="top"><font face=verdana size=-1><b>Attendance Reqmnt :</b></font></TD>';
			echo '<td valign="bottom" align="left"><small>'.$s_id['ATTENDANCE_REQUIREMENT'].'</small></td></tr>';*/
			
			
			 $sql_periods = "SELECT distinct cp.SHORT_NAME,(select CONCAT(START_TIME,' - ',END_TIME,' ') from SCHOOL_PERIODS where period_id=cp.period_id) as PERIOD,cp.ROOM,cp.DAYS,(select CONCAT(LAST_NAME,' ',FIRST_NAME,' ',MIDDLE_NAME,' ') from STAFF where staff_id=cp.TEACHER_ID) as TEACHER from COURSE_PERIODS cp where cp.course_id=".$s_id['COURSE_ID']." and cp.syear='".UserSyear()."' and cp.school_id='".UserSchool()."'";
			
			$period_list = DBGet(DBQuery($sql_periods));
			
##############################################List Output Generation##################################################
			
			$columns = array('SHORT_NAME'=>'Course','PERIOD'=>'Time','DAYS'=>'Days','ROOM'=>'Location','TEACHER'=>'Teacher');
			
			echo '<tr><td colspan="2" valign="top" align="right">';
			PrintCatalog($period_list,$columns,'Course','Courses','','',array('search'=>false));
			echo '</td></tr></table></td></tr></table></td></tr>';
			
			######################################################################################################################
			echo '</table></div>';
	
			echo "<div style=\"page-break-before: always;\"></div>";
			}
		}
		else
		echo '<table width=100%><tr><td align=center><font color=red face=verdana size=2><strong>No Courses are found in this term</strong></font></td></tr></table>';
		
		
	}
	else
	{
	PopTable('header','Print Catalog by Term','width=700');
	echo '<table width=100%><tr><td>';
	echo "<FORM id='search' name='search' method=POST action=Modules.php?modname=$_REQUEST[modname]>";
	$mp_RET = DBGet(DBQuery("SELECT MARKING_PERIOD_ID,TITLE,SHORT_NAME,'2'  FROM SCHOOL_QUARTERS WHERE SCHOOL_ID='".UserSchool()."' AND SYEAR='".UserSyear()."' UNION SELECT MARKING_PERIOD_ID,TITLE,SHORT_NAME,'1'  FROM SCHOOL_SEMESTERS WHERE SCHOOL_ID='".UserSchool()."' AND SYEAR='".UserSyear()."' UNION SELECT MARKING_PERIOD_ID,TITLE,SHORT_NAME,'0'  FROM SCHOOL_YEARS WHERE SCHOOL_ID='".UserSchool()."' AND SYEAR='".UserSyear()."' ORDER BY 3,4"));
				unset($options);
		if(count($mp_RET))
			{
				foreach($mp_RET as $key=>$value)
				{
					if($value['MARKING_PERIOD_ID']==$_REQUEST['marking_period_id'])
						$mp_RET[$key]['row_color'] = Preferences('HIGHLIGHT');
				}
				
		$columns = array('TITLE'=>'Marking Periods');
		$link = array();
		$link['TITLE']['link'] = "Modules.php?modname=$_REQUEST[modname]";
		$link['TITLE']['variables'] = array('marking_period_id'=>'MARKING_PERIOD_ID', 'mp_name' => 'SHORT_NAME');
		$link['TITLE']['link'] .= "&modfunc=$_REQUEST[modfunc]";

		echo CreateSelect($mp_RET, 'marking_period_id', 'All', 'Select Term: ', 'Modules.php?modname='.$_REQUEST['modname'].'&marking_period_id=');
			}	
	echo '</td></tr></table>';
	if($_REQUEST['marking_period_id'])
	{
	$mark_name = DBGet(DBQuery("SELECT TITLE,SHORT_NAME,'2'  FROM SCHOOL_QUARTERS WHERE MARKING_PERIOD_ID='".$_REQUEST['marking_period_id']."' AND SCHOOL_ID='".UserSchool()."' AND SYEAR='".UserSyear()."' UNION SELECT TITLE,SHORT_NAME,'1'  FROM SCHOOL_SEMESTERS WHERE MARKING_PERIOD_ID='".$_REQUEST['marking_period_id']."' AND SCHOOL_ID='".UserSchool()."' AND SYEAR='".UserSyear()."' UNION SELECT TITLE,SHORT_NAME,'0'  FROM SCHOOL_YEARS WHERE MARKING_PERIOD_ID='".$_REQUEST['marking_period_id']."' AND SCHOOL_ID='".UserSchool()."' AND SYEAR='".UserSyear()."' ORDER BY 3"));
	$mark_name = $mark_name[1]['SHORT_NAME'];
	DrawHeader('<div align="center">Report generated for '.$mark_name.' Term</div>');
	}
	else
	DrawHeader('<div align="center">Report generated for all Terms</div>');	
	echo '</form>';
	echo "<FORM name=exp id=exp action=for_export.php?modname=$_REQUEST[modname]&modfunc=print&marking_period_id=".$_REQUEST['marking_period_id']."&_CENTRE_PDF=true&report=true method=POST target=_blank>";
	echo '<table width=100%><tr><td align="center"><INPUT type=submit class=btn_medium value=\'Print\'></td></tr></table>';
	echo '</form>';
	PopTable('footer');
}






##########Functions###################
	function CreateSelect($val, $name, $opt, $cap, $link)
	{
		$html .= "<table width=100% border=0><tr><td width=40% align=center>";
		$html .= $cap;
		$html .= "<select name=".$name." id=".$name." onChange=\"window.location='".$link."' + this.options[this.selectedIndex].value;\">";
		$html .= "<option value=''>".$opt."</option>";
		
				foreach($val as $key=>$value)
				{
					if($value[strtoupper($name)]==$_REQUEST[$name])
						$html .= "<option selected value=".$value[strtoupper($name)].">".$value['TITLE']."</option>";
					else
						$html .= "<option value=".$value[strtoupper($name)].">".$value['TITLE']."</option>";	
				}
		
		
		$html .= "</select></td></tr></table>";		
		return $html;
	}

?>
