<?php
	header("Content-Type: text/html; charset=utf8");
	error_reporting(E_ALL&~E_NOTICE);

	//all information
	if(file_exists('connect.php'))
	{
		include('connect.php');
	}
	else
	{
		die('file not exists');
	}
	
	if(file_exists('function.php'))
	{
		include('function.php');
	}
	else
	{
		die('file not exist');
	}

	//configuration
	$total  = 51;			//需要排班总人数
	$aNum   = 2;			//下午值班的人数上界
	$eNum   = 8;			//晚上值班的人数上界
	$wNum   = 8;			//周末值班的人数上界
	$fLimit = 4;			//每次值班女生人数的上界
	$sortSum = 12;

	// $studentSum = array('aMonday'=>0,'aTuesday'=>0,'aWednesday'=>0,
	// 							  	  'aThursday'=>0,'aFriday'=>0,'eMonday'=>0,
	// 							  	  'eTuesday'=>0,'eWednesday'=>0,'eThursday'=>0,
	// 							  	  'eFriday'=>0,'aSaturday'=>0,'aSunday'=>0,
	// 							  		'eSunday'=>0);
	$studentSum = array();


	// $studentArr = array('aMonday'=>array(),'aTuesday'=>array(),'aWednesday'=>array(),
	// 							  	  'aThursday'=>array(),'aFriday'=>array(),'eMonday'=>array(),
	// 							  	  'eTuesday'=>array(),'eWednesday'=>array(),'eThursday'=>array(),
	// 							  	  'eFriday'=>array(),'aSaturday'=>array(),'aSunday'=>array(),
	// 							  		'eSunday'=>array());

	$studentArr = array();
	//$studentArr_c = array();

	$studentFin = array();
	//$studentFin_c = array();
	//gender array
	// $gender = array('eMonday'=>0,'eTuesday'=>0,'eWednesday'=>0,
	// 							  'eThursday'=>0,'eFriday'=>0,'aSaturday_1'=>0,
	// 							  'aSaturday_2'=>0,'aSunday_1'=>0,'aSunday_2'=>0,
	// 							  'eSunday_1'=>0,'eSunday_2'=>0);
	$gender = array();

	//初始化数组
	for($i = 0;$i <= $sortSum;$i++)
	{
		array_push($studentFin,array());
		array_push($gender,array());
		array_push($studentSum,array());
		array_push($studentArr,array());
		//array_push($studentFin_c,array());
	}

	//将表单的元素转化为后台的数组
	//a 周一下午
	//c 周二下午
	//e 周三下午
	//g 周四下午
	//i 周五下午

	//b 周一晚上
	//d 周二晚上
	//f 周三晚上
	//h 周四晚上
	//j 周五晚上

	//k 周六下午
	//l 周日下午
	//m 周日晚上
	for($i = 0;$i < $total;$i++)
	{
		//weekdays and important
		if($_POST['a'.$i])
		{
			array_push($studentArr[0],$information[$i][0]);
		}
		if($_POST['c'.$i])
		{
			array_push($studentArr[1],$information[$i][0]);	
		}
		if($_POST['e'.$i])
		{
			array_push($studentArr[2],$information[$i][0]);		
		}
		if($_POST['g'.$i])
		{
			array_push($studentArr[3],$information[$i][0]);	
		}
		if($_POST['i'.$i])
		{
			array_push($studentArr[4],$information[$i][0]);	
		}

		//weekdays and unimportant
		if($_POST['b'.$i])
		{
			array_push($studentArr[5],$information[$i][0]);
		}
		if($_POST['d'.$i])
		{
			array_push($studentArr[6],$information[$i][0]);
		}
		if($_POST['f'.$i])
		{
			array_push($studentArr[7],$information[$i][0]);
		}
		if($_POST['h'.$i])
		{
			array_push($studentArr[8],$information[$i][0]);	
		}
		if($_POST['j'.$i])
		{
			array_push($studentArr[9],$information[$i][0]);
		}

		//weekend and unimportant
		if($_POST['k'.$i])
		{
			array_push($studentArr[10],$information[$i][0]);
		}
		if($_POST['l'.$i])
		{
			array_push($studentArr[11],$information[$i][0]);
		}
		if($_POST['m'.$i])
		{
			array_push($studentArr[12],$information[$i][0]);
		}
	}

	//计算每个数组中元素的数目，并储存到$studentSum数组中
	calSum($studentArr,$studentSum);

	//对数组进行排序，但是不改变对应元素的下标
	asort($studentSum);

	//关键代码
	//对周一到周五进行操作
	foreach($studentSum as $k=>$v)
	{
		switch($k) 
		{
			case 0:
			case 1:
			case 2:
			case 3:
			case 4:
				for($i = 0;$i < $aNum;$i++)
				{
					$ele = $studentArr[$k][rand(0,$studentSum[$k] - 1)];
					array_push($studentFin[$k],$ele);
					for($j = 0;$j < 10;$j++)
					{
						del($ele,$studentArr[$j]);
					}
					calSum($studentArr,$studentSum);
				}
				break;
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
				for($i = 0;$i < $eNum;$i++)
				{
					$ele = $studentArr[$k][rand(0,$studentSum[$k] - 1)];
					array_push($studentFin[$k],$ele);
					for($j = 0;$j < 10;$j++)
					{
						del($ele,$studentArr[$j]);
					}
					calSum($studentArr,$studentSum);
				}
				break;
			default:
				break;
		}
	}

	//对周末进行操作
	foreach($studentSum as $k=>$v)
	{
		switch($k) 
		{
			case 10:
			case 11:
			case 12:
				for($i = 0;$i < $wNum * 2;$i++)
				{
					$ele = $studentArr[$k][rand(0,$studentSum[$k] - 1)];
					array_push($studentFin[$k],$ele);
					for($j = 10;$j < 13;$j++)
					{
						del($ele,$studentArr[$j]);
					}
					calSum($studentArr,$studentSum);
				}
				break;
			default:
				break;
		}
	}

	//分别统计周一到周五 和 周末 未被安排班的同学名单
	$a = array();
	$b = array();
	for($i = 0;$i < count($studentArr) - 3;$i++)
	{
		$a = array_merge($a,$studentArr[$i]);
	}

	for($i = count($studentArr) - 3;$i < count($studentArr);$i++)
	{
		$b = array_merge($b,$studentArr[$i]);
	}

	$result1 = array_unique($a);
	$result2 = array_unique($b);
	
	//周一到周五剩余同学
	echo "周一到周五剩余同学";
	var_dump($result1);

	//周末剩余同学
	echo "周末剩余同学";
	var_dump($result2);


