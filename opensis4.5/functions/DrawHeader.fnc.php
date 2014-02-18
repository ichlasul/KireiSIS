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

function DrawHeader($left='',$right='',$center='')
{	global $_CENTRE;

	if(!isset($_CENTRE['DrawHeader']))
		$_CENTRE['DrawHeader'] = '';

	if($_CENTRE['DrawHeader'] == '')
	{
		$attribute = 'b';
		$font_color = '';
		
	}
	else
	{
		$attribute = '';
		$font_color = '';
	}

	echo '<TABLE width=100%  border=0 cellpadding=5 cellspacing=5 align=center><TR>';
	if($left)
		echo '<TD '.$_CENTRE['DrawHeader'].' align=left class=drawheader>&nbsp;<'.$attribute.'>'.$left.'</'.substr($attribute,0,4).'></TD>';
	if($center)
		echo '<TD '.$_CENTRE['DrawHeader'].' align=center class=drawheader ><'.$attribute.'>'.$center.'</'.$attribute.'></TD>';
	if($right)
		echo '<TD align=right class=drawheader'.$_CENTRE['DrawHeader'].' ><'.$attribute.'>'.$right.'</'.substr($attribute,0,4).'></TD>';
	echo '</TR></TABLE>';

	if($_CENTRE['DrawHeaderHome'] == '' && !$_REQUEST['_CENTRE_PDF'])
		$_CENTRE['DrawHeaderHome'] = ' style="border:0;border-style: none none none none;"';
	//$_CENTRE['DrawHeader'] = '';
	else
	//	$_CENTRE['DrawHeader'] = ' style="border:1;border-style: none none solid none;"';
		$_CENTRE['DrawHeaderHome'] = '';
}
?>