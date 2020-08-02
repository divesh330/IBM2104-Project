<?php
	require_once("Database.php");
	require_once('tcpdf.php');
	
	class Report extends TCPDF{
		
		/* variable */
		protected $listOfTitle = array();
		protected $listOfTable = array();
		
		private $content_area = null;
		
		public function __construct(){
			parent::__construct('L', 'pt', 'A4', true, 'UTF-8', false);
			
			// set document information
			$this->SetCreator('Created by TCPDF(Nicolai Asuni)');
			$this->SetAuthor('12Make');
			$this->SetTitle('Kheng Sheng Letric Report');
			$this->SetSubject('Report');
			$this->SetKeywords('pdf, Kheng Sheng Letric, 12Make, TCPDF');
			
			// set default header data
			$this->SetHeaderData('khengsenglogo.gif', 30, 'Kheng Sheng Letric Malaysia', 'Tel : 0174066133');
			
			// set header and footer fonts
			$this->setHeaderFont(Array('times', '', 12));
			$this->setFooterFont(Array('times', '', 12));
				
			// set default monospaced font
			$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$this->SetMargins(10, 50, 10);
			$this->SetHeaderMargin(10);
			$this->SetFooterMargin(22);

			// set auto page breaks
			$this->SetAutoPageBreak(TRUE, 24);

			// set image scale factor
			$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
			
			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$this->setLanguageArray($l);
			}
			
			$this->addNewPage();
			
			$this->content_area = 2*($this->getPageHeight() - $this->GetY() - $this->bMargin);
		}
		
		public function printTitle($title){
			// set font
			$this->SetFont('times', '', 20);
			$this->SetFillColor(200, 220, 255);
			// write the title
			//echo $this->GetY().'<br>';
			$this->Cell(0, 19, $title, 0, 1, 'C', 1, '', 0, true);
			// spaceing between title and table
			$this->Ln(4);
			//echo $this->GetY().'<br>';
		}
		
		public function printBody($body){
			// set font
			$this->SetFont('times', '', 12);			
			// ------ TEXT MODE ------
			//$this->write($body, true, false, true, false, 'J');
			
			$table = '<style>
						table, td, th {
							border: 1pt solid black;
						}
					</style>
					<table>
						<tr>
							<th colspan = "2">ID</th>
							<th>Colour</th>
							<th>Remaining</th>
							<th>Reserve</th>
							<th>Job Count</th>
							<th>Status</th>
						</tr>';
			
			foreach($body as $key => $row){
					$table = $table ."<tr>";
					$table = $table .'<th colspan = "2">' . $row["drum_id"] . " </th>";
					$table = $table ."<td>" . $row["drum_colour"] . "</td>";
					$table = $table ."<td>" . $row["total_left"] . " </td>";
					$table = $table ."<td>0</td>";
					$table = $table ."<td>" . $row["total_job"] . " </td>";
					$table = $table ."<td>" . $row["drum_status"] . " </td>";
					$table = $table ."</tr>";
			}
			$table = $table . "</table>";
			//echo $table;
			//$this->write($table, true, false, true, false, 'J');
			$this->writeHTML($table, true, false, true, false, 'J');
		}

		
		public function addNewPage(){
			$this->AddPage();	
			$this->resetColumns();
			$this->setEqualColumns(2, ($this->getPageWidth() - $this->lMargin-$this->rMargin)/2-2);
			$this->selectColumn();
		}
		
		public function getTotalSpace(){
			
			$remaining = null;
			
			switch($this->getColumn()){
				case 0:
					$remaining = $this->content_area - $this->GetY() + 50;
				break;
				
				case 1:
					$remaining = $this->getPageHeight() - $this->GetY() - $this->bMargin;
				break;
			}
			
			return $remaining;
		}
		
		public function getRemainingSpace(){
			return $this->getPageHeight() - $this->GetY() - $this->bMargin;
		}
		
		protected function printPDF(){
			foreach($this->listOfTable as $key => $value){
				if($value != []){
					$this->printContent($this->listOfTitle[$key], $value);
				}
			}
		}
		
		public function printContent($title="", $body){
			//echo count($body).'<br>';
			$length = count($body) * 15;
			
			$column_number = $this->getColumn();
			
			switch(true){
				case ($length >= $this->content_area):
					
					if($this->content_area == $this->getTotalSpace()){
						$remain = $this->getPageHeight() - $this->GetY() - $this->bMargin;
														
						if($title != null){
							$remain -= 20;
						}
														
						$row = floor($remain / 15) - 1;
						
						$this->printContent($title, array_splice($body, 0, $row));
						
						$remain += 20;
						
						$row = floor($remain / 15) - 1;
						
						$count = ceil(count($body) /$row);
						
						for($x = 0; $x < $count; $x++){
							$this->printContent(null, array_splice($body, 0, $row));
						}
						
					}else{
						$this->addNewPage();
						$this->printContent($title, $body);
					}
				break;
				
				case ($length < $this->content_area):
				
					if($title != null){
						$length += 20;
					}
				
					switch(true){
						case ($length > $this->getTotalSpace()):
							$this->addNewPage();
							$this->printContent($title, $body);
						break;
						
						case ($length <= $this->getTotalSpace()):							
							if($this->getTotalSpace() - ($this->content_area / 2) <= 50){		
								$this->selectColumn(1);
								
								$remain = $this->getPageHeight() - $this->GetY() - $this->bMargin;
								
								if($title != null){
									$remain -= 20;
								}
									
								$row = floor($remain / 15) - 1;
								
								if(count($body) > $row){
									$this->addNewPage();
									$this->printContent($title, $body);
								}else{
									if($title != null){
										$this->printTitle($title);
									}									

									$this->printBody($body);
								}	
								
							}else{
								$this->selectColumn(0);		

								$remain = $this->getPageHeight() - $this->GetY() - $this->bMargin;
								
								if($title != null){
									$remain -= 20;
								}
									
								$row = floor($remain / 15) - 1;

								if($title != null){
									$this->printTitle($title);
								}									

								$this->printBody(array_splice($body, 0, $row));
										
								if(count($body) > 0){
									$this->selectColumn(1);
									$this->printContent(null, $body);
								}
							}													
						break;						
					}
				break;
			}
		}
		
	}
	
	class ReportAll extends Report{			
		private function query($sql, $param=""){
			if($ret = mysqli_query(Database::getConnection(), $sql)){				
				$recordset = array();
			
				while($row = mysqli_fetch_assoc($ret)){
					$recordset[] = $row[$param];
				}

				return $recordset;
				
			}else{				
				die(mysqli_error($ret));				
			}
		}
		
		private function quer($sql){
			if($ret = mysqli_query(Database::getConnection(), $sql)){				
				$recordset = array();
			
				while($row = mysqli_fetch_assoc($ret)){
					$recordset[] = $row;
				}

				return $recordset;
				
			}else{				
				die(mysqli_error($ret));				
			}
		}
		
		public function start(){
				
				$listOfDiameter = $this->query(
				"SELECT distinct(drum_diameter) as drum_diameter FROM drum ORDER BY 
                 FIELD(drum_diameter,
					'0.25' ,'0.5' ,'0.63' ,'0.75' ,'1' ,'1.3' ,'1.5','2.5','4','6', 
					'10','16','25','35' ,'50','70' ,'95' ,'120' ,'150'   ,'185'  ,'240',
					'300', '400' ,'500'  ,'630'  ,'1x2x0.64mm' ,'16+25' ,
					'16x3C+25','35x3C+25' ,'50x3C+35' ,'70x3C+50' ,'95x3C+70+1',
					'120x3C+50','185x3C+120+16' ,'185x3C+50' ) Asc ;", "drum_diameter");
			
			$listOfCore = $this->query(
				"SELECT distinct(drum_core) as drum_core FROM drum ORDER BY 
                 FIELD(drum_core,
					'1C', '2C', '3C','4C', '5C','6C','7C', '8C', '9C',
                    '10C', '12C', '18C','19C','20C',
                    '21C','25C', '27C', '34C','37C', '48C',
                    '1Pair','2Pair','3Pair','4Pair','5Pair','6Pair',
                    '10Pair','20Pair','30Pair','50Pair','100Pair','200Pair',
					'1Triad','16+25','16x3C+25','95x3C+70+1','-','') Asc;", "drum_core");
		
			$listOfDrumtype = $this->query(
					"SELECT distinct(drum_type) as drum_type FROM drum ;", "drum_type");
			
			foreach ($listOfDrumtype as $DrumTypeValue) {
				foreach ($listOfDiameter as $diameterValue) {
					foreach ($listOfCore as $coreValue) {

					$this->listOfTitle[] = $DrumTypeValue." | ".$diameterValue." | ".$coreValue;
					$this->listOfTable[] = $this->quer("SELECT drum.drum_entry_id,
							drum.drum_id,
							drum.drum_colour,
							(CASE
								WHEN SUM(job.job_length) IS NULL THEN drum.drum_length
								ELSE (drum.drum_length - SUM(job.job_length))
							END) AS total_left,
							COUNT(job.job_entry_id) AS total_job,
							drum.drum_special,
							drum.drum_status,
							drum.drum_registered_at,
							drum.drum_updated_at
						  FROM
							drum
								LEFT JOIN
							job ON drum.drum_type = job.cable_type
								AND drum.drum_diameter = job.cable_diameter
								AND drum.drum_id = job.drum_id
							WHERE drum_type = '".$DrumTypeValue."' 
							AND drum_core='".$coreValue."' 
							AND drum_diameter='".$diameterValue."' 
							GROUP BY drum_id ORDER BY FIELD(drum.drum_colour,'','Black', 'Green', 'Red','Yellow','Blue','Y/G'),drum.drum_entry_id desc;");
					}
				}
			}
			
			$this->printPDF();
		}
	}
	
	$pdf = new ReportAll();
	
	$pdf->start();
	//

	//Close and output PDF document
	$pdf->Output('example_010.pdf', 'I');

?>