//about excel
require_once dirname(__FILE__).'/Classes/PHPExcel.php';

//列号
$numArr = array('A','B','C','D','E','F','G','H','I',
								'J','K','L','M','N','O','P','Q','R',
								'S','T','U','V','W','X','Y','Z','AA',
								'AB','AC','AD','AE','AF','AG','AH','AI',
								'AJ','AK','AL','AM','AN','AO','AP','AQ',
								'AR','AS','AT','AU','AV','AW','AX','AY','AZ'); 
//列名
$arr = array('时间/姓名','2楼大厅','','','','','','','3楼',
						 '平时晚班时间点：17：30；下午班时间点：12：00-17：00（12：00-14：50；15：10-17：00）；',
						 '周六下午：12:00—18:00；周日下午：12：00-17：00；周日晚班：17：30开始',
						 '夏季学期：10：00闭馆','冬季学期：9：30闭馆'); 

if(date("m") == 12)
{
	$year = date("Y") + 1;
}
$title = $year.'年'.date('m',strtotime('+1 month')).'月份值班表';

$a = array(array('e1_0'=>'周一中午',
								 'e1_1'=>$studentFin[0][0],'e1_2'=>$studentFin[0][1],'e1_3'=>null,
								 'e1_4'=>null,'e1_5'=>null,'e1_6'=>null,
								 'e1_7'=>null),
					 array('e1_0'=>'周一晚上',
					 			 'e1_1'=>$studentFin[5][0],'e1_2'=>$studentFin[5][1],'e1_3'=>$studentFin[5][2],
					 			 'e1_4'=>$studentFin[5][3],'e1_5'=>$studentFin[5][4],'e1_6'=>$studentFin[5][5],
					 			 'e1_7'=>$studentFin[5][6],'e1_8'=>$studentFin[5][7]),
					 array('e1_0'=>'周二中午',
					 			 'e1_1'=>$studentFin[1][0],'e1_2'=>$studentFin[1][1],'e1_3'=>null,
					 			 'e1_4'=>null,'e1_5'=>null,'e1_6'=>null,
					 			 'e1_7'=>null,'e1_8'=>null),
					 array('e1_0'=>'周二晚上',
					 			 'e1_1'=>$studentFin[6][0],'e1_2'=>$studentFin[6][1],'e1_3'=>$studentFin[6][2],
					 			 'e1_4'=>$studentFin[6][3],'e1_5'=>$studentFin[6][4],'e1_6'=>$studentFin[6][5],
					 			 'e1_7'=>$studentFin[6][6],'e1_8'=>$studentFin[6][7]),
					 array('e1_0'=>'周三中午',
					 			 'e1_1'=>$studentFin[2][0],'e1_2'=>$studentFin[2][1],'e1_3'=>null,
					 			 'e1_4'=>null,'e1_5'=>null,'e1_6'=>null,
					 			 'e1_7'=>null,'e1_8'=>null),
					 array('e1_0'=>'周三晚上',
					 			 'e1_1'=>$studentFin[7][0],'e1_2'=>$studentFin[7][1],'e1_3'=>$studentFin[7][2],
					 			 'e1_4'=>$studentFin[7][3],'e1_5'=>$studentFin[7][4],'e1_6'=>$studentFin[7][5],
					 			 'e1_7'=>$studentFin[7][6],'e1_8'=>$studentFin[7][7]),
					 array('e1_0'=>'周四中午',
					 			 'e1_1'=>$studentFin[3][0],'e1_2'=>$studentFin[3][1],'e1_3'=>null,
					 			 'e1_4'=>null,'e1_5'=>null,'e1_6'=>null,
					 			 'e1_7'=>null,'e1_8'=>null),
					 array('e1_0'=>'周四晚上',
					 			 'e1_1'=>$studentFin[8][0],'e1_2'=>$studentFin[8][1],'e1_3'=>$studentFin[8][2],
					 			 'e1_4'=>$studentFin[8][3],'e1_5'=>$studentFin[8][4],'e1_6'=>$studentFin[8][5],
					 			 'e1_7'=>$studentFin[8][6],'e1_8'=>$studentFin[8][7]),
					 array('e1_0'=>'周五中午',
					 			 'e1_1'=>$studentFin[4][0],'e1_2'=>$studentFin[4][1],'e1_3'=>null,
					 			 'e1_4'=>null,'e1_5'=>null,'e1_6'=>null,
					 			 'e1_7'=>null,'e1_8'=>null),
					 array('e1_0'=>'周五晚上',
					 			 'e1_1'=>$studentFin[9][0],'e1_2'=>$studentFin[9][1],'e1_3'=>$studentFin[9][2],
					 			 'e1_4'=>$studentFin[9][3],'e1_5'=>$studentFin[9][4],'e1_6'=>$studentFin[9][5],
					 			 'e1_7'=>$studentFin[9][6],'e1_8'=>$studentFin[9][7]),
					);

