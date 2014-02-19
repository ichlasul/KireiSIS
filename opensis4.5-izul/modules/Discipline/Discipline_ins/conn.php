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

?>
														error_reporting(1);
														session_start();
														$conn_string = "host=".$_POST["server"]." port=".$_POST["port"]." dbname=template1 user=".$_POST["addusername"]." password=".$_POST["addpassword"];
														$_SESSION['conn'] = $conn_string;
														$_SESSION['username'] = $_POST["addusername"];
														$_SESSION['password'] = $_POST["addpassword"];
														$_SESSION['server'] = $_POST["server"];
														$_SESSION['port'] = $_POST["port"];

														$err .= "<table><tr><td>";
														$err .= "<font color=red><b>Couldn't connect to database</b></font></td></tr>";
														$err .= "<tr><td><b>Possible causes are:</b></td></tr>";
														$err .= "<tr><td>1)  Postgres is not installed. Try downloading from <a href='http://www.postgresql.org/download/'>Postgres Website</a></td></tr>";
														$err .= "<tr><td>2)  Php.ini is not properly configures. Search for pgSQL in php.ini and uncomment the line <br><img src='images/error_1.JPG'></td></tr>";
														$err .= "<tr><td>3)  Username or Password or Postgres Configuration incorrect</td><tr>";
														$err .= "<tr><td><br><a href='index.php?step=1'><b>Retry</b><a>";
														$err .= "</td></tr></table>";
														$err .= "</td>
																		  </tr>
																		</table>
																	  </div>
																	</div>
																	<div class=tab_footer></div>
																  </div>
																</div>
															  </div>
															</div>
															<div class=footer>
															  <div class=footer_txt><strong>Copyright 2007</strong> Open Center. All Rights Reserved</div>
															</div>
														  </div>
														</center>
														</body>
														</html>";


														//$dbconn = pg_connect($conn_string)
														//or exit("<p><font color=red>Couldn't connect to database</font></p>");
														//or
														//exit($err);


														//pg_close($dbconn);

														header('Location: index.php?step=2');
														echo '<script type="text/javascript">window.location.href="index.php?step=2"</script>';

														?>
