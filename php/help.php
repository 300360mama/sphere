<?php

function dump($var){

	echo "<pre>";

	var_dump($var);

	echo "</pre>";

	

}

function prepare_params(array $params){

	$res = [];

	foreach ($params as $key => $value) {
		$res[':'.$key] = $value;
	}

	return $res;
}

function send_mail($params, $file_name, $admin_email){

$subj = "Send message to admin";
$to = $params['email'];
$f = fopen($file_name,"rb");

$bound="123kssdsjfsfskdfsadafd";

$headers = 'From: sandrostecuk@gmail.com'.'\r\n';
$headers.= 'To: '.$params['email'].'\r\n';
$headers.= 'Mime-Version: 1.0\r\n';
$headers.= 'Content-Type: multipart/related; boundary='.$bound.'\r\n';


$body= '--'.$bound.'\r\n';
$body.= 'Content-type: text/html; charset="utf8"'.'\r\n';
$body.= 'Content-Transfer-Encoding: 8bit'.'\r\n';


$body.= '<table>
		<tr>
			<td>Імя</td>
			<td>'.$params['firstname'].'</td>
		</tr>
		<tr>
			<td>Прізвище</td>
			<td>'.$params['lastname'].'</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>'.$params['email'].'</td>
		</tr>
		<tr>
			<td>Комент</td>
			<td>'.$params['comment'].'</td>
		</tr>
		<tr>
			<td>Фото</td>
			<td><img src="cid:img_id_123"></td>
		</tr>
	</table>
';



$body.= '\r\n--'.$bound.'\r\n';
$body.= 'Content-Type: image/jpeg; name="'.basename($file_name).'"\r\n';
$body.= 'Content-Transfer-Encoding:base64\r\n';
$body.= 'Content-ID: img_id_123\r\n';

$body.= base64_encode(fread($f,filesize($file_name))).'\r\n';
$body.= '--'.$bound.'--\r\n';


mail($admin_email, $subj, $body, $headers);

}