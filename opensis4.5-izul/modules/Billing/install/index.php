<?php
#**************************************************************************
#  openSIS is a free student information system for public and non-public
#  schools from Open Solutions for Education, Inc. It is  web-based,
#  open source, and comes packed with features that include student
#  demographic info, scheduling, grade book, attendance,
#  report cards, eligibility, transcripts, parent portal,
#  student portal and more.
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send
#  an email to info@os4ed.com.
#
#  Copyright (C) 2007-2008, Open Solutions for Education, Inc.
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
require_once 'installScripts.php';
require_once 'uninstallScripts.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="installerCSS.css">
<title>Billing Installer</title>
</head>
<body>
 <div id="frame" rem="main div">
	<div id="banner"><div id="logo"><h2 style="color:white;font-weight:bold;">Welcome to the Billing Module Installer</h2></div></div>
<?php
error_reporting(0);
session_start();
$version_ok = false;
$phpVersion = phpversion();
$versionNum = substr($phpVersion,0,1);

if($versionNum < 5)
{
	echo '<h3 align="center">You must have php version 5.2.3 to run this installer</h3>';
	$version_ok = false;
}
else
{
	$version_ok = true;
}

if($version_ok)
{
?>

                <table align="center" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td align="center" style="padding-top:60px;">
<?php
					if($_GET["step"]=="" && !isSet($_POST["step"]))
			  		{
			 			echo '<a href="index.php?step=1"><img src=./images/install.png /></a>&nbsp;&nbsp;&nbsp;<a href="index.php?step=10"><img height="122px" width="122px" src=./images/uninstall.png /></a></td>';
			  		}
			  		else
			  		if($_GET["step"]=="1")
					{

							echo '<div>Database connection successful...running scripts';

							if(runScripts())
							{
									echo '...scripts successful</div></br><div align="center">
										 <div style="width:200px;height:100px;">Two More Steps.  You must add this line of code in your config.inc file located in you root directory of your Centre install
									     </div>
									     <br/>
									     <img src="./images/codeView.GIF" />
									     <br/>
									     <div style="width:200px;height:100px;">You must copy all the javascript files in the js folder located in the Billing_ins folder to the js folder on the root of your OpenSIS install.
									     </div>
									     </div>
									     <br/>
										 <table border="0" width="43%" id="table1">
										 <tr>
										 <td align=center><a href="../index.php"><img src="./images/get_started.png"></a></td>
								         </tr></table>';
							}
							else
							{
									echo '<br/><font style="color:red">Error running scripts</font><br/><input type="submit" class="button" style="width:100px" value="Restart" onclick="window.location.href=\'index.php\'" />';
							}


			  			}
			  			else
			  			if($_GET["step"]=="10")
			  			{
			  				if(runUninstallScripts())
			  				{
			  					echo'<h2>Billing Module Is Removed</h2><br/><a href="../index.php"><img src="./images/get_started.png">';
			  				}
			  				else
			  				{
			  					echo'<h2>Error Removing Billing Module</h2><br/><a href="../index.php"><img src="./images/get_started.png">';
			  				}
			  			}
					?>
					</td>
					<td>
                  </tr>
                </table>
<?php
}
?>
               <div style="font-size:12px;" align="center">Copyright &copy; 2007-2008 Open Solutions for Education, Inc. (<a href='http://www.os4ed.com' target='_blank'>OS4Ed</a>).</div>
               </div>
</body>
</html>
