<?php session_start();
require "../includes/dbconnect.inc.php";
require "header.php";?>
<main>
	<div class="container-fluid">
		<div class="card" style="padding:30px;width:100%;overflow:scroll;">
			<?php
			for($i=1;$i<=5;$i++){
				$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=1");
				$row1=mysqli_fetch_assoc($sql1);
				$res = $row1['resQ'];
				$ques1[]=$res;
			}
			$respondents=array_sum($ques1);
			$question1=implode(",",$ques1);
			$max1 = max($ques1);
			$score1 = array_search($max1, $ques1,true)+1;

			for($i=1;$i<=5;$i++){
				$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=2");
				$row1=mysqli_fetch_assoc($sql1);
				$res = $row1['resQ'];
				$ques2[]=$res;
			}
			$question2=implode(",",$ques2);
			$max2 = max($ques2);
			$score2 = array_search($max2, $ques2,true)+1;

			for($i=1;$i<=5;$i++){
				$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=3");
				$row1=mysqli_fetch_assoc($sql1);
				$res = $row1['resQ'];
				$ques3[]=$res;
			}
			$question3=implode(",",$ques3);
			$max3 = max($ques3);
			$score3 = array_search($max3, $ques3,true)+1;

			for($i=1;$i<=5;$i++){
				$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=4");
				$row1=mysqli_fetch_assoc($sql1);
				$res = $row1['resQ'];
				$ques4[]=$res;
			}
			$question4=implode(",",$ques4);
			$max4 = max($ques4);
			$score4 = array_search($max4, $ques4,true)+1;

			for($i=1;$i<=5;$i++){
				$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=5");
				$row1=mysqli_fetch_assoc($sql1);
				$res = $row1['resQ'];
				$ques5[]=$res;
			}
			$question5=implode(",",$ques5);
			$max5 = max($ques5);
			$score5 = array_search($max5, $ques5,true)+1; ?>

			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">
				google.charts.load('current', {'packages':['bar']});
				google.charts.setOnLoadCallback(drawChart);
				function drawChart() {
					var data = google.visualization.arrayToDataTable([
						['Questions', 'Score (1)', 'Score (2)', 'Score (3)','Score (4)','Score (5)'],
						['Question 1', <?php echo $question1; ?>],
						['Question 2', <?php echo $question2; ?>],
						['Question 3', <?php echo $question3; ?>],
						['Question 4', <?php echo $question4; ?>],
						['Question 5', <?php echo $question5; ?>]
					]);
					var options = {
						chart: {
							title: 'Evaluations',
						},
						bars: 'vertical' // Required for Material Bar Charts.
					};
					var chart = new google.charts.Bar(document.getElementById('barchart_material'));
					chart.draw(data, google.charts.Bar.convertOptions(options));
				}
			</script>
			<div id="barchart_material" style="width: 100%; height: 350px;"></div>
			<hr>
			<div class="row">
				<div class="col-lg-5">
					<h2>Questions:</h2>
					<ol>
						<li>The driver/s provided high quality service and was polite and friendly with the clients</li>
						<li>The driver was accommodating and showed a good attitude</li>
						<li>The vehicle was clean, comfortable and safe to ride on</li>
						<li>The trip went smoothly; the driver practiced safe driving</li>
						<li>The trip was relaxing and no issues were encountered</li>
					</ol>
				</div>
				<div class="col-lg-7">
					<h2>Respondents: <?php echo $respondents; ?></h2>
					<div class="card" style="padding:20px;">
						<h4 style="margin:0 0 10px 0">Conclusions:</h4>
						<ul style="margin:0">
							<?php
							if($score1<=2){
								echo "<li>Majority of the services are of poor quality. The drivers assigned to them might've been uninviting or rude</li>";
							}
							elseif($score1==3){
								echo "<li>Average. Most of the services were just fine. Would definitely improve on it, though.</li>";
							}
							else{
								echo "<li>Services were of high quality. Mantain being consistent with the niceness of the drivers</li>";
							}
							if($score2<=2){
								echo "<li>The drivers were most likely rude. Please refer yourself to the Authorised Drivers page and consider sending them an invitation regarding seminars & trainings on how they'll treat the client</li>";
							}
							elseif($score2==3){
								echo "<li>Pretty average. Again. Improve on their social skills. It'll benefit them in the long run.</li>";
							}
							else{
								echo "<li>A lot of them are great drivers. Clients felt the hospitality. Keep it up.</li>";
							}
							if($score3<=2){
								echo "<li>Clients were pretty much in a horrible environment. Please clean the vehicle regularly, buy air fresheners, etc.</li>";
							}
							elseif($score3==3){
								echo "<li>Cleanliness and comfortability is average at best</li>";
							}
							else{
								echo "<li>Cleanliness is spot on. Some of the vehicles could use some work, though.</li>";
							}
							if($score4<=2){
								echo "<li>Your clients probably didn't feel safe at all with how the driver drove. Please contact said drivers immediately.</li>";
							}
							elseif($score4==3){
								echo "<li>Please tell the drivers to improve on their driving skills while still being safe.</li>";
							}
							else{
								echo "<li>The clients felt safe and wasn't nervous with the trip.</li>";
							}
							if($score5<=2){
								echo "<li>The trips weren't relaxing at all. Maybe the AC was broken, or the seats didn't feel right, chair was shaky, etc.</li>";
							}
							elseif($score5==3){
								echo "<li>Average trip experience. Wasn't relaxing, wasn't bothering either. Could definitely still do some work.</li>";
							}
							else{
								echo "<li>A great trip experience overall, from when they were picked up all the way to when they finished.</li>";
							} ?>
						</ul>
						<!-- 
						comments if q1 
						1
						2
						3
						4
						5
						comments if q2 =
						1
						2
						3
						4
						5
						comments if q3 =
						1
						2
						3
						4
						5
						comments if q4 =
						1
						2
						3
						4
						5
						comments if q5 =
						1
						2
						3
						4
						5
						-->
					</div>
				</div>
			</div>
		</div>
		<?php
		// $sql1=mysqli_query($conn,"SELECT questions, booking_rating_sub.value, COUNT(booking_rating_sub.value) FROM `booking_rating_sub` WHERE questions=1 GROUP BY booking_rating_sub.value ORDER BY booking_rating_sub.value");
		// $row1=mysqli_fetch_assoc($sql1);

		// $sql2=mysqli_query($conn,"SELECT questions, booking_rating_sub.value, COUNT(booking_rating_sub.value) FROM `booking_rating_sub` WHERE questions=2 GROUP BY booking_rating_sub.value ORDER BY booking_rating_sub.value");
		// $row2=mysqli_fetch_assoc($sql2);

		// $sql3=mysqli_query($conn,"SELECT questions, booking_rating_sub.value, COUNT(booking_rating_sub.value) FROM `booking_rating_sub` WHERE questions=3 GROUP BY booking_rating_sub.value ORDER BY booking_rating_sub.value");
		// $row3=mysqli_fetch_assoc($sql3);

		// $sql4=mysqli_query($conn,"SELECT questions, booking_rating_sub.value, COUNT(booking_rating_sub.value) FROM `booking_rating_sub` WHERE questions=4 GROUP BY booking_rating_sub.value ORDER BY booking_rating_sub.value");
		// $row4=mysqli_fetch_assoc($sql4);

		// $sql5=mysqli_query($conn,"SELECT questions, booking_rating_sub.value, COUNT(booking_rating_sub.value) FROM `booking_rating_sub` WHERE questions=5 GROUP BY booking_rating_sub.value ORDER BY booking_rating_sub.value");
		// $row5=mysqli_fetch_assoc($sql5);

		// for($i=1;$i<=5;$i++){
		// 	$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=1");
		// 	$row1=mysqli_fetch_assoc($sql1);
		// 	$res = $row1['resQ'];
		// 	$ques1[]=$res;
		// }
		// for($i=1;$i<=5;$i++){
		// 	$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=2");
		// 	$row1=mysqli_fetch_assoc($sql1);
		// 	$res = $row1['resQ'];
		// 	$ques2[]=$res;
		// }
		// for($i=1;$i<=5;$i++){
		// 	$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=3");
		// 	$row1=mysqli_fetch_assoc($sql1);
		// 	$res = $row1['resQ'];
		// 	$ques3[]=$res;
		// }
		// for($i=1;$i<=5;$i++){
		// 	$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=4");
		// 	$row1=mysqli_fetch_assoc($sql1);
		// 	$res = $row1['resQ'];
		// 	$ques4[]=$res;
		// }
		// for($i=1;$i<=5;$i++){
		// 	$sql1=mysqli_query($conn,"SELECT count(questions) as resQ FROM booking_rating_sub WHERE booking_rating_sub.value=$i AND questions=5");
		// 	$row1=mysqli_fetch_assoc($sql1);
		// 	$res = $row1['resQ'];
		// 	$ques5[]=$res;
		// }

		// echo "<pre>";
		// print_r($ques1);
		// echo "</pre>";

		// echo "<pre>";
		// print_r($ques2);
		// echo "</pre>";

		// echo "<pre>";
		// print_r($ques3);
		// echo "</pre>";

		// echo "<pre>";
		// print_r($ques4);
		// echo "</pre>";

		// echo "<pre>";
		// print_r($ques5);
		// echo "</pre>";

		// for($i=0;$i<5;$i++){
		// 	echo $ques1[$i];
		// } ?>
	</div>
</main>
<?php
require "footer.php";?>