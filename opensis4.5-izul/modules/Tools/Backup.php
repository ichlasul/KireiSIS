<?php
/*
set_time_limit(0);
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

require_once("data.php");
$mysqldump_version="1.02";
$print_form=1;
$output_messages=array();
//test mysql connection
if( isset($_REQUEST['action']) )
{
	$mysql_host=$DatabaseServer;
	$mysql_database=$DatabaseName;
	$mysql_username=$DatabaseUsername;
	$mysql_password=$_REQUEST['mysql_password'];
	if( 'Test Connection' == $_REQUEST['action'])
	{
		_mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password);
	}
	else if( 'Export' == $_REQUEST['action'])
	{
		_mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password);
		if( 'SQL' == $_REQUEST['output_format'] )
		{
			$print_form=0;
			//ob_start("ob_gzhandler");
			header('Content-type: text/plain');
			header('Content-Disposition: attachment; filename="'.$mysql_database.'.sql"');
			echo "/*mysqldump.php version $mysqldump_version \n";
			_mysqldump($mysql_database);
			//header("Content-Length: ".ob_get_length());
			//ob_end_flush();
		}
		else if( 'CSV' == $_REQUEST['output_format'] && isset($_REQUEST['mysql_table']))
		{
			$print_form=0;
			ob_start("ob_gzhandler");
			header('Content-type: text/comma-separated-values');
			header('Content-Disposition: attachment; filename="'.$mysql_database."_".$mysql_table.'.csv"');
			//header('Content-type: text/plain');
			_mysqldump_csv($_REQUEST['mysql_table']);
			header("Content-Length: ".ob_get_length());
			ob_end_flush();
		}
	}
}
function _mysqldump_csv($table)
{
	$delimiter= ",";
	if( isset($_REQUEST['csv_delimiter']))
		$delimiter= $_REQUEST['csv_delimiter'];
	if( 'Tab' == $delimiter)
		$delimiter="\t";
	$sql="select * from `$table`;";
	$result=mysql_query($sql);
	if( $result)
	{
		$num_rows= mysql_num_rows($result);
		$num_fields= mysql_num_fields($result);
		$i=0;
		while( $i <$num_fields)
		{
			$meta= mysql_fetch_field($result, $i);
			echo($meta->name);
			if( $i <$num_fields-1)
				echo "$delimiter";
			$i++;
		}
		echo "\n";
		if( $num_rows> 0)
		{
			while( $row= mysql_fetch_row($result))
			{
				for( $i=0; $i <$num_fields; $i++)
				{
					echo mysql_real_escape_string($row[$i]);
					if( $i <$num_fields-1)
							echo "$delimiter";
				}
				echo "\n";
			}
		}
	}
	mysql_free_result($result);
}
function _mysqldump($mysql_database)
{
	$sql="show tables;";
	$result= mysql_query($sql);
	if( $result)
	{
		while( $row= mysql_fetch_row($result))
		{
			_mysqldump_table_structure($row[0]);
			if( isset($_REQUEST['sql_table_data']))
			{
				_mysqldump_table_data($row[0]);
			}
		}
	}
	else
	{
		echo "/* no tables in $mysql_database \n";
	}
	mysql_free_result($result);
}
function _mysqldump_table_structure($table)
{
	echo "/* Table structure for table `$table` \n";
	if( isset($_REQUEST['sql_drop_table']))
	{
		echo "DROP TABLE IF EXISTS `$table`;\n\n";
	}
	if( isset($_REQUEST['sql_create_table']))
	{
		$sql="show create table `$table`; ";
		$result=mysql_query($sql);
		if( $result)
		{
			if($row= mysql_fetch_assoc($result))
			{
				echo $row['Create Table'].";\n\n";
			}
		}
		mysql_free_result($result);
	}
}
function _mysqldump_table_data($table)
{
	$sql="select * from `$table`;";
	$result=mysql_query($sql);
	if( $result)
	{
		$num_rows= mysql_num_rows($result);
		$num_fields= mysql_num_fields($result);
		if( $num_rows> 0)
		{
			echo "/* dumping data for table `$table` \n";
			$field_type=array();
			$i=0;
			while( $i <$num_fields)
			{
				$meta= mysql_fetch_field($result, $i);
				array_push($field_type, $meta->type);
				$i++;
			}
			//print_r( $field_type);
			echo "insert into `$table` values\n";
			$index=0;
			while( $row= mysql_fetch_row($result))
			{
				echo "(";
				for( $i=0; $i <$num_fields; $i++)
				{
					if( is_null( $row[$i]))
						echo "null";
					else
					{
						switch( $field_type[$i])
						{
							case 'int':
								echo $row[$i];
								break;
							case 'string':
							case 'blob' :
							default:
								echo "'".mysql_real_escape_string($row[$i])."'";
						}
					}
					if( $i <$num_fields-1)
						echo ",";
				}
				echo ")";
				if( $index <$num_rows-1)
					echo ",";
				else
					echo ";";
				echo "\n";
				$index++;
			}
		}
	}
	mysql_free_result($result);
	echo "\n";
}
function _mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password)
{
	global $output_messages;
	$link = mysql_connect($mysql_host, $mysql_username, $mysql_password);
	if (!$link)
	{
	   array_push($output_messages, 'Could not connect: ' . mysql_error());
	}
	else
	{
		array_push ($output_messages,"Connected with MySQL server:$mysql_username@$mysql_host successfully");
		$db_selected = mysql_select_db($mysql_database, $link);
		if (!$db_selected)
		{
			array_push ($output_messages,'Can\'t use $mysql_database : ' . mysql_error());
		}
		else
			array_push ($output_messages,"Connected with MySQL database:$mysql_database successfully");
	}
}
if( $print_form>0 )
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>mysqldump.php version <?php echo $mysqldump_version; ?></title>
</head>
<body>
<?php
	foreach ($output_messages as $message)
	{
		echo $message."<br />";
	}

PopTable('header', 'Backup');
?>

<form id="dataForm" name="dataForm" method="post" action="for_export.php?modname=Tools/Backup.php&action=backup&_CENTRE_PDF=true" target=_blank>
<table border=0 width=280px><tr><td>

<table border="0" >
  
  <tr>
	<td>Output format: </td>
	<td>
	  <select name="output_format">
		<option value="SQL" <?php if( isset($_REQUEST['output_format']) && 'SQL' == $_REQUEST['output_format']) echo "selected";?>>SQL</option>
		<option value="CSV" <?php if( isset($_REQUEST['output_format']) && 'CSV' == $_REQUEST['output_format']) echo "selected";?>>CSV</option>
		</select>
	</td>
  </tr>
</table>
<div class="clear"></div>
<fieldset style="border:1px solid #cacaca"><legend>Dump options(SQL)</legend>
  <table border="0">
	<tr>
	  <td>Drop table statement: </td>
	  <td><input type="checkbox" name="sql_drop_table" <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['sql_drop_table'])) ; else echo 'checked' ?> /></td>
	</tr>
	<tr>
	  <td>Create table statement: </td>
	  <td><input type="checkbox" name="sql_create_table" <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['sql_create_table'])) ; else echo 'checked' ?> /></td>
	</tr>
	<tr>
	  <td>Table data: </td>
	  <td><input type="checkbox" name="sql_table_data"  <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['sql_table_data'])) ; else echo 'checked' ?>/></td>
	</tr>
</table></fieldset>
<br>
  <fieldset style="border:1px solid #cacaca"><legend>Dump options(CSV)</legend>
  <table border="0">
  <tr>
	<td>Delimiter:</td>
	<td><select name="csv_delimiter">
	  <option value="," <?php if( isset($_REQUEST['output_format']) && ',' == $_REQUEST['output_format']) echo "selected";?>>,</option>
	  <option value="Tab" <?php if( isset($_REQUEST['output_format']) && 'Tab' == $_REQUEST['output_format']) echo "selected";?>>Tab</option>
	  <option value="|" <?php if( isset($_REQUEST['output_format']) && '|' == $_REQUEST['output_format']) echo "selected";?>>|</option>
	</select>
	</td>
  </tr>
  <tr>
	<td>Table:</td>
	<td><input  type="input" name="mysql_table" value="<?php echo $_REQUEST['mysql_table']; ?>"  /></td>
  </tr>
	<tr>
	  <td>Header: </td>
	  <td><input type="checkbox" name="csv_header"  <?php if(isset($_REQUEST['action']) && ! isset($_REQUEST['csv_header'])) ; else echo 'checked' ?>/></td>
	</tr>
</table>
</fieldset>
<br>
<div align="center">
<input type="submit" name="action"  value="Export">
    </div><br />

</td></tr></table>
</form>

</body>
</html>
<?php
PopTable('footer');

}
*/



