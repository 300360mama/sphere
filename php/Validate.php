<?php

class Validate{

	private $file_ext = ['jpg', 'png'];
	private $pattern_email = '/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/';

	/**
	 * [Перевірка розширення файлу на відповідніть списку]
	 * @param  string $file_name [description]
	 * @return [boolean]            [description]
	 */
	public function file(string $file_name){

		$explode_str = explode('.',$file_name);
		$ext = $explode_str[count($explode_str)-1];

		if(in_array($ext, $this->file_ext)){
			return true;
		}

		return false;
	}

	/**
	 * [Певірка електронної пошти на відповідність шаблону]
	 * @param  string $email [description]
	 * @return [boolean]        [description]
	 */
	public function email(string $email){

		$res = false;

		$res = filter_var($email, FILTER_VALIDATE_EMAIL);
		$res = preg_match($this->pattern_email, $res) ? true : false;

		return $res;
	}

	/**
	 * [Перевіряє массив на наявність пустих значень]
	 * @param  array   $input [description]
	 * @return boolean        [description]
	 */
	public function isEmpty(array $input){

		$res = true;
		foreach ($input as $value) {
			$res = $res && empty($value);
		}

		return $res;
	}

	/**
	 * [Заміна всіх HTML сущностей]
	 * @param  array  $input [description]
	 * @return [array]        [description]
	 */
	public function replaceHtmlTag(array $input){

		$res = [];
		foreach ($input as $name=>$value) {
			$res[$name] = htmlspecialchars((string) $value);
		}

		return $res;

	}


    /**
     * [Установка доступних розширень картинок]
     * @param array $ext [description]
     */
	public function setExt(array $ext){
		$this->file_ext = $ext;

		return true;
	}

	/**
	 * [Повертає массив з розширеннями картинок]
	 * @return [array] [description]
	 */
	public function getExt(){
		return $this->file_ext;
	}


}