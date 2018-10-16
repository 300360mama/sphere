<?php 

class File{

	private $default_dir =  __DIR__.'/../imgs/user_imgs/';

	/**
	 * [Перемішення отриманого файлу в вказану папку]
	 * @param  [string] $path_to_file [description]
	 * @param  [string] $new_name     [description]
	 * @return [boolean]               [description]
	 */
	public function move(string $path_to_file, string $new_name){

		$new_path = $this->default_dir.$new_name;

		if(is_file($path_to_file)){
			
			return move_uploaded_file($path_to_file, $new_path);
		}

		return false;
	}
    
    /**
     * [Видалення картинки]
     * @param  [string] $file_name [description]
     * @return [boolean]            [description]
     */
	public function remove(string $file_name){

		$full_name = $this->default_dir.$file_name;

		if(is_file($full_name)){
			 return unlink($full_name);
		}

		return false;

	}

	/**
	 * [Перейменування картинки]
	 * @param  [string] $old_name [description]
	 * @param  [string] $new_name [description]
	 * @return [boolean]           [description]
	 */
	public function rename(string $old_name, string $new_name){

		$full_name = $this->default_dir.$old_name;
		$new_full_name = $this->default_dir.$new_name;

		if(is_file($full_name)){
			return rename($full_name, $new_full_name);
		}

		return false;
	}


	public function setDir(string $dir){
		$this->default_dir = $dir;
	}

	public function getDir(){
		return $this->default_dir;
	}
}