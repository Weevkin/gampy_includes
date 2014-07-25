<?php

	class Main{
		//Initiate game variables and ya know... stuff...
		public $symbols = array();
		public $levels = array();
		
		//Remember, the end goal of THIS portion is to generate a constantly refreshing XML document of data which will be read via a different ajax piece later on.
		public function __construct(){
			
			//Path to the main gampy_includes
			require_once(GAMPY_INC."/includes/functions.php");
			require_once(GAMPY_INC."/includes/globals.php");
			$this->symbols = simplexml_load_file(GAMPY_INC."/includes/game_core/symbols.xml");
			$this->levels = simplexml_load_file(GAMPY_INC."/includes/game_core/levels.xml");
			
			//Call to Menu function will come here.. for now, lets just go to level loop.
			
			$this->Play();
		}
		
		//Could add a call to ($level) in this function declaration level to allow skipping
		//For debug purposes.
		
		private function display($output, $check){
			if($check != 0){
				echo $output;
			}
		}
		
		public function findGampy($levelxml = array()){
			//Find level start..
			$i = 0;
				
			foreach($levelxml as $line){
				$tile = str_split($line);
				foreach($tile as $k => $val){
					if($val == 'g'){
						$start['col'] = $k;
						$start['row'] = $i;
						
						return $start;
					}
					
				}
				$i++;
			}
		}
		
		public function Play(){
			ob_start();
			foreach($this->levels as $n => $level){
					
				//Load the level tile set
				$tiles = $this->symbols->$n;
				//Load Level Layout..
				$layout = file_get_contents(GAMPY_INC."/includes/levels/".$n);
				
				$lines = explode("\r\n", $layout);
				
				//Find level start
				$start = $this->findGampy($lines);
				echo "<table>";
				$i = 0;
				
				//Put this in config later..
				//ss = screensize;
				$ss = 5;
				
				foreach($lines as $line){
					$output = 0;
					//if start row is between -7 or +7 of our $start['row']
					if($i >= $start['row']-$ss){ $output = 1; }
					$this->display("<tr>", $output);
					$tile = str_split($line);
					
					foreach($tile as $k => $val){
						//If the current COLUMN we are on is within 7 or less....
						$tout = 0;
						if($k <= $start['col']+$ss+5) $tout = 1;
						if($k >= $start['col']+$ss+5) $tout = 0;
						
						if($output == 0) $tout = 0;
						
						if($val == ';') continue;
						//Get the symbols name	
						$sname = $tiles->$val;
						
						if($val == 'g'){
							//Initiate level start
							
							//Set start piece:
							
							
							//Get coords.
							$row = $i;
							$col = $k;
							$sname = 'Gampy';
						}
						
						$this->display("<td>", $tout);
						$this->display("<img src='/images/".strtolower($sname).".png' />", $tout);
						//echo $val;
						$this->display("</td>", $tout);
						
					}
					$this->display("</tr>", $output);
					$i++;
				}
				echo "<table>";
				
			}
			$output = ob_get_clean();
			echo $output;
		}
	}

?>