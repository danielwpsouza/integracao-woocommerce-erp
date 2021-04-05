<?php
$s =  mysql_query("SELECT * FROM `conf_erp`");
$ap = mysql_fetch_object($a);
if(isset($_POST['NRORG']) AND $_POST['NRORG'] != ''){
	$NRORG           = $_POST['NRORG'];
	$USER	         = $_POST['USER'];
	$CONN	         = $_POST['CONN'];
	$HOST            = $_POST['HOST'];
	$PORT			 = $_POST['PORT'];
	$DBNAME          = $_POST['DBNAME'];
	$RETORNO_EMAIL1  = $_POST['RETORNO_EMAIL1'];
	$RETORNO_EMAIL2  = $_POST['RETORNO_EMAIL2'];
	$NRSEQWEBSERVICE = $_POST['NRSEQWEBSERVICE'];
	$LINK_AUT		 = $_POST['LINK_AUT'];
	$LINK_PROD		 = $_POST['LINK_PROD'];
	$LINK_CLI		 = $_POST['LINK_CLI'];
	$act = mysql_query("UPDATE `conf_erp` SET 
		`NRORG` = '$NRORG',
		`USER` = '$USER',
		`CONN` = '$CONN',
		`HOST` = '$HOST',
		`PORT` = '$PORT',
		`DBNAME` = '$DBNAME',
		`RETORNO_EMAIL1` = '$RETORNO_EMAIL1',
		`RETORNO_EMAIL2` = '$RETORNO_EMAIL2',
		`NRSEQWEBSERVICE` = '$NRSEQWEBSERVICE',
		`LINK_AUT` = '$LINK_AUT',
		`LINK_PROD` = '$LINK_PROD',
		`LINK_CLI` = '$LINK_CLI'
		WHERE `idconf_erp` = '1'
	");
	header("location:?atualizar");
	exit();
}


?>

<h3><strong>Importante:</strong> Só mude isso caso você tenha conhecimento dos dados.</h3>
<form method="post" action="?atualizar">
	NRORG: 			<input type="text" value="<?php echo $ap->NRORG; ?>" name="NRORG" required>
	USER:  			<input type="text" value="<?php echo $ap->USER; ?>" name="USER" required>
	CONN:  			<input type="text" value="<?php echo $ap->CONN; ?>" name="CONN" required>
	HOST:  			<input type="text" value="<?php echo $ap->HOST; ?>" name="HOST" required>
	PORT:   		<input type="text" value="<?php echo $ap->PORT; ?>" name="PORT" required>
	DBNAME: 		<input type="text" value="<?php echo $ap->DBNAME; ?>" name="DBNAME" required>
	RETORNO_EMAIL1: <input type="email" value="<?php echo $ap->RETORNO_EMAIL1; ?>" name="RETORNO_EMAIL1" required>
	RETORNO_EMAIL2: <input type="email" value="<?php echo $ap->RETORNO_EMAIL2; ?>" name="RETORNO_EMAIL2" required>
	NRSEQWEBSERVICE:<input type="text" value="<?php echo $ap->NRSEQWEBSERVICE; ?>" name="NRSEQWEBSERVICE" required>
	LINK_AUT: 		<input type="text" value="<?php echo $ap->LINK_AUT; ?>" name="LINK_AUT" required>
	LINK_PROD: 		<input type="text" value="<?php echo $ap->LINK_PROD; ?>" name="LINK_PROD" required>
	LINK_CLI: 		<input type="text" value="<?php echo $ap->LINK_CLI; ?>" name="LINK_CLI" required>
	<input type="submit" name="act_erp" value="Atualizar">
</form>