<?php

if($_REQUEST['modfunc']=='update')
{
	if(UserStaffID() && AllowEdit())
	{
		if(count($_REQUEST['food_service']))
		{
			$sql = "UPDATE FOOD_SERVICE_STAFF_ACCOUNTS SET ";
			foreach($_REQUEST['food_service'] as $column_name=>$value)
				$sql .= $column_name.'=\''.str_replace("\'","''",str_replace("`","''",trim($value))).'\',';
			$sql = substr($sql,0,-1)." WHERE STAFF_ID='".$_REQUEST['staff_id']."'";
			DBQuery($sql);
		}
	}
	//unset($_REQUEST['modfunc']);
	unset($_REQUEST['food_service']);
	unset($_SESSION['_REQUEST_vars']['food_service']);
}

if(!$_REQUEST['modfunc'] && UserStaffID())
{
	

$checkstaff="SELECT * FROM FOOD_SERVICE_STAFF_ACCOUNTS WHERE staff_id = '".UserStaffID()."'";
$countstaff = DBGet(DBQuery($checkstaff));


if(!count($countstaff))
{
       
        #$sql = "INSERT INTO FOOD_SERVICE_ACCOUNTS (ACCOUNT_ID,BALANCE,TRANSACTION_ID) values('".UserStaffID()."','0.00','0')";
         #DBQuery($sql);

      $sql = "INSERT INTO FOOD_SERVICE_STAFF_ACCOUNTS (STAFF_ID,BARCODE,BALANCE) values('".UserStaffID()."','','0.00')";
				DBQuery($sql);
			
   

}




$staff = DBGet(DBQuery("SELECT s.STAFF_ID,concat(s.FIRST_NAME,' ',s.LAST_NAME,' ')AS FULL_NAME,(SELECT STATUS FROM FOOD_SERVICE_STAFF_ACCOUNTS WHERE STAFF_ID=s.STAFF_ID) AS STATUS,(SELECT BALANCE FROM FOOD_SERVICE_STAFF_ACCOUNTS WHERE STAFF_ID=s.STAFF_ID) AS BALANCE,(SELECT BARCODE FROM FOOD_SERVICE_STAFF_ACCOUNTS WHERE STAFF_ID=s.STAFF_ID) AS BARCODE FROM STAFF s WHERE s.STAFF_ID='".UserStaffID()."'"));
	$staff = $staff[1];

	echo '<TABLE width=100%>';
	echo '<TR>';
	echo '<TD valign=top>';
	echo '<TABLE width=100%><TR>';

	echo '<TD valign=top>'.NoInput($staff['FULL_NAME'],$staff['STAFF_ID']).'</TD>';
        echo '<TD valign=top>'.NoInput(($staff['BALANCE']<0?'<FONT color=red>':'').$staff['BALANCE'].($staff['BALANCE']<0?'</FONT>':''),'Balance').'</TD>';
	

     echo '</TR></TABLE>';
	echo '</TD></TR></TABLE>';
	echo '<HR>';

	echo '<TABLE width=100% border=0 cellpadding=0 cellspacing=0>';
	echo '<TR><TD valign=top>';

	echo '<TABLE border=0 cellpadding=6 width=100%>';
	echo '<TR>';
	/*echo '<TD>'.TextInput($staff['ACCOUNT_ID'],'food_service[ACCOUNT_ID]','Account ID','size=12 maxlength=10');
	
	if($staff['BALANCE']=='')
	{
		$warning = 'Non-existent account!';
		echo button('warning','','# onMouseOver=\'stm(["Warning","'.$warning.'"],["white","#006699","","","",,"black","#e8e8ff","","","",,,,2,"#006699",2,,,,,"",,,,]);\' onMouseOut=\'htm()\'');
	}
	echo '</TD>'; */

	$options = array('Inactive'=>'Inactive','Disabled'=>'Disabled','Closed'=>'Closed');
	echo '<TD>'.SelectInput($staff['STATUS'],'food_service[STATUS]','Status',$options,'Active').'</TD>';
	echo '</TR><TR>';
	$options = array('Reduced'=>'Reduced','Free'=>'Free');
	echo '<TD>'.SelectInput($staff['DISCOUNT'],'food_service[DISCOUNT]','Discount',$options,'Full').'</TD>';
	echo '<TD>'.TextInput($staff['BARCODE'],'food_service[BARCODE]','Barcode','size=12 maxlength=25').'</TD>';
	echo '</TR>';
	echo '</TABLE>';

	echo '</TD></TR>';
	echo '</TABLE>';
}


/*
if($staff['BALANCE']=='')
	{
		$warning = 'This user does not have a Meal Account.';
		echo '<BR>'.button('warning','','# onMouseOver=\'stm(["Warning","'.$warning.'"],["white","#006699","","","",,"black","#e8e8ff","","","",,,,2,"#006699",2,,,,,"",,,,]);\' onMouseOut=\'htm()\'');
	}
	echo '</TD>';
        echo '<TD valign=top>'.NoInput(($staff['BALANCE']<0?'<FONT color=red>':'').$staff['BALANCE'].($staff['BALANCE']<0?'</FONT>':''),'Balance');
	if($staff['BALANCE']=='')
	{
		$warning = 'This user does not have a Meal Account.';
		echo '<BR>'.button('warning','','# onMouseOver=\'stm(["Warning","'.$warning.'"],["white","#006699","","","",,"black","#e8e8ff","","","",,,,2,"#006699",2,,,,,"",,,,]);\' onMouseOut=\'htm()\'');
	}
	echo '</TD>';

        echo '</TR></TABLE>';
        echo '</TD></TR></TABLE>';
        echo '<HR>';

	echo '<TABLE width=100% border=0 cellpadding=0 cellspacing=0>';
	echo '<TR><TD valign=top>';

	echo '<TABLE border=0 cellpadding=6 width=100%>';
	echo '<TR>';
	$options = array('Inactive'=>'Inactive','Disabled'=>'Disabled','Closed'=>'Closed');
	echo '<TD>'.SelectInput($staff['STATUS'],'food_service[STATUS]','Status',$options,'Active').'</TD>';
	echo '<TD>'.TextInput($staff['BARCODE'],'food_service[BARCODE]','Barcode','size=12 maxlength=25').'</TD>';
	echo '</TR>';
	echo '</TABLE>';

	echo '</TD></TR>';
	echo '</TABLE>';
}*/
?>
