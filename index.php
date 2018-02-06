<?php
// Démarrage de la session
session_start();

// Initialisation
include 'config/init.php';
if ($_SESSION['id']) {
	if ($db = connect_db()) {
		$query = $db->query("SELECT `id` FROM Users WHERE id='".$_SESSION['id']."'");
		$exist = $query->fetch();
		if (!$exist) {
			session_unset($_SESSION);
			$_SESSION = [];
		}
	}
}
// Debut de la tamporisation de sortie
ob_start();

// Si un module est specifié, on regarde s'il existe
if (!empty($_GET['module'])) {

	$module = dirname(__FILE__).'/modules/'.$_GET['module'].'/';

	// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
	$action = (!empty($_GET['action'])) ? $_GET['action'].'.php' : 'index.php';

//	echo $module;
//	echo $action;
	// Si l'action existe, on l'exécute
	if (is_file($module.$action)) {

		include $module.$action;

	}

	else if (is_file($module.'index.php')) {

		include $module.'index.php';

	}

	// Sinon, on affiche la page d'accueil
	else {
		require 'modeles/images/get_img.php';
		require 'view/index.php';
	}

// Module non specifié ou invalide ? On affiche la page d'accueil
}

else {
	require 'modeles/images/get_img.php';
	require 'view/index.php';
}

// Fin de la tamporisation de sortie
$contenu = ob_get_clean();
// Début du code HTML
include 'view/header.php';

echo $contenu;
//var_dump($_SESSION);
//die();
unset($_SESSION['errors']);
unset($_SESSION['success']);

// Fin du code HTML
include 'view/footer.php';

?>
