												<?
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
