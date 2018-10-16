<?php
include 'php/help.php';

spl_autoload_register(function($class){
	include 'php/'.$class.'.php';
});

session_start();

$validate = new Validate();
$file_obj = new File();
$db = new DB('users');


if(!$validate->isEmpty($_POST)){

	$email = $_POST['email'];
	$file = $_FILES['user'];


	if(!$validate->email($email)){
		$_SESSION['error'] = 'Заповніть всі поля форми правильно!!!';
	    header("Location:".$_SERVER['HTTP_REFERER']);
	}

	

	if(!$validate->file($file['name'])){
		$_SESSION['error'] = 'Виберіть картинку з розширенням jpg, gif або png!!!';
	    header("Location:".$_SERVER['HTTP_REFERER']);
	}

	if($file_obj->move($file['tmp_name'], $file['name'])){

		$params = $validate->replaceHtmlTag($_POST);
		$res = $db->insert($params);


		$file_name = $file_obj->getDir().$file['name'];
        send_mail($params, $file_name, 'admin@admin.com');
		


		if($res){
			$_SESSION['error'] = 'Всі данні успішно добавлені!!!';
	        header("Location:".$_SERVER['HTTP_REFERER']);
		}

	}


}else{

    $_SESSION['error'] = 'Заповніть всі поля форми!!!';
	header("Location:".$_SERVER['HTTP_REFERER']);
	
}

