$year = date("Y");
if(date("m") == 12)
{
	$year = date("Y") + 1;
}
$month = date("m",strtotime('+1 month'));
$days = date("t",strtotime('+1 month'));	//天数

$arr_w = array();	  //存放周末

//把一个月的周末分为两拨
//一个月就是五个周末或者四个周末
//前两周分为一拨，剩下的无论是两周还是三周分为一拨

$flag = 0;
$i = 0;
for($i = 1;($i <= $days) && ($flag < 4);$i++)
{ 
  $day = $year.'-'.$month.'-'.$i;
  $w = date('w',strtotime($day));
	if($w == 6)
	{
	 	array_push($a,array('e1_0'=>'周六下午'.$day,
	 											'e1_1'=>$studentFin[10][0],'e1_2'=>$studentFin[10][1],
	 											'e1_3'=>$studentFin[10][2],'e1_4'=>$studentFin[10][3],'e1_5'=>$studentFin[10][4],
	 											'e1_6'=>$studentFin[10][5],'e1_7'=>$studentFin[10][6],'e1_8'=>$studentFin[10][7]));
		$flag++;
	}
	if($w == 0)
	{
		array_push($a,array('e1_0'=>'周日下午'.$day,
												'e1_1'=>$studentFin[11][0],'e1_2'=>$studentFin[11][1],'e1_3'=>$studentFin[11][2],
												'e1_4'=>$studentFin[11][3],'e1_5'=>$studentFin[11][4],'e1_6'=>$studentFin[11][5],
												'e1_7'=>$studentFin[11][6],'e1_8'=>$studentFin[11][7]));

		array_push($a,array('e1_0'=>'周日晚上'.$day,
												'e1_1'=>$studentFin[12][0],'e1_2'=>$studentFin[12][1],'e1_3'=>$studentFin[12][2],
												'e1_4'=>$studentFin[12][3],'e1_5'=>$studentFin[12][4],'e1_6'=>$studentFin[12][5],
												'e1_7'=>$studentFin[12][6],'e1_8'=>$studentFin[12][7]));
		if($flag != 0)
		{
			$flag++;
		}
	}
}

