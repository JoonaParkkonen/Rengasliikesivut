<?php
session_start();
include ('conn.php');

//Lisää arrayhin renkaan id, merkin, mallin yms.
if (isset($_POST['add']))
{
if(isset($_SESSION['cart']))
{
$session_array_id=array_column($_SESSION['cart'],"RengasID");

if(!in_array($_GET['RengasID'], $session_array_id))
{
    $session_array=array(
        "RengasID"=> $_GET['RengasID'],
        "Merkki"=> $_POST['Merkki'],
        "Malli"=> $_POST['Malli'],
        "Koko"=> $_POST['Koko'],
        "Tyyppi"=> $_POST['Tyyppi'],
        "Hinta"=> $_POST['Hinta'],
        "Maara"=> $_POST['Maara']
            );
             $_SESSION['cart'][]=$session_array;
}

}
else
{
$session_array=array(
    "RengasID"=> $_GET['RengasID'],
    "Merkki"=> $_POST['Merkki'],
    "Malli"=> $_POST['Malli'],
    "Koko"=> $_POST['Koko'],
    "Tyyppi"=> $_POST['Tyyppi'],
    "Hinta"=> $_POST['Hinta'],
    "Maara"=> $_POST['Maara']
        
    );
     $_SESSION['cart'][]=$session_array;
}



}

//Kun painetaan poista nappia, poistetaan kyseinen rengas ostoskorista.
if(isset($_GET['action']))
{
if($_GET['action']=="remove")
{
    foreach ($_SESSION['cart'] as $key => $value)
    {
        if($value['RengasID']==$_GET['RengasID'])
        {
            unset($_SESSION['cart'][$key]);

            header("Refresh:0");
            
        }
    }
}
} ?>


<!DOCTYPE html>
<html>
    <head>
        <title>Tilaus</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="renkaat1.css">
    </head>
    <body>
    <div class="header">
        <img src="logo_dark.jpg" id="logo" alt="MustatRenkaat">
    </div>
    
    
    <div class="navbar">
      <a href="Etusivu.html">Etusivu</a>
      <a href="order.php">Renkaat</a>
      <a href="info.html">Info</a>
      <a href="yhteystiedot.html">Yhteystiedot</a>
    </div>
    
    <div class="row">

    <div class="side">
    

    <form id="form" method="POST" name="form1" action=""> 
    <h1 >Etsi rengasta:</h1>
    <select name="Koko" >
    <option value="">--- Valitse rengas ---</option>  
    <?php
      
      // Haetaan dropdowniin tietokannassa olevat renkaat
    $query=mysqli_query($conn,"SELECT  DISTINCT Koko FROM renkaat ORDER BY  Koko ASC");
    
    while($row=mysqli_fetch_array($query)):;?>
     
    <option><?php echo $row['Koko'];?></option>
    <?php endwhile ;?>
    </select>
    <br><br>
    <input type="submit"  name="submit" value="Etsi">
    
    </form>
    <br><br>

    <?php
    // Jos haluttu koko valittu dropdownista, avataan sivulle renkaan tiedot kuvan kanssa.
    if(isset($_POST["Koko"]))
    {
        $koko= $_POST["Koko"];
        $query="SELECT RengasID,Merkki, Malli, Tyyppi, Koko, Hinta,Saldo FROM `renkaat`  WHERE Koko  = '$koko'  ORDER BY  Hinta ASC  " ;
   

    $result =mysqli_query($conn,$query);
    while($row=mysqli_fetch_array($result))
    {
    ?>

    <form id="form2" method="POST" action="order.php?RengasID=<?=$row['RengasID']?>">
    <h5><?=$row['Merkki'];?></h5>
    <h5><?=$row['Malli'];?></h5>
    <h5><?=$row['Koko'];?></h5>
    <h5><?=$row['Tyyppi'];?></h5>
    <img src="tyre.jpg" id="tyre" alt="Rengas">
    <h5><?=number_format($row['Hinta'],2);?>€</h5>
    <h5>Tilattavissa <?=$row['Saldo'];?></h5>
    <input type="hidden" name="Merkki" value="<?=$row['Merkki']?>">
    <input type="hidden" name="Malli" value="<?=$row['Malli']?>">
    <input type="hidden" name="Koko" value="<?=$row['Koko']?>">
    <input type="hidden" name="Tyyppi" value="<?=$row['Tyyppi']?>">
    <input type="hidden" name="Hinta" value="<?=$row['Hinta']?>">
    <input type="number" name="Maara" max="<?php echo $row['Saldo']?>"  min="1" value="1" >
    <input type= "submit" name="add" value="Ostoskoriin">
    </form>
    <br>


    <?php
    //Formi johon syötetään tilaajan henkilötiedot
    }
        }?>

    <form id="form3" action="ownorder.php" method="POST">
    <h2>Tilaajan henkilötiedot</h2>
                <label>Etunimi:</label><br><input type="text"  name="firstname"required><br><br>
                <label>Sukunimi:</label><br><input type="text"  name="lastname"required><br><br>
                <label>Email:</label><br><input type="text"  name="email"required><br><br>
                <label>Osoite:</label><br><input type="text"  name="address"required><br><br>
                <label>Postinumero:</label><br><input type="number" name="postnum"required><br><br>
                <label>Paikkakunta:</label><br><input type="text"  name="city"required><br><br>
                <label>Päivämäärä:</label><br><input type="date" required name="date" value="<?= date('Y-m-d') ?>"><br>
                <p>Valitse toimitus tai nouto:</p>
                
                  <input type="radio" id="toimitus" name="chip" value="Matkahuolto" required >
                  <label for="matkahuolto">Matkahuolto</label><br>
                  <input type="radio" id="nouto" name="chip" value="Nouto" required >
                  <label for="nouto">Nouto</label><br>
                <?php 
                //Vahvista nappula tulee näkyviin vasta kun ostoskorissa on tavaraa
    if(!empty($_SESSION['cart']))
    {
                ?><button id="order">Vahvista tilaus</button>
                <?php
    }?>
    </form>
    <br>
    </div>

    <div class= "main">

    <?php $total=0; ?>
 
    <table class="tableset">
    <h2 id="cart">Ostoskori:</h2>
            <tr>
            <th>Id</th>
            <th>Merkki</th>
            <th>Malli</th>
            <th>Tyyppi</th>
            <th>koko</th>
            <th>a`hinta</th>
            <th>Määrä</th>
            <th>Hinta yht</th>
            <th></th>
            </tr>
        
    <?php 
    //Tässä tulostetaan sivulle ostoskori mahdollisine renkaineen
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
    <td>
        <a href="order.php?action=remove&RengasID=<?php echo $value['RengasID'] ?>">
            <button>Poista</button>
        </a>
    </td>
    </tr>

    <?php
    $total=$total+$value['Maara']*$value['Hinta'];
        }
    }
    ?>
    <tr>
        <td colspan='6'></td>
        <td>Yhteensä</td>
        <td><?php echo number_format( $total,2);?>€</td>
        <td></td>
    </tr>

    </table>
    
    <br><br>
    
    <div class="etukuva"><img src="renkaita.jpeg" id="renkaita" alt="renkaita"></div>
   


    </div>
    </div>

    <div class="footer">
        <h2>Ota yhteyttä:</h2>
        <p>MustatRenkaat Oy</p>
        <p>Puhelin: 040-7128158</p>
        <p>Aukioloajat ma-la klo 8-17</p>
    </div>

    </body>
    </html>
