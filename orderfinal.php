<?php
	include('conn.php');
	session_start();
	$id=$_POST['id'];
	
    foreach($_SESSION['cart'] as $userArray)
	{
        $rid = $userArray['RengasID']; 
        $maa = $userArray['Maara']; 
		//Tallentaa tietokantaan tilausrivitauluun  tilaus id, tuote id ja tilausmäärän. Tilaus nyt kokonaan suoritettu ja kaikki tarvittava tallennettu tietokantaan
        mysqli_query($conn,"INSERT INTO `tilausrivitaulu` (tilaus_id, tuote_id,tilausmaara) VALUES ('$id','$rid','$maa') ");
    }
	//Tuhotaan sessionista tiedot ja palataan tilaus sivulle
	session_destroy();
	mysqli_close($conn);
	header('location:order.php');