for($i;$i <= $days;$i++)
{ 
  $day = $year.'-'.$month.'-'.$i;
  $w = date('w',strtotime($day));
	if($w == 6)
	{
	 	array_push($a,array('e1_0'=>'周六下午'.$day,
	 											'e1_1'=>$studentFin[10][8],'e1_2'=>$studentFin[10][9],'e1_3'=>$studentFin[10][10],
	 											'e1_4'=>$studentFin[10][11],'e1_5'=>$studentFin[10][12],'e1_6'=>$studentFin[10][13],
	 											'e1_7'=>$studentFin[10][14],'e1_8'=>$studentFin[10][15]));
	}
	if($w == 0)
	{
		array_push($a,array('e1_0'=>'周日下午'.$day,
												'e1_1'=>$studentFin[11][8],'e1_2'=>$studentFin[11][9],'e1_3'=>$studentFin[11][10],
												'e1_4'=>$studentFin[11][11],'e1_5'=>$studentFin[11][12],'e1_6'=>$studentFin[11][13],
												'e1_7'=>$studentFin[11][14],'e1_8'=>$studentFin[11][15]));

		array_push($a,array('e1_0'=>'周日晚上'.$day,
												'e1_1'=>$studentFin[12][8],'e1_2'=>$studentFin[12][9],'e1_3'=>$studentFin[12][10],
												'e1_4'=>$studentFin[12][11],'e1_5'=>$studentFin[12][12],'e1_6'=>$studentFin[12][13],
												'e1_7'=>$studentFin[12][14],'e1_8'=>$studentFin[12][15]));
	}
}


$objPHPExcel = new PHPExcel();

//加粗居中20号字
$styleArray1 = array(
										'font'=>array(
																 'bold' => true,     
																 'size'=>20,     
																 'color'=>array(       
																 							 'argb'=>'00000000',     
																 							 ),   
																 ),   
										'alignment'=>array(     
																			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,   
																			), 
										); 

//居中加粗14号字
$styleArray2 = array(   
										'font'=>array(
																 'bold' => true,     
																 'size'=>14,     
																 'color'=>array(       
																 							 'argb'=>'00000000',     
																 							 ),   
																 ), 
										'alignment'=>array(     
																			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,   
																			), 
										); 

//居中加粗12号字
$styleArray3 = array(   
										'font'=>array(
																 'bold' => true,     
																 'size'=>12,     
																 'color'=>array(       
																 							 'argb'=>'00000000',     
																 							 ),   
																 ), 
										'alignment'=>array(     
																			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,   
																			), 
										); 

//居中
$styleArray4 = array( 
										'alignment'=>array(     
																			'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,   
																			), 
										); 

//正文

//应用格式
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1); 
$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray2); 
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray2);  
$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($styleArray2); 
$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray2); 
$objPHPExcel->getActiveSheet()->getStyle('A25')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('A26')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('A27')->applyFromArray($styleArray2);
$objPHPExcel->getActiveSheet()->getStyle('E27')->applyFromArray($styleArray2);

