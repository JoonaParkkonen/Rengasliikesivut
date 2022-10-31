<?php
	include('conn.php');
	
    session_start();

	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$email=$_POST['email'];
	$address=$_POST['address'];
	$postnum=$_POST['postnum'];
	$city=$_POST['city'];
	$date=$_POST['date'];
	$chip=$_POST['chip'];


    
	?>
	<!DOCTYPE html>
	<html>
    <head>
        <title>Tilaukseni</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="renkaat1.css">
    </head>
    <body>
	<img src="logo_dark.jpg" id="logo" alt="MustatRenkaat">
	<?php
	//Asetetaan tietokantaan henkilön tiedot
	mysqli_query($conn,"INSERT INTO `asiakastaulu` (etunimi,sukunimi,email,osoite,postinumero,paikkakunta) VALUES ('$firstname', '$lastname', '$email', '$address', '$postnum','$city')"); 
	//Haetaan tietokannasta henkilön tiedot jotka on tallennettu sinne viimeisenä
    $query=mysqli_query($conn,"SELECT etunimi,sukunimi,email,osoite,postinumero,paikkakunta FROM asiakastaulu WHERE id = @@Identity"); 
    while($row=mysqli_fetch_array($query))
	{?>

	<form id="form4" method="POST" action="orderfinal.php">
	<h1>Tilaus</h1>
	<label>Etunimi:</label><br><input type="text" readonly value="<?php echo $row['etunimi']; ?>" name="firstname"><br><br>
	<label>Sukunimi:</label><br><input type="text"readonly value="<?php echo $row['sukunimi']; ?>" name="lastname"><br><br>
	<label>Email:</label><br><input type="text" readonly value="<?php echo $row['email']; ?>" name="email"><br><br>
	<label>Osoite:</label><br><input type="text" readonly value="<?php echo $row['osoite']; ?>" name="address"><br><br>
	<label>Postinumero:</label><br><input type="number" readonly valuee="<?php echo $row['postinumero']; ?>" name="postnum"><br><br>
	<label>Paikkakunta:</label><br><input type="text" readonly value="<?php echo $row['paikkakunta']; ?>" name="city"><br><br>
    <label>Päivämäärä:</label><br><input type="date" name="date" readonly value="<?= date('Y-m-d') ?>"><br><br>
    <?php
	//Asetetaan tietokantaan tilaustauluun tiedot viimeisimmän asetetun henkilötiedon id mukaan
	mysqli_query($conn,"INSERT INTO `tilaustaulu` (asiakas_id,pvm,toimitus) VALUES  (@@Identity, '$date','$chip')");
	//Haetaan tilaustaulusta viimeisin tallennettu id ja piilotetaan se näkyviltä
	$query=mysqli_query($conn,"SELECT id,toimitus FROM tilaustaulu WHERE id = @@Identity"); 

	while($row1=mysqli_fetch_array($query))
	{
	?>
	<input type="hidden" readonly value="<?php echo $row1['id']; ?>" name="id"><br><br>
	<label>Toimitus:</label><br><input type="Text" readonly value="<?php echo $row1['toimitus']; ?>" name="toimitus"><br><br>
	<?php
	}
    }
	?>
	<button id="ready" onclick = "fun();">Valmis</button>
	<script>function fun()
	{  
  		alert ("Tilauksesi lähetetty!");  
	}  
	</script>
	</form>
	
    <h2 id="cart">Tilaus:</h2>
	<?php $total=0; ?>
	<table border="1">
	
    <tr>
	<th>Id</th>
	<th>Merkki</th>
	<th>Malli</th>
	<th>Tyyppi</th>
	<th>koko</th>
	<th>a`hinta</th>
	<th>Määrä</th>
    <th>Hinta yht</th>
	</tr>
	

        
	<?php 
	//Tulostaa ostoskorin sivustolle ja päivittää tietokantaan renkaan saldon
	if(!empty($_SESSION['cart']))
	{
		foreach($_SESSION['cart'] as $key => $value)
		{
	?>
	<tr>
	<td><?php echo $value['RengasID'];?></td>
	<td><?php echo $value['Merkki'];?></td>
	<td><?php echo $value['Malli'];?></td>
	<td><?php echo $value['Tyyppi'];?></td>
	<td><?php echo $value['Koko'];?></td>
	<td><?php echo $value['Hinta'];?></td>
	<td><?php echo $value['Maara'];?></td>
	<td><?php echo number_format( $value['Maara']*$value['Hinta'],2);?>€</td>
	<?php mysqli_query($conn,"UPDATE `renkaat` SET saldo= saldo- $value[Maara] WHERE RengasID=$value[RengasID]");
	?>
	</tr>

	<?php
	 $total=$total+$value['Maara']*$value['Hinta'];
	}
	mysqli_close($conn);
}
?>
<tr>
	<td colspan='6'></td>
	<td>Yhteensä</td>
	<td><?php echo number_format( $total,2);?>€</td>
</tr>

</table>
<br><br>
	
	
	<br><br>
	
		
	
	<div class="footer">
		<h2>Ota yhteyttä:</h2>
		<p>MustatRenkaat Oy</p>
		<p>Puhelin: 040-7128158</p>
		<p>Aukioloajat ma-la klo 8-17</p>
	</div>
	</body>
	</html>