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

if($_REQUEST['modfunc']=='attn')
{
    header("Location:Modules.php?modname=Users/TeacherPrograms.php?include=Attendance/TakeAttendance.php");
}

$RET = DBGET(DBQuery("SELECT DISTINCT s.TITLE AS SCHOOL,acc.SCHOOL_DATE,cp.TITLE,cp.COURSE_PERIOD_ID FROM ATTENDANCE_CALENDAR acc,COURSE_PERIODS cp,SCHOOL_PERIODS sp,SCHOOLS s,STAFF st,SCHEDULE sch WHERE acc.SYEAR='".UserSyear()."' AND (acc.MINUTES IS NOT NULL AND acc.MINUTES>0) AND st.STAFF_ID='".User('STAFF_ID')."' AND cp.TEACHER_ID='".User('STAFF_ID')."' AND (st.SCHOOLS IS NULL OR position(acc.SCHOOL_ID IN st.SCHOOLS)>0) AND cp.SCHOOL_ID=acc.SCHOOL_ID AND cp.SYEAR=acc.SYEAR AND cp.CALENDAR_ID=acc.CALENDAR_ID AND cp.FILLED_SEATS<>0 AND sch.COURSE_PERIOD_ID=cp.COURSE_PERIOD_ID AND acc.SCHOOL_DATE>=sch.START_DATE AND acc.SCHOOL_DATE<'".DBDate()."' AND cp.MARKING_PERIOD_ID IN (SELECT MARKING_PERIOD_ID FROM SCHOOL_YEARS WHERE SCHOOL_ID=acc.SCHOOL_ID AND acc.SCHOOL_DATE BETWEEN START_DATE AND END_DATE  UNION SELECT MARKING_PERIOD_ID FROM SCHOOL_SEMESTERS WHERE SCHOOL_ID=acc.SCHOOL_ID AND acc.SCHOOL_DATE BETWEEN START_DATE AND END_DATE  UNION SELECT MARKING_PERIOD_ID FROM SCHOOL_QUARTERS WHERE SCHOOL_ID=acc.SCHOOL_ID AND acc.SCHOOL_DATE BETWEEN START_DATE AND END_DATE ) AND sp.PERIOD_ID=cp.PERIOD_ID AND (sp.BLOCK IS NULL AND position(substring('UMTWHFS' FROM DAYOFWEEK(acc.SCHOOL_DATE) FOR 1) IN cp.DAYS)>0 OR sp.BLOCK IS NOT NULL AND acc.BLOCK IS NOT NULL AND sp.BLOCK=acc.BLOCK)AND NOT EXISTS(SELECT '' FROM ATTENDANCE_COMPLETED ac WHERE ac.SCHOOL_DATE=acc.SCHOOL_DATE AND ac.STAFF_ID=cp.TEACHER_ID AND ac.PERIOD_ID=cp.PERIOD_ID) AND cp.DOES_ATTENDANCE='Y' AND s.ID=acc.SCHOOL_ID ORDER BY cp.TITLE,acc.SCHOOL_DATE"),array('SCHOOL_DATE'=>'ProperDate'));

#echo count($RET);
if (count($RET))
{
    echo '<p><center><font color=#FF0000><b>Warning!!</b></font> - Teachers have missing attendance data:</center>';

    $modname = 'Users/TeacherPrograms.php?include=Attendance/TakeAttendance.php';
    $link['remove']['link'] = "Modules.php?modname=$modname&modfunc=attn";
    $link['remove']['variables'] = array('date'=>'SCHOOL_DATE','cp_id'=>'COURSE_PERIOD_ID');
    ListOutput_missing_attn($RET,array('SCHOOL_DATE'=>'Date','TITLE'=>'Period -Teacher','SCHOOL'=>'School'),'Period','Periods',$link,array(),array('save'=>false,'search'=>false));

    echo '</p>';
}
else
{
    echo '<center><font color=red><b>No missing attendance found for this teacher.</b></font></center>';
}

?>