for($i = 3;$i <= 24;$i++)
{
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($styleArray3);
}

for($i = 3;$i <= 24;$i++)
{
	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($styleArray4);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($styleArray4);
}

// 输出标题 
echo date('H:i:s')." Add some data"."<br>"; 

$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
$objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
$objPHPExcel->getActiveSheet()->mergeCells('A25:I25');
$objPHPExcel->getActiveSheet()->mergeCells('A26:I26');
$objPHPExcel->getActiveSheet()->mergeCells('A27:D27');
$objPHPExcel->getActiveSheet()->mergeCells('E27:I27');

//行高
$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(26.25);
$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('2')->setRowHeight(24);

//列宽
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(24.67); 
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(11.29);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(11.29); 
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(11.29);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(11.29); 
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(11.29); 
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(11.29); 
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(11.29); 
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(11.29); 

//显示网格线
$objPHPExcel->getActiveSheet()->setShowGridlines(true); 

//输出第一行 
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1',$title);

$objPHPExcel->setActiveSheetIndex(0)    
			->setCellValue('A2', $arr[0])  
			->setCellValue('B2', $arr[1])  
			->setCellValue('C2', $arr[2])
			->setCellValue('D2', $arr[3])
			->setCellValue('E2', $arr[4])  
			->setCellValue('F2', $arr[5])  
			->setCellValue('G2', $arr[6])  
			->setCellValue('H2', $arr[7])
			->setCellValue('I2', $arr[8])
			->setCellValue('A25',$arr[9])
			->setCellValue('A26',$arr[10])
			->setCellValue('A27',$arr[11])
			->setCellValue('E27',$arr[12]);
//输出内容 
for($i = 0;$i < count($a);$i++)
{  
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($numArr[0].($i+3), $a[$i]['e1_0'])  
				->setCellValue($numArr[1].($i+3), $a[$i]['e1_1'])  
				->setCellValue($numArr[2].($i+3), $a[$i]['e1_2'])  
				->setCellValue($numArr[3].($i+3), $a[$i]['e1_3'])   
				->setCellValue($numArr[4].($i+3), $a[$i]['e1_4'])   
				->setCellValue($numArr[5].($i+3), $a[$i]['e1_5'])   
				->setCellValue($numArr[6].($i+3), $a[$i]['e1_6']) 
				->setCellValue($numArr[7].($i+3), $a[$i]['e1_7'])   
				->setCellValue($numArr[8].($i+3), $a[$i]['e1_8']);}   
				
// Rename worksheet 
echo date('H:i:s')." Rename worksheet"."<br>"; 
$dirName = date("Ymd");
//目录名 
$fileName = date("YmdHis");
//文件名 
$objPHPExcel->getActiveSheet()->setTitle($fileName);     
// Set active sheet index to the first sheet, so Excel opens this as the first sheet 
$objPHPExcel->setActiveSheetIndex(0);     
// Save Excel 2007 file 
echo date('H:i:s')." Write to Excel2007 format"."<br>"; 
$callStartTime = microtime(true);

if(!opendir('excel/'.$dirName))
{  
	mkdir('excel/'.$dirName); 
} 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
$begin = getCurrentTime();
$objWriter->save('excel/'.$dirName.'/'.$fileName.'.xlsx');   
$end = getCurrentTime(); 
$spend = $end-$begin; 
if ($spend > 30)
{ 
 	echo '<script>if(confirm("执行超时！")){ window.history.back(-1);}</script>';  
 	exit; 
} 
else
{
	echo "值班表成功生成";
}

if($m_exportType=="excel")
{        
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	// 从浏览器直接输出$filename     
	header("Pragma: public");     
	header("Expires: 0");     
	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");     
	header("Content-Type:application/force-download");     
	header("Content-Type: application/vnd.ms-excel;");     
	header("Content-Type:application/octet-stream");     
	header("Content-Type:application/download");     
	header("Content-Disposition:attachment;filename=".$filename);     
	header("Content-Transfer-Encoding:binary");     
	$objWriter->save("php://output");  } 

?>