require_once("data.php");

if($_REQUEST['action']=='backup' )
{
	$cmd = "mysqldump ".$DatabaseName."  --u=".$DatabaseUsername;
	if($DatabasePassword != '')
	{
		$cmd .= " --password=".$DatabasePassword." --database ".$DatabaseName." >>".$DatabaseName.".".sql";
	}
	$output = exec($cmd);
	echo "$cmd: $output";
	force_download(".$DatabaseName.".".sql");
}
else
{
PopTable('header', 'Backup');
echo '<b>Do you want to backup the database?</b>';
echo "<br><br>";


echo '<form id="dataForm" name="dataForm" method="post" action="for_export.php?modname=Tools/Backup.php&action=backup&_CENTRE_PDF=true" target=_blank> 
    <br>
	    <center><input type="submit" value="Yes" name="actionButton" id="actionButton" class="btn_medium">&nbsp;&nbsp;
		<input type="button" value="Cancel" class="btn_medium" onclick=\'load_link("Modules.php?modname=misc/Portal.php");\'></center>
		 
</form> ';
PopTable('footer');
}
function force_download($file) 
{ 
 	   if ((isset($file))&&(file_exists($file))) { 
       header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename="'.$DatabaseName.'.sql"');
	   
       header("Content-Transfer-Encoding: Binary"); 
       
      readfile("$file"); 
    } else { 
       echo "No file selected"; 
    } //end if 

}//end function

?>

