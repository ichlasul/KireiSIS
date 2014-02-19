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
error_reporting(1);

require_once '../../../functions/PopTable.php';
require_once '../../../functions/DrawTab.fnc.php';
require_once '../../../config.inc.php';
require_once '../../../database.inc.php';

function runScripts()
{
    try {
        $dbconn = db_start();
        $myFile = "sql/install.sql";
        executeSQL($myFile);
    }
    catch(Exception $e) {
        mysql_close($dbconn);
        return false;
    }

    mysql_close($dbconn);
    return true;
}

function executeSQL($myFile)
{
    $sql = file_get_contents($myFile);
    $sqllines = split("\n",$sql);
    $cmd = '';
    $delim = false;
    foreach($sqllines as $l)
    {
        if(preg_match('/^\s*--/',$l) == 0)
        {
            if(preg_match('/DELIMITER \$\$/',$l) != 0)
            {
                $delim = true;
            }
            else
            {
                if(preg_match('/DELIMITER ;/',$l) != 0)
                {
                    $delim = false;
                }
                else
                {
                    if(preg_match('/END\$\$/',$l) != 0)
                    {
                        $cmd .= ' END';
                    }
                    else
                    {
                        $cmd .= ' ' . $l . "\n";
                    }
                }
                if(preg_match('/.+;/',$l) != 0 && !$delim)
                {
                    $result = mysql_query($cmd) or die(mysql_error());
                    $cmd = '';
                }
            }
        }
    }
}
?>