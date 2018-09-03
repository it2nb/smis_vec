<?php
class Calsar{
	public $indecator = array (2012 => array(
									"name" => array(
										"ร้อยละของผู้เรียนที่มีผลสัมฤทธิ์ทางการเรียนเฉลี่ยสะสม 2.00 ขึ้นไป",
										"ระดับคุณภาพในการจัดทำแผนการจัดการเรียนรู้รายวิชา",
										"ระดับคุณภาพในการจัดการเรียนการสอนรายวิชา",
										"ระดับคุณภาพในการวัดและประเมินผลการจัดการเรียนการสอนรายวิชา",
										"ระดับคุณภาพในการจัดระบบดูแลผู้เรียน",
										"ระดับคุณภาพในการพัฒนาครูและบุคลากรทางการศึกษา",
										"ระดับคุณภาพในการบริหารจัดการการบริการวิชาการและวิชาชีพ",
										"ระดับคุณภาพในการบริหารจัดการนวัตกรรม สิ่งประดิษฐ์ งานสร้างสรรค์หรืองานวิจัยของครู",
										"ระดับคุณภาพในการปลูกฝังจิตสำนึกด้านการรักชาติ เทิดทูนพระมหากษัตริย์ ส่งเสริมการปกครองระบอบประชาธิปไตยอันมีพระมหากษัตริย์ทรงเป็นประมุข และทะนุบำรุง ศาสนา ศิลปะ วัฒนธรรม",
										"ระดับคุณภาพในการปลูกฝังจิตสำนึกด้านการอนุรักษ์สิ่งแวดล้อม",
										"ระดับคุณภาพในการปลูกฝังจิตสำนึกด้านปรัชญาของเศรษฐกิจพอเพียง"
										),
									"indecator" => array("1.1",
									"2.2",
									"2.3",
									"2.4",
									"3.7",
									"3.10",
									"4.1",
									"5.2",
									"6.1",
									"6.2",
									"6.4"
									)),
								2013 => array(
									"name" => array(
										"ร้อยละของผู้เรียนที่มีผลสัมฤทธิ์ทางการเรียนเฉลี่ยสะสม 2.00 ขึ้นไป",
										"ระดับคุณภาพในการจัดทำแผนการจัดการเรียนรู้รายวิชา",
										"ระดับคุณภาพในการจัดการเรียนการสอนรายวิชา",
										"ระดับคุณภาพในการวัดและประเมินผลการจัดการเรียนการสอนรายวิชา",
										"ระดับคุณภาพในการจัดระบบดูแลผู้เรียน",
										"ระดับคุณภาพในการพัฒนาครูและบุคลากรทางการศึกษา",
										"ระดับคุณภาพในการบริหารจัดการการบริการวิชาการและวิชาชีพ",
										"ระดับคุณภาพในการบริหารจัดการนวัตกรรม สิ่งประดิษฐ์ งานสร้างสรรค์หรืองานวิจัยของครู",
										"ระดับคุณภาพในการปลูกฝังจิตสำนึกด้านการรักชาติ เทิดทูนพระมหากษัตริย์ ส่งเสริมการปกครองระบอบประชาธิปไตยอันมีพระมหากษัตริย์ทรงเป็นประมุข และทะนุบำรุง ศาสนา ศิลปะ วัฒนธรรม",
										"ระดับคุณภาพในการปลูกฝังจิตสำนึกด้านการอนุรักษ์สิ่งแวดล้อม",
										"ระดับคุณภาพในการปลูกฝังจิตสำนึกด้านปรัชญาของเศรษฐกิจพอเพียง"
										),
									"indecator" => array("1.1",
									"2.2",
									"2.3",
									"2.4",
									"3.7",
									"3.10",
									"4.1",
									"5.2",
									"6.1",
									"6.2",
									"6.4"
									)));			
	public function getindectorname($indc,$year){
		$result="";
		for($i=0;$i<count($this->indecator[$year]["name"]);$i++){
			if($this->indecator[$year]["indecator"][$i]==$indc){
				$result=$this->indecator[$year]["name"][$i];
				break;
			}
		}
		return $result;
	}
	public function indecators($indc,$personnel_ID,$year,$conn){
		if($indc==1.1){
			$result = $this->indecator1_1($personnel_ID,$year,$conn);
		}else if($indc==2.2){
			$result = $this->indecator2_2($personnel_ID,$year,$conn);
		}else if($indc==2.3){
			$result = $this->indecator2_3($personnel_ID,$year,$conn);
		}else if($indc==2.4){
			$result = $this->indecator2_4($personnel_ID,$year,$conn);
		}else if($indc==3.7){
			$result = $this->indecator3_7($personnel_ID,$year,$conn);
		}else if($indc==3.10){
			//$result = $this->indecator3_10($personnel_ID,$year,$conn);
		}else if($indc==4.1){
			//$result = $this->indecator4_1($personnel_ID,$year,$conn);
		}else if($indc==5.2){
			//$result = $this->indecator5_2($personnel_ID,$year,$conn);
		}else if($indc==6.1){
			//$result = $this->indecator6_1($personnel_ID,$year,$conn);
		}else if($indc==6.2){
			//$result = $this->indecator6_2($personnel_ID,$year,$conn);
		}else if($indc==6.4){
			//$result = $this->indecator6_4($personnel_ID,$year,$conn);
		}else{
			$result = 0;
		}
		return $result;
	}
	public function indecators_all($indc,$year,$conn){
		if($indc==1.1){
			$result = $this->indecator1_1_all($year,$conn);
		}else if($indc==2.2){
			$result = $this->indecator2_2_all($year,$conn);
		}else if($indc==2.3){
			$result = $this->indecator2_3_all($year,$conn);
		}else if($indc==2.4){
			$result = $this->indecator2_4_all($year,$conn);
		}else if($indc==3.7){
			$result = $this->indecator3_7_all($year,$conn);
		}else if($indc==3.10){
			//$result = $this->indecator3_10_all($year,$conn);
		}else if($indc==4.1){
			//$result = $this->indecator4_1_all($year,$conn);
		}else if($indc==5.2){
			//$result = $this->indecator5_2_all($year,$conn);
		}else if($indc==6.1){
			//$result = $this->indecator6_1_all($year,$conn);
		}else if($indc==6.2){
			//$result = $this->indecator6_2_all($year,$conn);
		}else if($indc==6.4){
			//$result = $this->indecator6_4_all($year,$conn);
		}else{
			$result = 0;
		}
		return $result;
	}
	public function indecator1_1($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$query = "Select count(result.result_grade) as numpassgrade  From teach,result Where teach.teach_ID=result.teach_ID and result.result_grade>=2 and teach.teach_year='$year' and teach.personnel_ID='$personnel_ID'";
			$teachresult_query=mysql_query($query,$conn)or die(mysql_error());
			$teachresult_fetch=mysql_fetch_array($teachresult_query);
			$query="Select count(student_ID) as numstudent From teach,class,student Where teach.class_ID=class.class_ID and class.class_ID=student.class_ID and teach.teach_year='$year' and teach.personnel_ID='$personnel_ID'";
			$studentnum_query=mysql_query($query,$conn)or die(mysql_error());
			$studentnum_fetch=mysql_fetch_array($studentnum_query);
			if($studentnum_fetch["numstudent"]>0)
				$result[0] = round(($teachresult_fetch["numpassgrade"]/$studentnum_fetch["numstudent"])*100,2);
			else
				$result[0] = 0;
			
			if($result[0]>=80){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=70){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=60){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=50){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ร้อยละ";
		return $result;
	}
	public function indecator1_1_all($year,$conn){
		if($year==2012||$year==2013){
			$query = "Select count(result.result_grade) as numpassgrade  From teach,result Where teach.teach_ID=result.teach_ID and result.result_grade>=2 and teach.teach_year='$year'";
			$teachresult_query=mysql_query($query,$conn)or die(mysql_error());
			$teachresult_fetch=mysql_fetch_array($teachresult_query);
			$query="Select count(student_ID) as numstudent From teach,class,student Where teach.class_ID=class.class_ID and class.class_ID=student.class_ID and teach.teach_year='$year'";
			$studentnum_query=mysql_query($query,$conn)or die(mysql_error());
			$studentnum_fetch=mysql_fetch_array($studentnum_query);
			if($studentnum_fetch["numstudent"]>0)
				$result[0] = round(($teachresult_fetch["numpassgrade"]/$studentnum_fetch["numstudent"])*100,2);
			else
				$result[0] = 0;
			
			if($result[0]>=80){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=70){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=60){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=50){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ร้อยละ";
		return $result;
	}
	public function indecator2_2($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$query="Select count(teach_ID) as numplanstd From teach Where teach_year='$year' and teach_jobstd=1 and teach_eco=1 and teach_moral=1 and personnel_ID='$personnel_ID'";
			$planstd_query=mysql_query($query,$conn)or die(mysql_error());
			$planstd_fetch=mysql_fetch_array($planstd_query);
			$query="Select count(teach_ID) as numplan From teach Where teach_year='$year' and personnel_ID='$personnel_ID'";
			$plan_query=mysql_query($query,$conn)or die(mysql_error());
			$plan_fetch=mysql_fetch_array($plan_query);
			$result[1]=$plan_fetch["numplan"];
			if($plan_fetch["numplan"]>0)
				$result[0]=round(($planstd_fetch["numplanstd"]/$plan_fetch["numplan"])*100,2);
			else
				$result[0]=0;
			
			if($result[0]==100){
				$result[2]="ดีมาก";
			}else{
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ร้อยละ";
		return $result;
	}
	public function indecator2_2_all($year,$conn){
		if($year==2012||$year==2013){
			$query="Select DISTINCT personnel_ID From teach Where teach_year='$year'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$planpass=0;
			$planall=0;
			while($personnel_fetch=mysql_fetch_array($personnel_query)){
				$planscore = $this->indecator2_2($personnel_fetch["personnel_ID"],$year,$conn);
				if($planscore[0]==100)
					$planpass++;
				$planall++;
			}
			if($planall>0)
				$result[0]=round(($planpass/$planall)*100,2);
			else
				$result[0]=0;
			
			if($result[0]>=80){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=70){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=60){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=50){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ร้อยละ";
		return $result;
	}
	public function indecator2_3($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$planscore = $this->indecator2_2($personnel_ID,$year,$conn);
			if($planscore[0]>=80)
				$result[0]++;
			$query="Select * From teach Where teach_year='$year' and personnel_ID='$personnel_ID'";
			$teach_query=mysql_query($query,$conn)or die(mysql_error());
			$technum=0;
			$teachinstruc=0;
			$teachactivity=0;
			while($teach_fetch=mysql_fetch_array($teach_query)){
				if($teach_fetch["teach_activity"]==1)
					$teachactivity++;
				if($teach_fetch["teach_instruc"]==1)
					$teachinstruc++;
				$technum++;
			}
			if($technum>0){
				if((($teachactivity/$technum)*100)>=80)
					$result[0]++;
				if((($teachinstruc/$technum)*100)>=80)
					$result[0]++;
			}
			$query="Select * From teach,research Where teach.teach_ID=research.teach_ID and teach_year='$year' and teach.personnel_ID='$personnel_ID'";
			$research_query=mysql_query($query,$conn)or die(mysql_error());
			if(mysql_num_rows($research_query)>0)
				$result[0]+=2;
			
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator2_3_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$planscore = $this->indecator2_2_all($year,$conn);
			if($planscore[0]>=80)
				$result[0]++;
			$query="Select * From teach Where teach_year='$year'";
			$teach_query=mysql_query($query,$conn)or die(mysql_error());
			$technum=0;
			$teachinstruc=0;
			$teachactivity=0;
			while($teach_fetch=mysql_fetch_array($teach_query)){
				if($teach_fetch["teach_activity"]==1)
					$teachactivity++;
				if($teach_fetch["teach_instruc"]==1)
					$teachinstruc++;
				$technum++;
			}
			if(($teachactivity/$technum)*100>=80)
				$result[0]++;
			if(($teachinstruc/$technum)*100>=80)
				$result[0]++;
			$query="Select * From teach,research Where teach.teach_ID=research.teach_ID and teach_year='$year'";
			$research_query=mysql_query($query,$conn)or die(mysql_error());
			if(mysql_num_rows($research_query)>0)
				$result[0]+=2;
			
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator2_4($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select * From teach,subject,class Where teach.subject_ID=subject.subject_ID and teach.class_ID=class.class_ID and teach.teach_year='$year' and teach.personnel_ID='$personnel_ID'";
			$teach_query=mysql_query($query,$conn)or die(mysql_error());
			$technum=0;
			$teachmeasure = array(0,0,0);
			while($teach_fetch=mysql_fetch_array($teach_query)){
				if($teach_fetch["teach_measure"]==1)
					$teachmeasure[0]++;
				if($teach_fetch["teach_measure"]==1&& !empty($teach_fetch["teach_plan"]))
					$teachmeasure[1]++;
				if($teach_fetch["teach_measure"]==1 && !empty($teach_fetch["teach_plan"]) && $teach_fetch["teach_jobstd"]==1)
					$teachmeasure[2]++;
				$technum++;
			}
			if($technum>0){
				if((($teachmeasure[0]/$technum)*100)==100)
					$result[0]+=2;
				if((($teachmeasure[1]/$technum)*100)==100)
					$result[0]+=2;
				if((($teachmeasure[2]/$technum)*100)==100)
					$result[0]++;
			}
			
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator2_4_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$planscore = $this->indecator2_2_all($year,$conn);
			$query="Select * From teach,subject,class Where teach.subject_ID=subject.subject_ID and teach.class_ID=class.class_ID and teach.teach_year='$year'";
			$teach_query=mysql_query($query,$conn)or die(mysql_error());
			$technum=0;
			$teachmeasure = array(0,0,0);
			while($teach_fetch=mysql_fetch_array($teach_query)){
				if($teach_fetch["teach_measure"]==1)
					$teachmeasure[0]++;
				if($teach_fetch["teach_measure"]==1&& !empty($teach_fetch["teach_plan"]))
					$teachmeasure[1]++;
				if($teach_fetch["teach_measure"]==1 && !empty($teach_fetch["teach_plan"]) && $teach_fetch["teach_jobstd"]==1)
					$teachmeasure[2]++;
				$technum++;
			}
			if($technum>0){
				if((($teachmeasure[0]/$technum)*100)==100)
					$result[0]+=2;
				if((($teachmeasure[1]/$technum)*100)==100)
					$result[0]+=2;
				if((($teachmeasure[2]/$technum)*100)==100)
					$result[0]++;
			}
			
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator3_7($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=4;
			$query="Select * From consultation Where consultation_term='1' and consultation_year='$year' and personnel_ID='$personnel_ID'";
			$consultation_query=mysql_query($query,$conn)or die(mysql_error());
			$term1=mysql_num_rows($consultation_query);
			$query="Select * From consultation Where consultation_term='2' and consultation_year='$year' and personnel_ID='$personnel_ID'";
			$consultation_query=mysql_query($query,$conn)or die(mysql_error());
			$term2=mysql_num_rows($consultation_query);
			if($term1>=18 && $term2>=18)
				$result[0]++;
			
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator3_7_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=4;
			$consultnum=0;
			$consultationnum=0;
			$styear=$year-3;
			$query = "Select * From class,area,major Where class.major_ID=major.major_ID and area.area_ID=major.area_ID and class.year>'$styear' and area.area_level='ปวช'";
			//$query="Select * From consult Where consult_year='$year'";
			$consult_query=mysql_query($query,$conn)or die(mysql_error());
			while($consult_fetch=mysql_fetch_array($consult_query)){
				$personnel_ID=$consult_fetch["personnel_ID"];
				$query="Select * From consultation Where consultation_term='1' and consultation_year='$year' and personnel_ID='$personnel_ID'";
				$consultation_query=mysql_query($query,$conn)or die(mysql_error());
				$term1=mysql_num_rows($consultation_query);
				$query="Select * From consultation Where consultation_term='2' and consultation_year='$year' and personnel_ID='$personnel_ID'";
				$consultation_query=mysql_query($query,$conn)or die(mysql_error());
				$term2=mysql_num_rows($consultation_query);
			if($term1>=18 && $term2>=18)
				$consultationnum++;
			$consultnum++;
			}
			if($consultationnum==$consultnum)
				$result[0]++;
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator3_10($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select * From selfdevelop Where  selfdevelop_year='$year' and personnel_ID='$personnel_ID'";
			$selfdevelop_query=mysql_query($query,$conn) or die(mysql_error());
			if(mysql_num_rows($selfdevelop_query)>0)
				$result[0]++;
			$query="Select * From fund Where  fund_year='$year' and personnel_ID='$personnel_ID'";
			$fund_query=mysql_query($query,$conn) or die(mysql_error());
			if(mysql_num_rows($fund_query)>0)
				$result[0]++;
			$query="Select * From exchange Where  exchange_year='$year' and personnel_ID='$personnel_ID'";
			$exchange_query=mysql_query($query,$conn) or die(mysql_error());
			if(mysql_num_rows($exchange_query)>0)
				$result[0]++;
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and (activities.activities_body='1' or activities.activities_mood='1' or activities.activities_social='1' or activities.activities_spirit='1')";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			if(mysql_num_rows($activity_query)>0)
				$result[0]++;
			$query="Select * From coined Where  coined_year='$year' and personnel_ID='$personnel_ID'";
			$coined_query=mysql_query($query,$conn) or die(mysql_error());
			if(mysql_num_rows($coined_query)>0)
				$result[0]++;
				
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator3_10_all($year,$conn){
		if($year==2012||$year==2013){
			$query="Select personnel.personnel_ID From personnel,department Where personnel.department_ID=department.department_ID  and personnel_status='work'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$all=0;
			$issue=array(0,0,0,0,0);
			while($personnel_fetch=mysql_fetch_array($personnel_query)){
				$personnel_ID=$personnel_fetch["personnel_ID"];
				$query="Select * From selfdevelop Where  selfdevelop_year='$year' and personnel_ID='$personnel_ID'";
				$selfdevelop_query=mysql_query($query,$conn) or die(mysql_error());
				if(mysql_num_rows($selfdevelop_query)>0)
					$issue[0]++;
				$query="Select * From fund Where  fund_year='$year' and personnel_ID='$personnel_ID'";
				$fund_query=mysql_query($query,$conn) or die(mysql_error());
				if(mysql_num_rows($fund_query)>0)
					$issue[1]++;
				$query="Select * From exchange Where  exchange_year='$year' and personnel_ID='$personnel_ID'";
				$exchange_query=mysql_query($query,$conn) or die(mysql_error());
				if(mysql_num_rows($exchange_query)>0)
					$issue[2]++;
				$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and (activities.activities_body='1' or activities.activities_mood='1' or activities.activities_social='1' or activities.activities_spirit='1')";
				$activity_query=mysql_query($query,$conn) or die(mysql_error());
				if(mysql_num_rows($activity_query)>0)
					$issue[3]++;
				$query="Select * From coined Where  coined_year='$year' and personnel_ID='$personnel_ID'";
				$coined_query=mysql_query($query,$conn) or die(mysql_error());
				if(mysql_num_rows($coined_query)>0)
					$issue[4]++;
				$all++;
			}
			$result[0]=0;
			if($issue[0]/$all*100>=75)
				$result[0]++;
			if($issue[1]/$all*100>=8)
				$result[0]++;
			if($issue[2]/$all*100>=5)
				$result[0]++;
			if($issue[3]/$all*100>=75)
				$result[0]++;
			if($issue[4]/$all*100>=5)
				$result[0]++;
				
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		$result[3]="ปฏิบัติได้";
		return $result;
	}
	public function indecator4_1($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$query="Select avg(vecservice_satisfaction) as sat_avg From vecservice Where  vecservice_year='$year' and personnel_ID='$personnel_ID'";
			$vecservice_query=mysql_query($query,$conn) or die(mysql_error());
			$vecservice_fetch=mysql_fetch_array($vecservice_query);
			$result[0]=round($vecservice_fetch["sat_avg"],2);
			if($result[0]>=4.5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=3.5){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=2.5){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=1.5){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="ค่าเฉลี่ย";
		}
		return $result;
	}
	public function indecator4_1_all($year,$conn){
		if($year==2012||$year==2013){
			$query="Select personnel.personnel_ID,personnel.personnel_name,personnel.personnel_ser,department.department_name From personnel,department Where personnel.department_ID=department.department_ID and personnel_status='work'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$personnel_num=mysql_num_rows($personnel_query);
			$query="Select sum(vecservice_satisfaction) as sat_sum From vecservice Where  vecservice_year='$year'";
			$vecservice_query=mysql_query($query,$conn) or die(mysql_error());
			$vecservice_fetch=mysql_fetch_array($vecservice_query);
			$result[0]=round($vecservice_fetch["sat_sum"]/$personnel_num,2);
			if($result[0]>=4.5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=3.5){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=2.5){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=1.5){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="ค่าเฉลี่ย";
		}
		return $result;
	}
	public function indecator5_2($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select * From research Where research_year='$year' and personnel_ID='$personnel_ID'";
			$research_query=mysql_query($query,$conn)or die(mysql_error());
			$all=mysql_num_rows($research_query);
			$issue=array(0,0,0,0);
			while($research_fetch=mysql_fetch_array($research_query)){
				if($research_fetch["research_show"]==1)
					$issue[0]++;
				if($research_fetch["research_use"]==1)
					$issue[1]++;
				if($research_fetch["research_publicity"]==1)
					$issue[2]++;
				if(strlen($research_fetch["research_award"])>3)
					$issue[3]++;
			}
			if($all>0){
				$result[0]++;
				if($issue[0]>0)
					$result[0]++;
				if(($issue[1]/$all*100)>=75)
					$result[0]++;
				if(($issue[2]/$all*100)>=50)
					$result[0]++;
				if(($issue[3]/$all*100)>=5)
					$result[0]++;
			}
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="ปฏิบัติได้";
		}
		return $result;
	}
	public function indecator5_2_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select personnel.personnel_ID,personnel.personnel_name,personnel.personnel_ser,department.department_name From personnel,department Where personnel.department_ID=department.department_ID and personnel_status='work'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$personnel_num=mysql_num_rows($personnel_query);
			$query="Select * From research Where research_year='$year'";
			$research_query=mysql_query($query,$conn)or die(mysql_error());
			$all=mysql_num_rows($research_query);
			$issue=array(0,0,0,0);
			while($research_fetch=mysql_fetch_array($research_query)){
				if($research_fetch["research_show"]==1)
					$issue[0]++;
				if($research_fetch["research_use"]==1)
					$issue[1]++;
				if($research_fetch["research_publicity"]==1)
					$issue[2]++;
				if(strlen($research_fetch["research_award"])>3)
					$issue[3]++;
			}
			if($all>0){
				if($personnel_num==$all)
					$result[0]++;
				if($issue[0]>0)
					$result[0]++;
				if(($issue[1]/$all*100)>=75)
					$result[0]++;
				if(($issue[2]/$all*100)>=50)
					$result[0]++;
				if(($issue[3]/$all*100)>=5)
					$result[0]++;
			}
			if($result[0]==5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="ปฏิบัติได้";
		}
		return $result;
	}
	public function indecator6_1($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and (activities.activities_mind='1' or activities.activities_democracy='1' or activities.activities_culture='1')";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			$result[0]=mysql_num_rows($activity_query);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="จำนวนโครงการ";
		}
		return $result;
	}
	public function indecator6_1_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select personnel.personnel_ID,personnel.personnel_name,personnel.personnel_ser,department.department_name From personnel,department Where personnel.department_ID=department.department_ID and personnel_status='work'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$personnel_num=mysql_num_rows($personnel_query);
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year'  and (activities.activities_mind='1' or activities.activities_democracy='1' or activities.activities_culture='1')";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			$result[0]=round(mysql_num_rows($activity_query)/$personnel_num,2);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="จำนวนโครงการ";
		}
		return $result;
	}
	public function indecator6_2($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and activities.activities_environment='1'";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			$result[0]=mysql_num_rows($activity_query);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="จำนวนโครงการ";
		}
		return $result;
	}
	public function indecator6_2_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select personnel.personnel_ID,personnel.personnel_name,personnel.personnel_ser,department.department_name From personnel,department Where personnel.department_ID=department.department_ID and personnel_status='work'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$personnel_num=mysql_num_rows($personnel_query);
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and activities.activities_environment='1'";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			$result[0]=round(mysql_num_rows($activity_query)/$personnel_num,2);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="จำนวนโครงการ";
		}
		return $result;
	}
	public function indecator6_4($personnel_ID,$year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and activities.activities_eco='1'";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			$result[0]=mysql_num_rows($activity_query);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="จำนวนโครงการ";
		}
		return $result;
	}
	public function indecator6_4_all($year,$conn){
		if($year==2012||$year==2013){
			$result[0]=0;
			$query="Select personnel.personnel_ID,personnel.personnel_name,personnel.personnel_ser,department.department_name From personnel,department Where personnel.department_ID=department.department_ID and personnel_status='work'";
			$personnel_query=mysql_query($query,$conn)or die(mysql_error());
			$personnel_num=mysql_num_rows($personnel_query);
			$query="Select * From activities,actnews Where activities.actnews_ID=actnews.actnews_ID and activities.activities_year='$year' and activities.personnel_ID='$personnel_ID' and activities.activities_eco='1'";
			$activity_query=mysql_query($query,$conn) or die(mysql_error());
			$result[0]=round(mysql_num_rows($activity_query)/$personnel_num,2);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]==4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]==3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]==2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
			$result[3]="จำนวนโครงการ";
		}
		return $result;
	}
	public function sumindecators_p($personnel_ID,$year,$conn){
		$score = 0;
		$sumscore = 0;
		if($year==2012||$year==2013){
			for($i=0;$i<count($this->indecator[$year]["name"]);$i++){
				$score=$this->indecators($this->indecator[$year]["indecator"][$i],$personnel_ID,$year,$conn);
				$sumscore+=$score[1];
			}
			$result[0] = round($sumscore/count($this->indecator[$year]["name"]),2);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		return $result;
	}	
	public function sumindecators_all($year,$conn){
		$score = 0;
		$sumscore = 0;
		if($year==2012||$year==2013){
			for($i=0;$i<count($this->indecator[$year]["name"]);$i++){
				$score=$this->indecators_all($this->indecator[$year]["indecator"][$i],$year,$conn);
				$sumscore+=$score[1];
			}
			$result[0] = round($sumscore/count($this->indecator[$year]["name"]),2);
			if($result[0]>=5){
				$result[1]=5;
				$result[2]="ดีมาก";
			}else if($result[0]>=4){
				$result[1]=4;
				$result[2]="ดี";
			}else if($result[0]>=3){
				$result[1]=3;
				$result[2]="พอใช้";
			}else if($result[0]>=2){
				$result[1]=2;
				$result[2]="ต้องปรับปรุง";
			}else{
				$result[1]=1;
				$result[2]="ต้องปรับปรุงเร่งด่วน";
			}
		}
		return $result;
	}
}
?>