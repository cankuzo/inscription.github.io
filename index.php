<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit(); 
  }
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="style.css" />
  
   <style>
          <script>
        function validate(){

            var a = document.getElementById("motdepasse").value;
            var b = document.getElementById("confirm_password").value;
            if (a!=b) {
               alert("Veuillez utiliser les mots de passe semblables !");
               return false;
            }
        }
        function Afficher()
{ 
var input = document.getElementById("motdepasse"); 
if (input.type === "password")
{ 
input.type = "text"; 
} 
else
{ 
input.type = "password"; 
} 
}
     </script>
      
    </style>
  
  </head>
  <body>
    <div class="sucess">
    <h1>Bienvenue <?php echo $_SESSION['username'];
    
      // Vérifie qu'il provient d'un formulaire

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //identifiants mysql
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "inscriptiontic";
    
    $Nom = $_POST["Nom"];
    $Prenom=$_POST["Prenom"];
    $Genre=$_POST["Genre"];
    $Matricule = $_POST["Matricule"];
    $Pourcent=$_POST["Pourcent"];
    $Option=$_POST["Option"];
    $Bac=$_POST["Bac"];
    $Tel=$_POST["Tel"];
    $Email = $_POST["Email"];
    $photo = "uploads/";
    $CNI=$_POST["CNI"];

    if (!isset($Nom)){
      die("S'il vous plaît entrez votre nom");
    }
     if (!isset($Prenom)){
      die("S'il vous plaît entrez votre Prenom");
    }
      if (!isset($Genre)){
      die("S'il vous plaît entrez votre Genre");
    }
      if (!isset($Matricule)){
      die("S'il vous plaît entrez votre matricule");
    }
      if (!isset($Pourcent)){
      die("S'il vous plaît entrez votre Pourcentage");
    }
      if (!isset($Option)){
      die("S'il vous plaît entrez votre Option");
    }
      if (!isset($Bac)){
      die("S'il vous plaît entrez votre Baccalauréat");
    }
    
      if (!isset($Tel)){
      die("S'il vous plaît entrez votre numéro de téléphone");
    }
    
   if (!isset($Email) || !filter_var($Email, FILTER_VALIDATE_EMAIL)){
      die("S'il vous plaît entrez votre adresse e-mail");     
    }
    if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
                            {
                        if ($_FILES['photo']['size'] <= 1000000)
                                    {

                                            $fichier = pathinfo($_FILES['photo']['name']);
                                            $extension_upload = $fichier['extension'];
                                            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG');
                                            if (in_array($extension_upload, $extensions_autorisees))
                                            {
                                            move_uploaded_file($_FILES['photo']['tmp_name'], '../img/produits/' . basename($_FILES['photo']['name']));
                                            $requete = $bdd->prepare('INSERT INTO etudiant(photo) VALUES (?)') or exit(print_r($bdd->errorInfo()));
                                            $requete->execute(array($_FILES['photo']['name']));

                                            }else{
                                                $erreur = "un problème de téléchargement est survenu !!";
                                            }
                                    }
                            }
    if (!isset($CNI)){
      die("S'il vous plaît entrez votre CNI");
    }
    
    //Ouvrir une nouvelle connexion au serveur MySQL
    $mysqli = new mysqli($host, $username, $password, $database);
    
    //Afficher toute erreur de connexion
    if ($mysqli->connect_error) {
      die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }  

    //préparer la requête d'insertion SQL POUR Etudiant
    $statement = $mysqli->prepare("INSERT INTO etudiant (Nom,Prenom, Genre,Matricule,Pourcent,Option,Bac,Tel,Email,photo, CNI) VALUES(?,?,?,?,?,?,?,?,?,?, ?)"); 
    //Associer les valeurs et exécuter la requête d'insertion
    $statement->bind_param('sssssssssss', $Nom,$Prenom, $Genre,$Matricule,$Pourcent,$Option,$Bac,$Tel,$Email,$photo,$CNI); 
    
    if($statement->execute()){
      print "Salut " . $Nom . " " . $Prenom . "!,votre inscription est bien reçu" ;
    }
    else{
      print $mysqli->error; 
    }
  }
    
    ?>!</h1>
    <p>votre tableau de bord est ici en dessous.</p>
    
    <br><br><br><br>

                <form method="post" action="inscriptiontic.php" onSubmit="return validate();" enctype="multipart/form-data">

    <fieldset>
 <legend><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> <h2><i><font color="red">  Veuillez Entrer votre presentation pour valider l'inscription :</font></i></h2></font></font></legend>
       <br><br><br><br>  
    <p align="center">
      Nom: <input type="text" style="margin-left:63px;" name="Nom" placeholder="Entrez le nom"><br><br><br>
      Prénom:<input type="text" style="margin-left:30px; " name="Prenom" placeholder="Entrer le prenom"><br><br><br>
      Genre:<input type="text" style="margin-left:30px; " name="Genre" placeholder="Entrer votre genre"><br><br><br>
  Matricule: <input type="text" style="margin-left:59px; " name="Matricule" placeholder="Entrez votre matricule"><br><br><br>
      Pourcentage: <input type="text" style="margin-left:24px; " name=" Pourcent" placeholder="Entrez la note obtenu à l'Exetat"><br><br><br>
      Option : <input type="text" style="margin-left:62px;" name="Option" placeholder="Entrez votre option préférée"><br><br><br>
      Baccalauréat: <input type="text" style="margin-left:58px; " name="Bac" placeholder="Entrez le Bac"><br><br><br>
       Télephone : <input type="text" style="margin-left:50px; " name="Tel" placeholder="Entrez le numéro de téléphone"><br><br><br>
       Email: <input type="email" style="margin-left:60px; " name="Email" placeholder="Entrez votre email valide"><br><br><br>
        Photo passeport : <input type="file" style="margin-left:50px; " name="photo" placeholder="Entrez votre photo passeport"><br><br><br>
         CNI : <input type="text" style="margin-left:50px; " name="CNI" placeholder="Entrez votre numéro d'identité"><br><br><br>
        <div align=" center">
        Mot de passe:             <input type="password" id="motdepasse" name="password" placeholder="Entrez le mot de passe"/><input type="checkbox" onclick="Afficher()"> Afficher le mot de passe<br/></br></br>
       Confirmer le mot de passe: <input type="password" id="confirm_password" name="confirm_password" placeholder="Répeter le mot de passe"/><input type="checkbox" onclick="Afficher()"> Afficher le mot de passe</br></br></br>
       &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="submit" value="Commander"/> 
        </div>
    </fieldset>
     <br>
  <br>
  <br>
    </form> 
    <a href="logout.php">Deconnexion</a>
    </div>
  </body>
</html>
