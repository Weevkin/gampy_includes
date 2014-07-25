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
			
			//Cheat in some css..
			echo "
				<style>
					body{
						font-family: monospace;
					}
					table tr td{
						padding:0px;
						margin:0px;
						border:none;
					}
					img{
						width:64px;
					}
				</style>";
			
			$this->Play();
		}
		
		//Could add a call to ($level) in this function declaration level to allow skipping
		//For debug purposes.
		
		public function Play(){
			
			foreach($this->levels as $n => $level){
					
				//Load the level tile set
				$tiles = $this->symbols->$n;
				//Load Level Layout..
				$layout = file_get_contents(GAMPY_INC."/includes/levels/".$n);
				
				$lines = explode("\r\n", $layout);
				echo "<table>";
				foreach($lines as $line){
					echo "<tr>";
						$tile = str_split($line);
						foreach($tile as $k => $val){
							if($val == ';') continue;	
							//Get the symbols name	
							$sname = $tiles->$val;	
							
							echo "<td>";
							echo "<img src='/images/".strtolower($sname).".png' />";
							//echo $val;
							echo "</td>";
						}
					echo "</tr>";
				}
				echo "<table>";
				
			}
			
		}
	}

?>