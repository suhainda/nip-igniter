<?php
function getLabel($string){
	$array = explode("_", $string);
	$arrayUpperCase = array_map("ucwords", $array);
	$string = implode(" ", $arrayUpperCase);
	$string = str_replace(" Id", "", $string);
	return $string;
}

function getClassName($string){
	$array = explode("_", $string);
	$arrayUpperCase = array_map("ucwords", $array);
	$string = implode("", $arrayUpperCase);
	return $string;
}

function getStrippedClass($camelCaseClass){
	preg_match_all('/((?:^|[A-Z])[a-z]+)/',$camelCaseClass ,$matches);
	$strippedClass = changeClassName($matches[0]);
	return $strippedClass;
}

function getUnderscoredClass($camelCaseClass){
	preg_match_all('/((?:^|[A-Z])[a-z]+)/',$camelCaseClass ,$matches);
	$strippedClass = changeClassName($matches[0], "_");
	return $strippedClass;
}

function changeClassName($arrClassName = null, $str = "-"){
	if($arrClassName){
		$newClass = "";
		foreach ($arrClassName as $i => $value) {
			if($i==0){
				$newClass .= strtolower($value);
			}else{
				if(strtolower($value) == "controller")
					break;
				$newClass .= $str.strtolower($value);
			}
		}
		return $newClass;
	}
}

function createFile($folder, $filename, $content){
	$filepath = $folder.$filename;
	if(is_writable($folder)){
		if(!$file = fopen($filepath,'w')){
			return array('status' => 0, 'message'=> 'Failed to create the file '.$filepath);
		}

		if(!fwrite($file, $content)){
			return array('status' => 0, 'message'=> 'Failed to write content on the file '.$filepath);
		}

		fclose($file);
		return TRUE;
	}
	return array('status' => 0, 'message'=> $folder.' is not writable.');
}

function debug($var){
	echo "<pre>";
		print_r($var);
	echo "</pre>";
}

function getRandomString($length = 8) {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    
    return implode($pass); //turn the array into a string
}

if(false === function_exists('lcfirst'))
{
    function lcfirst( $str ) {
        $str[0] = strtolower($str[0]);
        return (string)$str;
    }
}

function deleteFolder($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            deleteFolder(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}