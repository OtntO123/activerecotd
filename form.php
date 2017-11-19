<?PHP
class form{
	static public function upld() {	//Select SQL form
	$msg = '<form action="index.php" method="post" enctype="multipart/form-data">';
	$msg .= '<h1 style="color:LightGreen;">Select SQL Code: </h1>';

	$msg .= '<select name="databasename">';
	$msg .= '<option value="accounts">accounts</option>';
	$msg .= '<option value="todos">todos</option>';
	$msg .= '</select>';

	$msg .= '<select name="collection">';
	$Allfunctions = get_class_methods("collections");
	unset($Allfunctions[0]);
	foreach ($Allfunctions as $functionname)
	$msg .="<option value=$functionname>$functionname</option>";
	$msg .= '</select>';

	$msg .= '<input type="submit" value="Run" name="submit">';
	$msg .= '</form>';
	return $msg;
	}
}




