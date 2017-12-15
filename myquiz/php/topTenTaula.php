<?php 
		include "dbconfig.php"; 
		sleep(2);
		$link = mysqli_connect($server, $user, $pass, $db) or die ("Error while connecting to data base.");
		$sql="select * from anonimoak ORDER BY puntuazioa desc LIMIT 10";
		$result=mysqli_query($link, $sql);
		if(!($result))
			echo "Error in the query" . $result->error;
		else{
			echo '<table border=1 style="border-collapse:collapse;background-color:#ffffff; "><tr><th> Nick-a </th><th> Puntuazioa </th></tr>';
			while($row = mysqli_fetch_array($result)){	
				echo '<tr><td>' . $row['nick'] . '</td><td>' . $row['puntuazioa'] . '</td></tr>';
			}	
			echo '</table>';	
			mysqli_close($link);
		}
?>