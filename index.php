<?php include('server.php'); 
	if(empty($_SESSION['username'])){
		header('location:login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ClubManagementSystem</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
	<div id="header" class="header">
		<h2>HomePage</h2>
	</div>
	<div class="content">
		<?php if (isset($_SESSION['success'])): ?>
			<div class="error success">
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3>
		<?php endif ?>
		<?php if (isset($_SESSION["username"])): ?>
			<p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong> !</p>
			<p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
		<?php endif ?>
		<div class = "navigation-bar">
			<button type="button" name="getDetails" class="btn" onclick="getData()">GetTaskDetails</button>
			<button type="button" name="displayNew" class="btn" onclick="$('#board').slideDown()">Add New Task</button>
		</div>
	</div>
	<div id="chart_div" align = 'center'>
		<script type="text/javascript" src="loader.js"></script>
		<script type="text/javascript" src="jquery.min.js"></script>
			<script type="text/javascript">
			google.charts.load('current', {'packages':['gantt']});
			google.charts.setOnLoadCallback(drawChart);
			var chart;
		    var data;
			function drawChart() {
				data = new google.visualization.DataTable();
				data.addColumn('string', 'Task ID');
				data.addColumn('string', 'Task Name');
				data.addColumn('string', 'Resource');
				data.addColumn('date', 'Start Date');
				data.addColumn('date', 'End Date');
				data.addColumn('number', 'Duration');
				data.addColumn('number', 'Percent Complete');
				data.addColumn('string', 'Dependencies');
				data.addRows([
					<?php 
						global $db;
						$sql = "SELECT * FROM tasks";
						$stmt = mysqli_query($db,$sql);
						while($datarows = mysqli_fetch_assoc($stmt)){
							$datarows['startMonth'] = $datarows['startMonth']-1;
							$datarows['endMonth'] = $datarows['endMonth']-1;
							echo "['" . $datarows['id']. " ','" . $datarows['taskName'] . "'," .'null'. ", new Date(" . $datarows['startYear']. "," . $datarows['startMonth']. "," . $datarows['startDate']. "),
									new Date(" . $datarows['endYear']. "," . $datarows['endMonth']. "," . $datarows['endDate']. "), ". 'null' . "," . $datarows['percent']. "," .'null'. "],";
						}

					?>
				]);

				var options = {
					height: 400,
					width: 1200,
					gantt: {
						criticalPathEnabled: false,
						labelStyle:{
							fontName: "comic sans ms",
							fontSize: 15
						},
						trackHeight: 80,
						backgroundColor: '#faead3'
					}

				};
				chart = new google.visualization.Gantt(document.getElementById('chart_div'));
				chart.draw(data, options);
				//console.log(data['Wf'][0]['c'][0]);
			}
			function getSelected() {
				
			 
				var a = chart.getSelection();
				if(a.length == 0) {
					return -1;
				}
				
				
				return data['Wf'][a[0]["row"]]['c'][0]["v"];
			}
			//get details
			function getData(){
				var id=getSelected();
				if(id==-1){
					alert('Please Select a Project!');
					return;
				}
				
				window.location.href ='detail.php?id='+id+"&username=<?php echo $_SESSION['username']; ?>";
				return;
				
			}
			
			function goToPostTask(){
			   window.location.href ='index.php';
			}
		</script>
		
		
		
	</div>
	
	<form  class = "NewTask" method = "post" action="index.php" id="board">
			<?php include('errors.php'); ?>
			<input id="taskid" type = "hidden" name="taskid">
			<div class="input-group">
				<label>Please Enter Task Name</label>
				<input id="taskName" type = "text" name="taskName">
			</div>
			<div class="input-group-Year">
				<label>Please Enter Start Year</label> 
				<input id="startYear" type = "number" name="startYear">
			</div>
			<div class="input-group-Month">
				<label>Please Enter Start Month</label>
				<input id="startMonth"  type = "number" name="startMonth">
			</div>
			<div class="input-group-Day">
				<label>Please Enter Start Date</label>
				<input id="startDate"  type = "number" name="startDate">
			</div>
			<div class="input-group-Year">
				<label>Please Enter End Year</label>
				<input id="endYear" type = "number" name="endYear">
			</div>
			<div class="input-group-Month">
				<label>Please Enter End Month</label>
				<input id="endMonth" type = "number" name="endMonth">
			</div>
			<div class="input-group-Day">
				<label>Please Enter End Date</label>
				<input id="endDate" type = "number" name="endDate">
			</div>
			<div class="input-group-Percent">
				<label>Please Enter Completed Percentage</label>
				<input id="percent" type = "number" name="percent">
			</div>
			<label>Please Select members of the Task: </label>
			<br>
				<?php
					$findusers = "SELECT * FROM users";
					$findusersresult = $db->query($findusers);
					//echo($foundusers);
					while($row = $findusersresult->fetch_assoc()){
					?>
					<div>
						<input type="checkbox" name="selectedPerson[]" value = <?php echo $row["id"]?>> <?php echo $row["username"]?></input>
					</div>
            <?php
            	}
				?>
			
			<div class="input-group">
				<button  id="addbtn" type="submit" name="postTask" class="btn">PostTask</button><span>	
				<button type="button" name="displayNew" class="btn" onclick="$('#board').slideUp()">Hide</button>
			</div>
	      </form>	
	
	 
	
	 
</body>
</html>