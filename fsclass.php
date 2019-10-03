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
	
	/*****    toplu dosya yükle resim ve dosya *****/
	public function fUpload($type)
	{
		$ok=0;
		$count=count($_FILES[$this->files]["tmp_name"]);  //kaç dosya geldi

		for($i=0;$i<$count;$i++){ //gelen dosya sayısı kadar
			$this->newName=$_FILES[$this->files]["name"][$i]; //dosyaı isimlendir
			$kont=$type=="image" ? getimagesize($_FILES[$this->files]["tmp_name"][$i]):preg_match($this->extPattern,$_FILES[$this->files]["type"][$i]);
			
			
			if($kont!==0){ //uzantılara izin verdik mi ve dosya gerçek mi
				$son=move_uploaded_file($_FILES[$this->files]["tmp_name"][$i],$this->folder.$this->newName) ? $ok++ : false; // olumlu sayısını bir arttır


			}
		}
		return $ok; //kaç dosya yüklendi
		clearstatcache();

	}

	/*****  isim isim toplu sil*****/
	public function fDel() 
	{
		$i=0; //kaç dosya silindi başı
		$here=getcwd(); //nerdeyiz not al
		chdir($this->folder); //hedef klasöre git
		foreach ($this->params as $dels) { //dosya listesi al
			if(is_file($dels)){ //dosya var mı
				if(unlink($dels)){$i++;} //sildiyse bir arttır
			}
		}
		return $i;
		chdir($here); //başa dön (şart değil ama olsun);
		clearstatcache(); //durum temizle ?

	}

	public function fList(){
		$here = getcwd();  //nerdeyiz
		chdir($this->folder); //klasöre git;
		return glob($this->extPattern,$this->params); //array liste
		chdir($here); //geri dön geri dön ne olur geri dön
		clearstatcache();
	}

} //File

