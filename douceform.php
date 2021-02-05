<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"        content="Stéphane Gabrielly au top !">
    <meta description="Stéphane Gabrielly est chef formateur dans l'une des plus grandes écoles de cuisine de Paris après avoir été chef de cuisine aux Etats-Unis, à Bordeaux, à Bayonne, puis chef à domicile dans le Sud-Ouest et formateur cuisinier à l'Institut Paul-Bocuse à Lyon.">
    <meta name="twitter:card"       content="summary_large_image">
    <meta name="twitter:site"       content="@nomsite">
    <meta name="twitter:creator"    content="@twitter">
    <meta name="twitter:title"      content="Vapeur Douce">
    <meta name="twitter:description" content="Stéphane Gabrielly sort son dernier livre Plats gourmands, Vapeur Douce, Stéphane vous propose son nouveau site  d'aide-mémoire à vous lecteurs.">
    <meta name="twitter:image"      content="https://briefstephanie.000webhostapp.com/">
    <!--facebook*/-->
<meta property="og:url"                content="https://briefstephanie.000webhostapp.com/">
<meta property="og:type"               content="website">
<meta property="og:title"              content="Vapeur Douce">
<meta property="og:description"        content="Stéphane Gabrielly sort son dernier livre Plats gourmands, Vapeur Douce, Stéphane vous propose son nouveau site  d'aide-mémoire à vous lecteurs.">
<meta property="og:image"              content="liquid-nitrogen-in-bucket-at-lab.jpg">

    <link rel="stylesheet" href="douce.css">
    <title>Vapeur douce cuisson</title>
</head>

<body>
<div class="container">
<div class="titre">
    <h1>Vapeur Douce</h1>
    
    </div>
<form action="" method="post">
    <label for="recherche">Mot recherche</label> 
    <input type="text" id="recherche" name="recherche" required="required"/> 
    <input type="submit" value="Rechercher" /></form>

</div>
<?php
//nettoyage
 
// on supprime :  / ? : @ & = + $ , . ! ~ *  les espaces multiples et les underscore
    
    $recherche = htmlspecialchars(($_POST['recherche']), ENT_QUOTES); 
    // Déclaration de la variable qui prend comme valeur le mot saisi dans le formulaire 
    //htlmlspecialchars convertit les caractères spéciaux en entités HTML
    //ENT_QUOTES Convertit les guillemets doubles et les guillemets simples.
    $recherche = urlencode($recherche);
    $recherche = strtolower($recherche);//enlever toutes les maj
    $recherche = ucfirst ($recherche);//pour mettre 1er lettre en maj
    $recherche = str_replace(' ', '+', $recherche); 
    $recherche = str_replace('-', '+', $recherche);
    
    // fixe l'URL et les autres options appropriées
    $curl = curl_init();
    curl_setopt_array($curl, [ // paramétrage de la session curl
        CURLOPT_URL => "https://api.hmz.tf/?id=".$recherche, //récupère l'url 
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true, // retourne une chaine de caractère
        CURLOPT_TIMEOUT => 1, //durée d'attente avant réponse du serveur
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // force l'http/1.1
        
        ]);
       
    $data = curl_exec($curl);// attrape l'URL et la placer dans une variable
    $data = json_decode($data, true);
    $sucess = $data['status'];
    
    curl_close($curl);// ferme le cURL et libère les ressources systèmes
if($sucess === 'error'){
    echo "<div class='reponse'>l'ingrédient n'a pas été trouvé</div>";    
 } 
else {
    echo "<div class='reponse'><h3>l'ingrédient est: " .$data['message']['nom']. "</h3></div> ";   
    echo "<div class='reponse'><h3>le temps de cuisson est de: ".$data['message']['vapeur']['cuisson']."</h3></div> ";  
}

 if(array_key_exists("trempage",$data['message']['vapeur'])) {
    echo "<div class='reponse'><h3>Trempage : " .$data['message']['vapeur']['trempage']. "</h3></div> ";   
 }
 else {
     echo "<div class='reponse'><h3></h3></div>"; // si  pas de trempage
 }
 if(array_key_exists('niveau d\'eau', $data['message']['vapeur'])) { // Condition pour vérifer si niveau d'eau existe 
    echo "<div class='reponse'><h3>Niveau d'eau : " . $data['message']['vapeur']['niveau d\'eau']. "</h3></div>"; 
 }
 else {
     echo "<div class='reponse'><h3></h3></div>"; // si pas de niveau d'eau 
 }
?>
</body>
</html>