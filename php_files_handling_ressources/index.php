<?php include('inc/head.php');
// ouvre dossier files/roswell
if (isset($_POST["contenu"])){
    $fichier="files/roswell/".$_POST["file"];
    $file = fopen($fichier,"w"); //on ouvre le document texte
    fwrite($file,$_POST["contenu"]);  // on voit le contenu et on peut le modifier
    fclose($file);
}
// lister les dossiers et fichiers dans roswell
$dir = scandir('files/roswell/');
foreach ($dir as $file) {
    if (!in_array($file, array(".", ".."))) {
        echo '<a href ="?f=' . $file . '">' . '</br>' . $file . '</a>' . ' '; // permet de récupérer le nom du fichier dans l'url
        echo '<a href="?delete=files/roswell/' . $file . '"><input type="submit" class="btn-danger" name="delete" value="delete">' . '</a>'; // bouton de suppression des dossiers
    }
}

$extensionText = ['html','txt'];
$extensionImg = ['jpg'];
$extensionTotal = ['html','txt','jpg'];
if (isset($_GET['f'])){
    $info = new SplFileInfo($_GET['f']);
    $extension = $info->getExtension();
    $info = new SplFileInfo($_GET['f']);
    $extension = $info->getExtension();
    //pour ouvrir les dossiers dans roswell, on les retrouve car ils n'ont pas d'extension
    if (!in_array($extension, $extensionTotal)){
        $folder = scandir('files/roswell/'.$_GET['f']);
        foreach ($folder as $file) {
            if(!in_array($file, array(".",".."))){
                echo '<a href ="?f=files/roswell/'.$_GET['f'].'/' . $file . '">'.'</br>'.$file.'</a>'.' '; // pour lister les fichiers contenus dans les dossiers
                echo '<a href="?delete=files/roswell/' . $_GET['f'] . '/' . $file . '"><input type="submit" class="btn-warning" name="delete" value="delete">' . '</a>'; // bouton de suppression des fichiers/images
            }
        }
    }
}

if (isset($_GET['delete'])){
    rmdir($_GET['delete']);
    header('location: /');
    unlink($_GET['delete']);
    header('location: /');
}

if (isset($_GET["f"])) {
    if (in_array($extension, $extensionText)) {
        $fichier = "files/roswell/" . $_GET["f"];
        $contenu = file_get_contents($fichier);
        ?>
        <div class="container">
        <form method="POST" action="index.php">
            <textarea name="contenu" style="width:80%;height: 150px;"><?= $contenu ?></textarea>
            <input type="hidden" name="file" value="<?= $_GET["f"] ?>">
            <input type="submit" value="envoyer">
        </form>
        <?php
    }
    if (in_array($extension, $extensionImg)) {
        $fichier = $_GET["f"];
        $contenu = file_get_contents($fichier) ?>
        <div class="container">
        <img  src="<?= $fichier ?>" height="150" width="250"/><?php
    }
}




?>
    </div>
    </div>
<?php include('inc/foot.php'); ?>