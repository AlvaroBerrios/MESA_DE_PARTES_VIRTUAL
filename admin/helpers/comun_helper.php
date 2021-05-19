<?php

	
## Funciones Comunes ##
	//	// funciones de fechas
	/**
	 * dateSmart
	 */	
	function dateSmart($dateIn, $template='{hour}:{min} {day}-{month:name}-{year}'){

		$dateIn .= (strlen($dateIn)<=10) ? " 00:00:00":'';
		$dateOut = $template;

		$dater['year']	 = substr ($dateIn,0,4);
		$dater['month']	 = substr ($dateIn,5,2);
		$dater['day']	 = substr ($dateIn,8,2);
		$dater['hour']	 = substr ($dateIn,11,2);
		
		if( $dater['hour'] >12) {
			$dater['hour'] = $dater['hour'] - 12;
			$dater['meridian'] = 'pm';
		}else{
			$dater['meridian'] = 'am';
		}
		$dater['min']	 = substr ($dateIn,14,2);
		$dater['seg']	 = substr ($dateIn,17,2);
		
		$dateOut = str_replace('{year}', $dater['year'] ,$dateOut );
		$dateOut = str_replace('{month}', $dater['month'] ,$dateOut );
		$dateOut = str_replace('{day}', $dater['day'] ,$dateOut );
		$dateOut = str_replace('{hour}', $dater['hour'] ,$dateOut );
		$dateOut = str_replace('{min}', $dater['min'] ,$dateOut );
		$dateOut = str_replace('{seg}', $dater['seg'] ,$dateOut );
		$dateOut = str_replace('{meridian}', $dater['meridian'] ,$dateOut );
		

		
		if( substr_count($dateOut, '{month:name}') ){
			$dateOut = str_replace('{month:name}', date_month_name($dater['month']) ,$dateOut );
		}


		if( substr_count($dateOut, '{day:name}') ){
			$mkdate = mktime(0,0,0,$dater['month'], $dater['day'], $dater['year']);
			$dateOut = str_replace('{day:name}', date_day_name( date("w", $mkdate) ) , $dateOut );
		}
		return $dateOut;
	}

    function daySmart($numberDay,$template='{day:name}'){
		$dateOut = $template;
	
		$dateOut = str_replace('{day:name}', date_day_name($numberDay) ,$dateOut );
		return $dateOut;
    }
	function date_month_name( $mm ){
		if(trim($mm)=='') return '';
		$months = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		return $months[ abs( $mm  )];
	}
    function date_day_name( $mm ){
		if(trim($mm)=='') return '';
		$days = array('Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','Sabado');
		return $days[ abs( $mm  )];
	}
	function dateNow( $format = "Y-m-d H:i:s" ){
		return date( $format, ( time()-18000 ) ); 
		//return date("Y-m-d H:i:s" ); 
	}
	function dateAgo( $str ){

		list( $date, $hour) = split( ' ', $str );
		
		list( $yy, $mm, $dd) = split( ' ', $date );
		
		if ( substr_count( ":", $hour ) == 0 ){
			$hh = $ii = $ss = 0;
		}else{
			list( $hh, $ii, $ss) = split( ' ', $hour );	
		}
		
		$tmp = time() - mktime($hh, $ii, $ss, $mm, $dd, $yy);
		
		
	}

	function days_in_month($month = 0, $year = '')
	{
		if ($month < 1 OR $month > 12)
		{
			return 0;
		}
	
		if ( ! is_numeric($year) OR strlen($year) != 4)
		{
			$year = date('Y');
		}
	
		if ($month == 2)
		{
			if ($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0))
			{
				return 29;
			}
		}

		$days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		return $days_in_month[$month - 1];
	}

	/* Funciones iconodelamoda */
	function get_porcentaje($param1, $param2, $precision=2) {
		if ( $param2 ) {
			$value = round($param1 * 100 / $param2, $precision) * 100;			
			$result = str_pad($value, 5,' ',0);
			$prefijo_cero = ( $value < 100 ) ? '0' : '';
			return $prefijo_cero . trim(substr($result,0,3)) . "." . trim(substr($result,3,2));
		}
		else
			return "0.00";
	}
	
	
    function get_facebook_cookie($app_id, $application_secret) {
		$args = array();

		if (isset($_COOKIE['fbs_' . $app_id])){
			parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
			ksort($args);
			$payload = '';
			foreach ($args as $key => $value) {
			if ($key != 'sig') {
			  $payload .= $key . '=' . $value;
			}
			}
			if (md5($payload . $application_secret) != $args['sig']) {
			return null;
			}
		}
		return $args;
    }
	
	function make_seed()
	{
	  list($usec, $sec) = explode(' ', microtime());
	  return (float) $sec + ((float) $usec * 100000);
	}

 
	function show_embed_video($url) {
		$media = $url;
		$media = str_replace("http://","",$media);
		$media = str_replace("www.youtube.com/","",$media);
		$media = str_replace("watch?v=","",$media);
		return '<a href="'.$url.'" target="_blank"><img width="145" src="http://i2.ytimg.com/vi/'.$media.'/default.jpg"/></a>';
	}
		
	
	function format_date($fecha, $type=''){
		$hour='';
		$meridiano='';
		if(strlen(trim($fecha))==19):
			list($fecha,$hour,$meridiano) = explode(" ",$fecha);
		endif;
	
		//formato fecha americana
		switch($type)
		{
			default:
				$result=date("d/m/Y",strtotime($fecha));
			break;
			case 'en':
				$result=date("Y-m-d",strtotime(str_replace("/","-",$fecha)));
				
			break;
		
		}
		return trim($result." ".$hour);
		
	}

	function makehrs_real($hour){
		if(strstr($hour,'pm'))
		{
			switch(substr($hour,0,2))
			{
				case '12':
				$hreal=str_replace(substr($hour,0,2),'12',$hour);
				break;
				
				case '11':
				$hreal=str_replace(substr($hour,0,2),'23',$hour);
				break;

				case '10':
				$hreal=str_replace(substr($hour,0,2),'22',$hour);
				break;
				
				case '09':
				$hreal=str_replace(substr($hour,0,2),'21',$hour);
				break;
				
				case '08':
				$hreal=str_replace(substr($hour,0,2),'20',$hour);
				break;

				case '07':
				$hreal=str_replace(substr($hour,0,2),'19',$hour);
				break;

				case '06':
				$hreal=str_replace(substr($hour,0,2),'18',$hour);
				break;
				
				case '05':
				$hreal=str_replace(substr($hour,0,2),'17',$hour);
				break;

				case '04':
				$hreal=str_replace(substr($hour,0,2),'16',$hour);
				break;
				
				case '03':
				$hreal=str_replace(substr($hour,0,2),'15',$hour);
				break;
				
				case '02':
				$hreal=str_replace(substr($hour,0,2),'14',$hour);
				break;

				case '01':
				$hreal=str_replace(substr($hour,0,2),'13',$hour);
				break;
			}
		}
		else
		{
			switch(substr($hour,0,2))
			{
				case '12':
				$hreal=str_replace(substr($hour,0,2),'00',$hour);
				break;
				
				default:
				$hreal=$hour;
				break;
			}
			
			
		}
		return $hreal;
	}
	
	function Delete_Directory($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
			else
				delete_directory($dirname.'/'.$file);
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	} 
	
	function site_resource($ext=""){
		return base_url().str_replace("//","/","resource/".$ext);
	}

	function writer($var){
		echo("<pre>".print_r($var,true)."</pre>");
	}

	function CutText($texto,$size){
		$texto = strip_tags(trim($texto));
		if(strlen($texto)>$size){
			for($i=$size;$i>0;$i--){
				if(substr($texto,$i,1)==" "){
					return substr($texto,0,$i)."...";
					break;
				}
			}
		} else {
			return $texto;	
		}			
	}
	
	
	function Get_DatesOfBetween($dateStart,$dateEnd){//Retorna todas las fechas que hay entre dos fechas
		$date_Start=strtotime($dateStart);
		
		$date_End=strtotime($dateEnd);
		$dateArray = array();
		for($i=$date_Start; $i<=$date_End; $i+=86400){
			array_push($dateArray, date("d-m-Y", $i));
		}
		
		return $dateArray;

	}
	
	function makedays(){
		$digit='00';
		for($i=1;$i<32;$i++){ 
			echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.substr($digit,0,strlen($digit)-strlen($i)).$i.'</option>';
		} 
	}
	
	function makemonths($name=''){
		$digit='00';
		$mes=array('1'=>'ENERO', '2'=>'FEBRERO', '3'=>'MARZO', '4'=>'ABRIL', '5'=>'MAYO', '6'=>'JUNIO', '7'=>'JULIO', '8'=>'AGOSTO', '9'=>'SETIEMBRE', '10'=>'OCTUBRE', '11'=>'NOVIEMBRE', '12'=>'DICIEMBRE');
		switch($name){
			default:
			case '':
				for($i=1;$i<=12;$i++){
					echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.substr($digit,0,strlen($digit)-strlen($i)).$i.'</option>';
				}
			break;
			
			case 'SHORTNAME':
				for($i=1;$i<=12;$i++){
					echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.substr($mes[$i],0,3).'</option>';
				}
			break;
			case 'shortname':
				for($i=1;$i<=12;$i++){
					echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.ucfirst(strtolower(substr($mes[$i],0,3))).'</option>';
				}
			break;
			
			case 'NAME':
				for($i=1;$i<=12;$i++){
					echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.$mes[$i].'</option>';
				}
			break;
			case 'name':
				for($i=1;$i<=12;$i++){
					echo '<option value="'.substr($digit,0,strlen($digit)-strlen($i)).$i.'">'.ucfirst(strtolower($mes[$i])).'</option>';
				}
			break;
		}
		
		
	}
	
	function makeyears($inicio='',$fin=''){
		if(!empty($inicio) and !empty($fin)){
			$start=$inicio;
			$end = $fin;	
		}
		else{
			$start = date('Y')-95;
			$end = date('Y');
		}
		for($i=$end;$i>=$start;$i--){
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
	}
	
	function Get_Days_Month($date=''){
		$days = array();
		if(empty($date)):
			$maxDays = date("t",mktime(0,0,0,date("n"),date("j"),date("Y")));
		else:
			$date = substr($date,0,10);
			list($anio,$mes,$dia)= explode("-",$date);
			$maxDays = date("t",mktime(0,0,0,(int)$mes,(int)$dia,(int)$anio));
		endif;
		
		for($d=1;$d<=$maxDays;$d++){
			array_push($days,$d);
		}
		
		return $days;
	}
	
	function Get_Calendary($date = ''){
		$_cal = array();
		if(empty($date)):
			$day_start = date("N",mktime(0,0,0,date("n"),date("j"),date("Y")));
			$ndays = Get_Days_Month(date('Y-m-d'));
			$day_end = date('N',mktime(0,0,0,date("n"),(int)$ndays[count($ndays)-1],date("Y")));
		else:
			list($anio,$mes,$dia)= explode("-",$date);
			$day_start = date('N',mktime(0,0,0,(int)$mes,(int)$dia,(int)$anio));
			$ndays = Get_Days_Month($date);
			$day_end = date('N',mktime(0,0,0,(int)$mes,(int)$ndays[count($ndays)-1],(int)$anio));
		endif;
		
		$NroOfWeek = ceil((count($ndays)+($day_start-1))/7);
		
		for($j=1;$j<=($day_start-1);$j++){
			array_unshift($ndays,"");
		}
		for($h=1;$h<=(7-$day_end);$h++){
			array_push($ndays,"");
		}
				
		$_cal['day_star'] = $day_start;
		$_cal['day_end'] = $day_end;
		$_cal['ndays'] = $ndays;
		
		$_cal['nweek'] = $NroOfWeek;
		return $_cal;
		
	}
	
	function To_Upper($str){
		$_search = array("á","é","í","ó","ú");
		$_replace = array("Á","É","Í","Ó","Ú");
		$res = strtoupper($str);
		return str_replace($_search,$_replace,$res);
		
	}
	
	function cleanString($string)
	{
	 
		$string = trim($string);
	 
		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);
	 
		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);
	 
		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);
	 
		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);
	 
		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);
	 
		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);
	 
		//Esta parte se encarga de eliminar cualquier caracter extraño
		$string = str_replace(
			array("\\", "¨", "º", "-", "~",
				 "#", "@", "|", "!", "\"",
				 "·", "$", "%", "&", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "`", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "<", ";", ",", ":",
				 " "),
			'',
			$string
		);
	 
	 
		return $string;
	}
	
	function Get_Ip_User() {
		return getenv('HTTP_X_FORWARDED_FOR') ?  getenv('HTTP_X_FORWARDED_FOR') :  getenv('REMOTE_ADDR');
	}
	function Add_Ceros($suma,$field){
	
		$cantceros = strlen($field)-strlen($suma);
		
		return str_repeat("0",$cantceros).$suma;
	}
	function Agrupa_Piezas($data = array()){
		$result = array();
		$tempArr = array();
		$obj = new stdClass;
		$peso = $precio = 0;
		if(count($data)>0){
			$count = ceil(count($data)/2);
			for($i=0;$i<$count;$i++){
				array_push($tempArr,array_slice($data,$i*2,2));
			}
			
			foreach($tempArr as $key=>$items){
				foreach($items as $item){
					$peso = $peso + $item->peso;
					$precio = $item->precio;
					
				}
				$obj->peso = $peso;				
				$result[$key] = array('peso'=>$peso,'precio'=>$precio);
				$peso = $precio = 0;
				
			}
			
			return $result;
		}
		else{
			return false;
		}
	}
	
	
	function generateRandomPass($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ijklmnopqrstuvwxyzABCDEFGHIJ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
} 
	

function llamadoApi($method, $url, $data = false)
	{
		$curl = curl_init();
		
		switch ($method)
		{
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
	
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_PUT, 1);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
					
		}
	
		// Optional Authentication:
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		curl_setopt($curl, CURLOPT_USERPWD, "[adjudicaciones]$[ug3l03]:=?wsadj-ap");
	
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
		$result = curl_exec($curl);
		$result = json_decode($result);
		
		curl_close($curl);
	
		return $result;
	}

?>