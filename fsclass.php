<?php
/*************************************
	Mercsoft filesystem class
*************************************/

 class Fs
 {
 	public static function create($factoryname)
 	{

		return new $factoryname();
	}

 	
 } 


class File
{
	public $folder,$params,$files,$extPattern,$newName;
	//$params = file list, $files= uploaded, $extPattern=file extention list, $newName= uploaded files new Name
	
	//multi file upluad 
	public function fUpload($type)
	{
		$ok=0;
		$count=count($_FILES[$this->files]["tmp_name"]);  //how many files came

		for($i=0;$i<$count;$i++){ //count files
			$this->newName=$_FILES[$this->files]["name"][$i]; //new name
			$kont=$type=="image" ? getimagesize($_FILES[$this->files]["tmp_name"][$i]):preg_match($this->extPattern,$_FILES[$this->files]["type"][$i]);
			//if type=image, get image size to validate image file, else get extension
			
			if($kont!==0){ //if the file is real and/or have we allow upload the filetyepes
				$son=move_uploaded_file($_FILES[$this->files]["tmp_name"][$i],$this->folder.$this->newName) ? $ok++ : false; // if successful count uploaded files 


			}
		}
		return $ok; //how many files uploaded
		clearstatcache();

	}

	/*****  multi delete*****/
	public function fDel() 
	{
		$i=0; 
		$here=getcwd(); //where are we
		chdir($this->folder); //go to the target directory
		foreach ($this->params as $dels) { //get file list
			if(is_file($dels)){ //is the file exist
				if(unlink($dels)){$i++;} //if the file deleted, count up
			}
		}
		return $i;
		chdir($here); //return back(optional)
		clearstatcache();

	}

	public function fList(){
		$here = getcwd();  
		chdir($this->folder); 
		return glob($this->extPattern,$this->params); //return array file list using extPatterrn
		chdir($here); 
		clearstatcache();
	}

} //File

