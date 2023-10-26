	<?php
	class panier{

		private $DB;
		public $monnaie=['gnf','eu','us', 'cfa'];

		public $modep=['espèces','chèque','virement', 'différé'];

		public $position=['madina','matam','matoto', 'ratoma', 'kaloum', 'kindia', 'mamou', 'dalaba', 'pita', 'labe', 'kankan', 'siguiri', 'nzerekore', 'kamsar', 'Fria', 'boke', 'boffa'];

		public function __construct($DB){
			if(!isset($_SESSION)){
				session_start();
			}

			

			if(!isset($_SESSION['stock'])){
				$_SESSION['stock'] = array();
			}

			

			$this->DB = $DB;

			if(isset($_GET['delPanier'])){
				$this->del($_GET['delPanier']);
			}

			if(isset($_GET['delpanierc'])){
				$this->delpanierc($_GET['delpanierc']);
			}

			if(isset($_GET['delPanierstock'])){
				$this->delstock($_GET['delPanierstock']);
			}

			if (isset($_POST['prix'])) {
				$_SESSION['stock'] = array();
			}

			if (isset($_POST['client'])) {
				$_SESSION['client'] = $_POST['client'];
			}

			if(isset($_POST['panier']['quantity'])){
				$this->recalc();
			}

			if(isset($_POST['panieru']['quantity'])){
				$this->recalcu();
			}

			if(isset($_POST['panierc']['quantity'])){
				$this->recalcom();
			}

			if(isset($_POST['panierca']['quantity'])){
				$this->recalca();
			}

			if(isset($_POST['paniercp']['quantity'])){
				$this->recalcp();
			}


			if(isset($_POST['montantd'])){
				$this->totalcaisse();
			}


			if(isset($_POST['validsolde'])){
				$this->soldeclient();
			}

			if(isset($_POST['devise'])){
				$this->recalcDevise();
			}

			
		}

		public function espace($value){
			return str_replace(' ', '', $value);
		}

		public function formatNombre($value){
			if ($value==0) {
				return 0;
			}else{
				return number_format($value,0,',',' ');
			}
		}

		public function h(string $value):string{
			return htmlentities($value);
		}

		public function formatDate($value){
			return((new DateTime($value))->format("d/m/Y à H:i"));
		}

		public function color($value){

			if ($value>0) {
	          $color='red';
	        }else{

	          $color='green';

	        }
			return($color);
		}

		public function deviseformat($value){

			if ($value=='eu') {
	          $format='€';
	        }elseif ($value=='us') {
	          $format='$';
	        }elseif ($value=='cfa') {
	          $format='CFA';
	        }else{

	         $format='GNF';

	        }
			return($format);
		}


		public function personnel(){

		    $reqliste=$this->DB->query("SELECT id, nom from login where type=:stat", array('stat'=>'personnel'));

		    return $reqliste;
		}

		public function nomPersonnel($nom){
			$nomclient = $this->DB->querys("SELECT *FROM login where id='{$nom}'");

			return ucwords($nomclient['nom']);
		}

		public function devise($nom){

			$proddevise=$this->DB->querys("SELECT *From devise where nomdevise='{$nom}' and idvente='{$_SESSION['lieuvente']}'");

			return $proddevise['montantdevise'];
		}

		public function recalcDevise(){

			$deviseu=$this->DB->querys('SELECT montantdevise FROM devise WHERE idvente = ? and nomdevise=? ', array($_SESSION['lieuvente'], 'euro'));

			$_SESSION['eu']=$deviseu['montantdevise'];

			$devisus=$this->DB->querys('SELECT montantdevise FROM devise WHERE idvente = ? and nomdevise=? ', array($_SESSION['lieuvente'], 'us'));

			$_SESSION['us']=$devisus['montantdevise'];

			$deviscfa=$this->DB->querys('SELECT montantdevise FROM devise WHERE idvente = ? and nomdevise=? ', array($_SESSION['lieuvente'], 'cfa'));

			$_SESSION['cfa']=$deviscfa['montantdevise'];

			return array($_SESSION['eu'], $_SESSION['us'], $_SESSION['cfa']);
		}

		public function modep($num, $mode){

			$proddevise=$this->DB->querys("SELECT montant, taux From modep where numpaiep='{$num}' and modep='{$mode}' ");

			return array($proddevise['montant'], $proddevise['taux']);
		}

		public function recalc(){
			foreach($_SESSION['panier'] as $product_id => $quantity){
				if(isset($_POST['panier']['quantity'][$product_id])){
					$_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];
					// Pour verifier si le stock est suffisant
					$ids = array_keys($_SESSION['panier']);
					if(empty($ids)){
						$products = array();
					}else{
						$products = $this->DB->query('SELECT id, quantite, Marque FROM products WHERE id IN ('.implode(',',$ids).')');
					}
					foreach( $products as $product ) {
						$quantite= $product->quantite;

					}
					
					if ($_SESSION['panier'][$product->id]>$quantite) {					
						$_SESSION['$quantite_rest']= "Attention Produit Insuffisant en Stock ";
										
					}else{
						unset($_SESSION['$quantite_rest']); //pour vider en cas de commande > au stock

					}
				}
			}
		}

		

		public function adresse(){

			$adress = $this->DB->querys('SELECT * FROM adresse ');
			return $adress['nom_mag'];
		}


		public function adresseinit($lieuvente){// Permet de recuperer un evenement

	        $prod=$this->DB->querys("SELECT *FROM adresse where lieuvente='{$lieuvente}'");
	        
			return array($prod['initial'], $prod['nom_mag']);

		}

		public function count(){
			return array_sum($_SESSION['panier']);
		}

		public function total(){	

			$prodpaie = $this->DB->querys("SELECT sum(pvente*quantite) as ptotal FROM validpaie where pseudov='{$_SESSION['idpseudo']}'");
			$prodvente = $this->DB->querys("SELECT remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque FROM validvente where pseudop='{$_SESSION['idpseudo']}'");

			$total= $prodpaie['ptotal']-$prodvente['remise']-($prodvente['montantpgnf']+$prodvente['virement']+$prodvente['cheque']+$prodvente['montantpeu']*$this->recalcDevise()[0]+$prodvente['montantpus']*$this->recalcDevise()[1]+$prodvente['montantpcfa']*$this->recalcDevise()[2]);
			
			return $total;
		}

		public function totalpaye(){	
			$prodvente = $this->DB->querys("SELECT montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque FROM validvente where pseudop='{$_SESSION['idpseudo']}'");

			$total=($prodvente['montantpgnf']+$prodvente['virement']+$prodvente['cheque']+$prodvente['montantpeu']*$this->recalcDevise()[0]+$prodvente['montantpus']*$this->recalcDevise()[1]+$prodvente['montantpcfa']*$this->recalcDevise()[2]);
			
			return $total;
		}

		public function totalcom(){	

			$prodpaie = $this->DB->querys("SELECT sum(pvente*quantite) as ptotal FROM validpaie where pseudov='{$_SESSION['idpseudo']}'");

			$total= $prodpaie['ptotal'];
			
			return $total;
		}

		public function totalmodif(){	

			$prodpaie = $this->DB->querys('SELECT sum(pvente*quantite) as ptotal FROM validpaiemodif');
			$prodvente = $this->DB->querys('SELECT * FROM validventemodif');

			$total=($prodvente['montantpgnf']+$prodvente['virement']+$prodvente['cheque']+$prodvente['montantpeu']*$this->recalcDevise()[0]+$prodvente['montantpus']*$this->recalcDevise()[1]+$prodvente['montantpcfa']*$this->recalcDevise()[2]);
			
			return $total;
		}

		public function totalcomodif(){	

			$prodpaie = $this->DB->querys("SELECT sum(pvente*quantite) as ptotal FROM validpaiemodif where pseudov='{$_SESSION['idpseudo']}'");
			$prodvente = $this->DB->querys("SELECT remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque FROM validventemodif where pseudop='{$_SESSION['idpseudo']}'");

			$total= $prodpaie['ptotal']-$prodvente['remise']-($prodvente['montantpgnf']+$prodvente['virement']+$prodvente['cheque']+$prodvente['montantpeu']*$this->recalcDevise()[0]+$prodvente['montantpus']*$this->recalcDevise()[1]+$prodvente['montantpcfa']*$this->recalcDevise()[2]);
			
			return $total;
		}

		public function modifTotal(){	

			$prodpaie = $this->DB->querys("SELECT sum(pvente*quantite) as ptotal FROM validpaiemodif where pseudov='{$_SESSION['idpseudo']}'");
			$prodvente = $this->DB->querys("SELECT remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque FROM validventemodif where pseudop='{$_SESSION['idpseudo']}'");

			$total= $prodpaie['ptotal'];
			
			return $total;
		}

		public function nbreventetotstat($id){	
			$prodvente = $this->DB->querys("SELECT sum(quantity) as qtite FROM commande where id_produit='{$id}'");
			
			return $prodvente['qtite'];
		}


		public function nbreprodstatpardate($id, $date1, $date2){

			if (isset($_POST['j1'])) {	
				$prodvente = $this->DB->querys("SELECT sum(quantity) as qtite, sum(prix_vente) as pv FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' and id_produit='{$id}'");
			}else{

				$date1=date("Y");

				$prodvente = $this->DB->querys("SELECT sum(quantity) as qtite, sum(prix_vente) as pv FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%\") >='{$date1}' and id_produit='{$id}'");

			}
			
			return $prodvente['qtite'];
		}

		public function pvprodstatpardate($id, $date1, $date2, $lieuvente){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prodvente = $this->DB->querys("SELECT sum(quantity) as qtite, sum(prix_vente*quantity) as pv, sum(prix_revient*quantity) as pr FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' and id_produit='{$id}'");

			}else{

				$prodvente = $this->DB->querys("SELECT sum(quantity) as qtite, sum(prix_vente*quantity) as pv, sum(prix_revient*quantity) as pr FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' and id_produit='{$id}' and lieuvente='{$lieuvente}'");

			}
			
			return array($prodvente['qtite'], $prodvente['pv'], $prodvente['pr']) ;
		}


		public function paprodstatpardate($id, $date1, $date2, $lieuvente){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prodvente = $this->DB->querys("SELECT sum(quantite) as qtite, sum(pachat*quantite) as pa, sum(previent*quantite) as pr FROM achat  where DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}' and id_produitfac='{$id}'");

			}else{

				$prodvente = $this->DB->querys("SELECT sum(quantite) as qtite, sum(pachat*quantite) as pa, sum(previent*quantite) as pr FROM achat  where DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}' and id_produitfac='{$id}' and idstockliv='{$lieuvente}'");

			}
			
			return array($prodvente['qtite'], $prodvente['pa'], $prodvente['pr']);
		}

		public function beneficeprodstatpardate($id, $date1, $date2){

			if (isset($_POST['j1'])) {	
				$prodvente = $this->DB->querys("SELECT sum((quantity*prix_vente)-(quantity*prix_revient)) as benefice FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' and commande.id_produit='{$id}'");
			}else{

				$date1=date("Y");

				$prodvente = $this->DB->querys("SELECT sum((quantity*prix_vente)-(quantity*prix_revient)) as benefice FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%\") >='{$date1}' and commande.id_produit='{$id}'");

			}
			
			return $prodvente['benefice'];
		}

		public function beneficestatpardate($id, $date1, $date2){

			if (isset($_POST['j1'])) {	
				$prodvente = $this->DB->querys("SELECT sum((prix_vente*quantity)-(prix_revient*quantity)) as benefice FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' and id_client='{$id}'");
			}else{

				$date1=date("Y");

				$prodvente = $this->DB->querys("SELECT sum((prix_vente*quantity)-(prix_revient*quantity)) as benefice FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%\") >='{$date1}' and id_client='{$id}'");

			}
			
			return $prodvente['benefice'];
		}

		public function montantstatpardate($id, $date1, $date2){

			if (isset($_POST['j1'])) {	
				$prodvente = $this->DB->querys("SELECT sum(prix_vente*quantity) as qtite FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' and id_client='{$id}'");
			}else{

				$date1=date("Y");

				$prodvente = $this->DB->querys("SELECT sum(prix_vente*quantity) as qtite FROM commande inner join payement on commande.num_cmd=payement.num_cmd where DATE_FORMAT(date_cmd, \"%Y%\") >='{$date1}' and id_client='{$id}'");

			}
			
			return $prodvente['qtite'];
		}



		public function listeStock(){
			$products = $this->DB->query("SELECT *FROM stock order by(nomstock)");

			return $products;
		}

		public function nomStock($nom){
			$products = $this->DB->querys("SELECT *FROM stock where id='{$nom}'");

			return array(ucwords($products['nomstock']), $products['nombdd'], $products['id'], $products['lieuvente']);
		}

		public function nomStockBull($nom){
			$products = $this->DB->querys("SELECT *FROM stock where id='{$nom}'");

			return array($products['lieuvente']);
		}

		public function listeProduitR(){

			$products = $this->DB->query("SELECT *FROM productslist");
			return $products;
		}

		public function listeProduit(){
			if (isset($_GET['recherchgen'])) {

				$products = $this->DB->query("SELECT *FROM productslist where id='{$_GET['recherchgen']}'");
			}else{

				$products = $this->DB->query("SELECT *FROM productslist");

			}

			return $products;
		}

		public function nomCategorierecette($nom){
			$nomclient = $this->DB->querys("SELECT nom FROM categorierecette where id='{$nom}'");

			return ucwords($nomclient['nom']);
		}

		public function nomCategoriedep($nom){
			$nomclient = $this->DB->querys("SELECT nom FROM categoriedep where id='{$nom}'");

			return ucwords($nomclient['nom']);
		}

		public function recherchestock(){

			$products = $this->DB->query("SELECT *FROM categorie order by (nom)");

			return $products;
		}

		public function nomCategorie($nom){
			$nomclient = $this->DB->querys("SELECT nom FROM categorie where id='{$nom}'");

			return ucwords($nomclient['nom']);
		}

		public function nomProduit($nom){
			$nomclient = $this->DB->querys("SELECT designation FROM productslist where id='{$nom}'");

			return ucwords(strtolower($nomclient['designation']));
		}

		public function compteClient($client, $devise){
			$prodcompte = $this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' ");

			return $prodcompte['montant'];
		}

		public function client(){
			$prodclient = $this->DB->query('SELECT * FROM client order by(nom_client) ');

			return $prodclient;
		}

		public function clientF($type1, $type2){

			if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {
	        	$prodclient = $this->DB->query("SELECT * FROM client where positionc='{$_SESSION['lieuvente']}' and (typeclient='{$type1}' or typeclient='{$type2}') order by(nom_client)");
	        }else{
				$prodclient = $this->DB->query("SELECT * FROM client where typeclient='{$type1}' or typeclient='{$type2}' order by(nom_client)");
			}

			

			return $prodclient;
		}

		public function ClientT($type){
			
			$prodclient = $this->DB->query("SELECT * FROM client where typeclient='{$type}' order by(nom_client)");

			return $prodclient;
		}

		public function nomClient($nom){
			$nomclient = $this->DB->querys("SELECT nom_client, telephone, adresse, mail FROM client where id='{$nom}'");

			return ucwords($nomclient['nom_client']);
		}

		public function nomClientad($nom){
			$nomclient = $this->DB->querys("SELECT nom_client, telephone, adresse, mail FROM client where id='{$nom}'");

			return array(ucwords($nomclient['nom_client']), ucwords($nomclient['telephone']), ucwords($nomclient['adresse']), strtolower($nomclient['mail']));
		}

		public function adClient($nom){
			$nomclient = $this->DB->querys("SELECT nom_client, telephone, adresse  FROM client where id='{$nom}'");

			return array(ucwords($nomclient['nom_client']), $nomclient['telephone'], ucwords($nomclient['adresse'])); 
		}


		public function nomPertes($nom){
			$nomclient = $this->DB->querys("SELECT *FROM categorieperte where id='{$nom}'");

			return array(ucwords(strtolower($nomclient['nom'])));
		}

		public function nbreVente($date1, $date2):int{//permet de recuperer le nombre de ventes

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {
				
				$prodnbre =$this->DB->querys("SELECT Count(num_cmd) as nbre FROM payement WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prodnbre =$this->DB->querys("SELECT Count(num_cmd) as nbre FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prodnbre =$this->DB->querys("SELECT Count(num_cmd) as nbre FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			

			return $prodnbre['nbre'];
		}

		public function venteTot($date1, $date2){//permet de recuperer le prix total des ventes

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {
				
				$prodnbre =$this->DB->querys("SELECT sum(Total) as tot, sum(fraisup) as frais, sum(remise) as remise FROM payement WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prodnbre =$this->DB->querys("SELECT sum(Total) as tot, sum(fraisup) as frais, sum(remise) as remise FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}else{
				
				$prodnbre =$this->DB->querys("SELECT sum(Total) as tot, sum(fraisup) as frais, sum(remise) as remise FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and vendeur='{$_SESSION['idpseudo']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			return ($prodnbre['tot']-$prodnbre['remise']-$prodnbre['frais']);
		}

		public function depenseTot($date1, $date2){//permet de recuperer le prix total des depenses

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {
				
				$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM decdepense WHERE DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM decdepense WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM decdepense WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");
			}

			return ($prodnbre['tot']);
		}

		public function gaindevise($date1, $date2){//permet de recuperer le prix total des depenses

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {
				
				$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM gaindevise WHERE DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM gaindevise WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM gaindevise WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}

			return ($prodnbre['tot']);
		}

		public function perteben($date1, $date2){//permet de recuperer le prix total des depenses

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {
				
				$prodnbre =$this->DB->querys("SELECT sum(prix_revient) as tot FROM pertes WHERE  DATE_FORMAT(datepertes, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datepertes, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prodnbre =$this->DB->querys("SELECT sum(prix_revient) as tot FROM pertes WHERE idnomstockp='{$_SESSION['lieuvente']}' and DATE_FORMAT(datepertes, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datepertes, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prodnbre =$this->DB->querys("SELECT sum(prix_revient) as tot FROM pertes WHERE idnomstockp='{$_SESSION['lieuvente']}' and DATE_FORMAT(datepertes, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datepertes, \"%Y%m%d\") <= '{$date2}'");
			}

			return ($prodnbre['tot']);
		}

		public function benefice($date1, $date2){//permet de recuperer lebenefice

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {
				
				$prodnbre =$this->DB->querys("SELECT sum(prix_vente*quantity) as pv, sum(prix_revient*quantity) as pr FROM commande inner join payement on commande.num_cmd=payement.num_cmd WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

				$prodnbreben =$this->DB->querys("SELECT sum(remise) as remise FROM payement WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prodnbre =$this->DB->querys("SELECT sum(prix_vente*quantity) as pv, sum(prix_revient*quantity) as pr FROM commande inner join payement on commande.num_cmd=payement.num_cmd WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

				$prodnbreben =$this->DB->querys("SELECT sum(remise) as remise FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prodnbre =$this->DB->querys("SELECT sum(prix_vente*quantity) as pv, sum(prix_revient*quantity) as pr FROM commande inner join payement on commande.num_cmd=payement.num_cmd WHERE lieuvente='{$_SESSION['lieuvente']}' and payement.vendeur='{$_SESSION['idpseudo']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

				$prodnbreben =$this->DB->querys("SELECT sum(remise) as remise FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and payement.vendeur='{$_SESSION['idpseudo']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			

			$benefice=($prodnbre['pv']-$prodnbreben['remise']-$this->depenseTot($date1, $date2)+$this->gaindevise($date1, $date2)-$this->perteben($date1, $date2)-$prodnbre['pr']);

			return ($benefice);
		}


		public function versementC($date1, $date2){//permet de recuperer le total des versements

			$prodnbre =$this->DB->querys("SELECT sum(montant) as montant FROM versement WHERE DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			return ($prodnbre['montant']);
		}

		public function remboursementC($date1, $date2){//permet dles remboursements du jour

			$prodnbre =$this->DB->querys("SELECT sum(montant) as montant FROM historique WHERE DATE_FORMAT(date_regul, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_regul, \"%Y%m%d\") <= '{$date2}'");

			return ($prodnbre['montant']);
		}


		public function decaissement($date1, $date2){//permet de calculer les sorties

			$mode_payement = array(

        "Espèces" => "especes",
        "Versement" => "versement",
        "Chèque" => "cheque",
        "Virement Bancaire" => "vire bancaire"        
      );

      foreach ($mode_payement as $key=> $produc ){

				$prodec =$this->DB->querys('SELECT SUM(montant) AS montant, payement FROM decaissement WHERE (DATE_FORMAT(date_payement, \'%Y%m%d\') >= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\') <= :date2) and payement= :payement', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2'], 'payement'=>$produc));

				foreach ($prodec as $value) {

					$montdec=$value->montant;
				}

				$prodep =$this->DB->query('SELECT SUM(montant) AS montant, payement FROM decdepense WHERE (DATE_FORMAT(date_payement, \'%Y%m%d\') >= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\') <= :date2) and payement= :payement', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2'], 'payement'=>$produc));

				foreach ($prodep as $value) {

					$montdep=$value->montant;					
				}

				$prodlo =$this->DB->query('SELECT SUM(montant) AS montant, payement FROM decloyer WHERE (DATE_FORMAT(date_payement, \'%Y%m%d\') >= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\') <= :date2) and payement= :payement', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2'], 'payement'=>$produc));

				foreach ($prodlo as $value) {

					$montloy=$value->montant;					
				}

				$prodpers =$this->DB->query('SELECT SUM(montant) AS montant, payement FROM decpersonnel WHERE (DATE_FORMAT(date_payement, \'%Y%m%d\') >= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\') <= :date2) and payement= :payement', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2'], 'payement'=>$produc));

				foreach ($prodpers as $value) {

					$montpers=$value->montant;					
				}
				return ($montdec+$montdep+$montloy+$montpers);
			}
		}

		public function creditF($date1, $date2){//permet les credits du magasin

			$prodnbre =$this->DB->querys("SELECT sum(montantht) as montht, sum(montantva) as montva, sum(montantpaye) as montp FROM facture WHERE DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

			return ($prodnbre['montht']+$prodnbre['montva']-$prodnbre['montp']);
		}

		public function montantCloture($date1){//permet le montant de la fermeture 

			$prodnbre =$this->DB->querys("SELECT sum(tot_saisie) as montant FROM cloture WHERE DATE_FORMAT(date_cloture, \"%Y%m%d\") <='{$date1}'");

			return ($prodnbre['montant']);
		}

		

		public function add($product_id){
			if(isset($_SESSION['panier'][$product_id])){
				$_SESSION['panier'][$product_id]++;
			}else{
				$_SESSION['panier'][$product_id] = 1;
			}
		}

		public function addu($product_id){
			if(isset($_SESSION['panieru'][$product_id])){
				$_SESSION['panieru'][$product_id]++;
			}else{
				$_SESSION['panieru'][$product_id] = 1;
			}
		}

		public function addc($product_id){
			if(isset($_SESSION['panierc'][$product_id])){
				$_SESSION['panierc'][$product_id]++;
			}else{
				$_SESSION['panierc'][$product_id] = 1;
			}
		}

		public function addca($product_id){
			if(isset($_SESSION['panierca'][$product_id])){
				$_SESSION['panierca'][$product_id]++;
			}else{
				$_SESSION['panierca'][$product_id] = 1;
			}
		}

		public function addcp($product_id){
			if(isset($_SESSION['paniercp'][$product_id])){
				$_SESSION['paniercp'][$product_id]++;
			}else{
				$_SESSION['paniercp'][$product_id] = 1;
			}
		}

		public function addstock($product_id){
			if(isset($_SESSION['stock'][$product_id])){
				$_SESSION['stock'][$product_id]++;
			}else{
				$_SESSION['stock'][$product_id] = 1;
			}
		}

		public function del($product_id){
			unset($_SESSION['panier'][$product_id]);
			unset($_SESSION['panieru'][$product_id]);
			$_SESSION['error']=array(); //pour vider en cas d'erreur de payement
			unset($_SESSION['$quantite_rest']); //pour vider en cas de commande > au stock

			$modifprix = $this->DB->query('SELECT prix_vente, id_produit FROM modifprix where id_produit=:id', array('id'=>$_GET['delPanier']));

			if (!empty($modifprix)) {

				foreach ($modifprix as $value) {

					$this->DB->insert('UPDATE products SET prix_vente = ? WHERE id = ?', array($value->prix_vente, $value->id_produit));


				}

				$this->DB->delete('DELETE FROM modifprix WHERE id_produit= ?', array($_GET['delPanier']));
			}
		}

		public function totalfrais(){//pour le calcul des frais		
				
			$totalfrais=0;

			foreach($_SESSION['panierca'] as $product_id => $quantity){

				$totalfrais +=$_SESSION['paniercp'][$product_id];
			}
			
			return $totalfrais;
		}

		public function recalca(){
			foreach($_SESSION['panierca'] as $product_id => $quantity){
				if(isset($_POST['panierca']['quantity'][$product_id])){
					$_SESSION['panierca'][$product_id] = $_POST['panierca']['quantity'][$product_id];
				}
			}
		}

		public function recalcp(){
			foreach($_SESSION['paniercp'] as $product_id => $quantity){
				if(isset($_POST['paniercp']['quantity'][$product_id])){
					$_SESSION['paniercp'][$product_id] = $_POST['paniercp']['quantity'][$product_id];
				}
			}
		}

		

		public function delpanierc($product_id){
			unset($_SESSION['panierc'][$product_id]);
			unset($_SESSION['panierca'][$product_id]);
			unset($_SESSION['paniercp'][$product_id]);	

		}

		public function delstock($product_id){
			unset($_SESSION['stock'][$product_id]);
		}

			// Pour gerer la cloture de la caisse
		public function totalsaisie(){
			
			$totalsaisie=0;
			$products = $this->DB->query('SELECT * FROM cloture WHERE DAY(date_cloture)= :jour And MONTH(date_cloture) = :mois AND YEAR(date_cloture) = :annee', array('jour' => date("d"), 'mois' => date("m"), 'annee' => date("Y") ));

			foreach( $products as $cloture ) {

				$totalsaisie = $cloture->tot_saisie ;

			}

			return $totalsaisie;
			
		}

		public function modepBanque($type, $modep, $devise, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where typeent='{$type}' and typep='{$modep}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where typeent='{$type}' and typep='{$modep}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");
			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where typeent='{$type}' and typep='{$modep}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function modepVente($modep, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function totalFacturation($modep1, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$modep1='cheque';

				$prodch=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$modep1='cheque';

				$prodch=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}else{
				$modep1='cheque';
				
				$prodch=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$modep1='virement';

				$prodvir=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$modep1='virement';

				$prodvir=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}else{
				$modep1='virement';
				
				$prodvir=$this->DB->querys("SELECT sum(montant) as montant FROM modep inner join payement on num_cmd=numpaiep where modep='{$modep1}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			return array(($prod['montant']+$prodch['montant']+$prodvir['montant']), $prod['montant']);

		}


		public function chiffrea($date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(Total-remise) as montant FROM payement where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(Total-remise) as montant FROM payement where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}else{
				
				$prod=$this->DB->querys("SELECT sum(Total-remise) as montant FROM payement where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function resteFacturation($date1, $date2){

			$etat='credit';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(reste) as montant FROM payement where etat='{$etat}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(reste) as montant FROM payement where etat='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}else{
				
				$prod=$this->DB->querys("SELECT sum(reste) as montant FROM payement where etat='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function encaissement($modep, $type, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM versement where devisevers='{$modep}' and type_versement='{$type}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM versement where devisevers='{$modep}' and type_versement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM versement where devisevers='{$modep}' and type_versement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function encaissementDevise($modep, $type, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM devisevente where devise='{$modep}' and motif='{$type}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM devisevente where devise='{$modep}' and motif='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM devisevente where devise='{$modep}' and motif='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function encaissementCovertDevise($type, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant*taux) as montant FROM devisevente where  motif='{$type}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant*taux) as montant FROM devisevente where motif='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant*taux) as montant FROM devisevente where motif='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function liquidite($modep, $type, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$modep}' and typeent='{$type}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$modep}' and typeent='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$modep}' and typeent='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function transfertfondec($modep, $date1, $date2){
			$caisseret='autresret';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM transferfond where caisseret!='{$caisseret}' and devise='{$modep}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM transferfond where caisseret!='{$caisseret}' and devise='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM transferfond where caisseret!='{$caisseret}' and devise='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function transfertfond($modep, $date1, $date2){
			$caissedep='autresdep';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM transferfond where caissedep!='{$caissedep}' and devise='{$modep}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM transferfond where caissedep!='{$caissedep}' and devise='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM transferfond where caissedep!='{$caissedep}' and devise='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}


		public function encrecette($modep, $date1, $date2){
			$caisseret='autresret';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM recette where devisedep='{$modep}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM recette where devisedep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM recette where  devisedep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}

		public function totalEncaissement($modep, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM versement where devisevers='{$modep}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM versement where devisevers='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM versement where devisevers='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");
			}

			return $prod['montant'];

		}


		public function decaissementBil($modep, $type, $date1, $date2){

			$modepgnf='gnf';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM decaissement where devisedec='{$modep}' and payement='{$type}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodep=$this->DB->querys("SELECT sum(montant) as montant FROM decdepense where devisedep='{$modep}' and payement='{$type}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraisup=$this->DB->querys("SELECT sum(montant) as montant FROM fraisup where modep='{$modep}' and typep='{$type}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");



				$prodfraismarch=$this->DB->querys("SELECT sum(frais) as montant FROM facture where modep='{$modepgnf}' and payement='{$type}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

          		$prodfourn=$this->DB->querys("SELECT sum(montant) as montant FROM histpaiefrais where devise='{$modep}' and payement='{$type}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM decaissement where devisedec='{$modep}' and payement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodep=$this->DB->querys("SELECT sum(montant) as montant FROM decdepense where devisedep='{$modep}' and payement='{$type}'  and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraisup=$this->DB->querys("SELECT sum(montant) as montant FROM fraisup where modep='{$modep}' and typep='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraismarch=$this->DB->querys("SELECT sum(frais) as montant FROM facture where modep='{$modepgnf}' and payement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

				$prodfourn=$this->DB->querys("SELECT sum(montant) as montant FROM histpaiefrais where devise='{$modep}' and payement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM decaissement where devisedec='{$modep}' and payement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodep=$this->DB->querys("SELECT sum(montant) as montant FROM decdepense where devisedep='{$modep}' and payement='{$type}'  and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraisup=$this->DB->querys("SELECT sum(montant) as montant FROM fraisup where modep='{$modep}' and typep='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraismarch=$this->DB->querys("SELECT sum(frais) as montant FROM facture where modep='{$modepgnf}' and payement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

				$prodfourn=$this->DB->querys("SELECT sum(montant) as montant FROM histpaiefrais where devise='{$modep}' and payement='{$type}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			if ($modep=='gnf') {
				return ($prod['montant']+$prodep['montant']+$prodfraisup['montant']+$prodfraismarch['montant']+$prodfourn['montant']);
			}else{
				return ($prod['montant']+$prodep['montant']+$prodfraisup['montant']+$prodfourn['montant']);
			}

			

		}

		

		public function totalDecaissementBil($modep, $date1, $date2){

			$modepgnf='gnf';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM decaissement where devisedec='{$modep}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodep=$this->DB->querys("SELECT sum(montant) as montant FROM decdepense where devisedep='{$modep}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraisup=$this->DB->querys("SELECT sum(montant) as montant FROM fraisup where modep='{$modep}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraismarch=$this->DB->querys("SELECT sum(frais) as montant FROM facture where modep='{$modepgnf}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

          		$prodfourn=$this->DB->querys("SELECT sum(montant) as montant FROM histpaiefrais where devise='{$modep}'  and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM decaissement where devisedec='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodep=$this->DB->querys("SELECT sum(montant) as montant FROM decdepense where devisedep='{$modep}'  and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraisup=$this->DB->querys("SELECT sum(montant) as montant FROM fraisup where modep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraismarch=$this->DB->querys("SELECT sum(frais) as montant FROM facture where modep='{$modepgnf}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

				$prodfourn=$this->DB->querys("SELECT sum(montant) as montant FROM histpaiefrais where devise='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");

			}else{
				
				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM decaissement where devisedec='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodep=$this->DB->querys("SELECT sum(montant) as montant FROM decdepense where devisedep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraisup=$this->DB->querys("SELECT sum(montant) as montant FROM fraisup where modep='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$date2}'");

				$prodfraismarch=$this->DB->querys("SELECT sum(frais) as montant FROM facture where modep='{$modepgnf}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$date2}'");

				$prodfourn=$this->DB->querys("SELECT sum(montant) as montant FROM histpaiefrais where devise='{$modep}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}'");
			}

			if ($modep=='gnf') {
				return ($prod['montant']+$prodep['montant']+$prodfraisup['montant']+$prodfraismarch['montant']+$prodfourn['montant']);
			}else{
				return ($prod['montant']+$prodep['montant']+$prodfraisup['montant']+$prodfourn['montant']);
			}

			

		}


		public function nomBanque(){// Permet de recuperer un evenement
			

			if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

	        	$prod=$this->DB->query("SELECT nomb, id, numero, type FROM nombanque where lieuvente='{$_SESSION['lieuvente']}' order by(id)");
	        }else{
				$prod=$this->DB->query("SELECT nomb, id, numero, type FROM nombanque order by(id)");
			}

			return $prod;

		}

		public function nomBanqueBilan(){// Permet de recuperer un evenement

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->query("SELECT nomb, id, numero, type FROM nombanque order by(id)");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->query("SELECT nomb, id, numero, type FROM nombanque where lieuvente='{$_SESSION['lieuvente']}' order by(id)");
			}else{

				$prod=$this->DB->query("SELECT nomb, id, numero, type FROM nombanque where lieuvente='{$_SESSION['lieuvente']}' order by(id)");

			}

			return $prod;

		}

		

		public function lieuVenteCaisse($caisse){// Permet de recuperer un evenement

	        $prod=$this->DB->querys("SELECT nomb, id, numero, lieuvente, type FROM nombanque where id='{$caisse}'");
	        
			return array($prod['lieuvente'], $prod['type']);

		}

		public function idCaisse($lieuvente){// Permet de recuperer un evenement

	        $prod=$this->DB->querys("SELECT nomb, id, numero, type FROM nombanque where lieuvente='{$lieuvente}'");
	        
			return array($prod['id'], $prod['type']);

		}

		public function nomBanqueCaisse(){// Permet de recuperer un evenement

			if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {
	        	$prod=$this->DB->query("SELECT nomb, id, numero FROM nombanque where lieuvente='{$_SESSION['lieuvente']}' order by(id)");
	        }else{
				$prod=$this->DB->query("SELECT nomb, id, numero FROM nombanque order by(id)");
			}

			

			return $prod;

		}

		public function nomBanqueCaissePrincipal($lieuvente, $type){// Permet de recuperer un evenement

	        $prod=$this->DB->querys("SELECT nomb, id, numero FROM nombanque where lieuvente='{$lieuvente}' and type='{$type}'");
	        
			return $prod['id'];

		}

		public function nomBanqueCaisseFiltre(){// Permet de recuperer un evenement
			$banque='caisse';

			if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {
	        	$prod=$this->DB->query("SELECT nomb, id, numero FROM nombanque where type='{$banque}' and lieuvente='{$_SESSION['lieuvente']}' order by(id)");
	        }else{
				$prod=$this->DB->query("SELECT nomb, id, numero FROM nombanque where type='{$banque}' order by(id)");
			}

			

			return $prod;

		}

		public function nomBanqueVire(){// Permet de recuperer un evenement
			$banque='banque';

			if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {
				$prod=$this->DB->query("SELECT nomb, id, numero FROM nombanque where type='{$banque}' ");
	        }else{
				$prod=$this->DB->query("SELECT nomb, id, numero FROM nombanque where type='{$banque}'");
			}

			

			return $prod;

		}

		public function nomBanquefecth($banque){

			$prod=$this->DB->querys("SELECT nomb FROM nombanque where id='{$banque}' ");

			return $prod['nomb'];

		}

		public function montantCompte($banque){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' ");
			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where lieuvente='{$_SESSION['lieuvente']}' and id_banque='{$banque}' ");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where lieuvente='{$_SESSION['lieuvente']}' and id_banque='{$banque}' ");

			}

			return $prod['montant'];

		}

		public function montantCompteInvent($banque){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque inner join nombanque on nombanque.id=id_banque where nombanque.type='{$banque}' ");
			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque inner join nombanque on nombanque.id=id_banque where lieuvente='{$_SESSION['lieuvente']}' and nombanque.type='{$banque}' ");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque inner join nombanque on nombanque.id=id_banque where nombanque.type='{$banque}' ");

			}

			return $prod['montant'];

		}

		public function montantCompteBanqueInvent($banque){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque inner join nombanque on nombanque.id=id_banque where nombanque.type='{$banque}' ");
			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque inner join nombanque on nombanque.id=id_banque where banque.lieuvente='{$_SESSION['lieuvente']}' and nombanque.type='{$banque}' ");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque inner join nombanque on nombanque.id=id_banque where nombanque.type='{$banque}'");

			}

			return $prod['montant'];

		}

		public function montantCompteBil($banque, $devise){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}'");
				
			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' ");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' ");

			}

			return $prod['montant'];

		}

		public function montantCompteBilCheque($banque, $devise){

			$cheque='cheque';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}'");
			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and lieuvente='{$_SESSION['lieuvente']}' ");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and lieuvente='{$_SESSION['lieuvente']}' ");

			}

			return $prod['montant'];

		}

		public function caisseJour($banque, $devise, $date1, $date2){

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

				$prodchequedepasse=$this->DB->querys("SELECT sum(montant) as montant, id_banque FROM chequedepasse where id_banque='{$banque}'  and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}' ");

				$prodchequedepasse=$this->DB->querys("SELECT sum(montant) as montant, id_banque FROM chequedepasse where id_banque='{$banque}' and lieuvente='{$_SESSION['lieuvente']}'  and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}' ");

				$prodchequedepasse=$this->DB->querys("SELECT sum(montant) as montant, id_banque FROM chequedepasse where id_banque='{$banque}' and lieuvente='{$_SESSION['lieuvente']}'  and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}

			if ($this->lieuVenteCaisse($prodchequedepasse['id_banque'])[1]=='caisse') {
				if ($devise=='gnf') {
					return($prod['montant']+$prodchequedepasse['montant']);
				}else{
					return($prod['montant']);
				}
				
			}else{

				return $prod['montant'];
			}

		}

		public function caisseJourCheque($banque, $devise, $date1, $date2){
			$cheque='cheque';

			if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}'  and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}'");

				$prodchequedepasse=$this->DB->querys("SELECT sum(montant) as montant FROM chequedepasse where id_banque='{$banque}'  and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}' ");

				$prodchequedepasse=$this->DB->querys("SELECT sum(montant) as montant FROM chequedepasse where id_banque='{$banque}' and lieuvente='{$_SESSION['lieuvente']}'  and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");
			}else{

				$prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$date2}' ");

				$prodchequedepasse=$this->DB->querys("SELECT sum(montant) as montant FROM chequedepasse where id_banque='{$banque}' and lieuvente='{$_SESSION['lieuvente']}'  and DATE_FORMAT(dateop, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(dateop, \"%Y%m%d\") <= '{$date2}'");

			}

			return ($prod['montant']+$prodchequedepasse['montant']);

		}

		
		public function soldeBanque(){

			$banque=1;

			$prodnbre =$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque!='{$banque}'");

			return ($prodnbre['montant']);
		}

		public function soldeBanqueU($param){

			$prodnbre =$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$param}'");

			return ($prodnbre['montant']);
		}

		// Total disponible en caisse

		public function totalcaisse(){

			$totalcaisse=0;
			$now = date('Y-m-d');
		      $now = new DateTime( $now );
		      $now = $now->format('Ymd');

		      $prodenc=$this->DB->querys('SELECT SUM(Total) AS totp, SUM(remise) AS remp, sum(fraisup) as frais, mode_payement FROM payement WHERE DATE_FORMAT(date_cmd, \'%Y%m%d\')<= :NOW ', array(
		        'NOW' => $now
		      ));

		       $totenc=($prodenc['totp']-$prodenc['remp']-$prodenc['frais']);
		       

		      $reste_payer=$this->DB->querys('SELECT SUM(Total) AS totpc, SUM(remise) AS rempc, SUM(montantpaye) AS montpc, SUM(reste) AS respc, mode_payement FROM payement WHERE DATE_FORMAT(date_cmd, \'%Y%m%d\')<= :NOW AND etat= :Etat ', array(
		        'NOW' => $now,
		        'Etat'=>'credit'
		      ));    
		      $credclient_gnf=$reste_payer['respc'];

		      $decumul =$this->DB->querys('SELECT SUM(montant) AS montdg FROM decaissement WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW and cprelever!=:compte', array('NOW' => $now, 'compte'=>36));

		      $decdepcumul =$this->DB->querys('SELECT SUM(montant) AS montdg FROM decdepense WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW and cprelever!=:compte', array('NOW' => $now, 'compte'=>36));

		      $decloycumul =$this->DB->querys('SELECT SUM(montant) AS montdg FROM decloyer WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW and cprelever!=:compte', array('NOW' => $now, 'compte'=>36));

		      $decperscumul =$this->DB->querys('SELECT SUM(montant) AS montdg FROM decpersonnel WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW and cprelever!=:compte', array('NOW' => $now, 'compte'=>36));

		      $frais =$this->DB->querys('SELECT SUM(frais) as frais, sum(montantpaye) AS montf FROM facture WHERE DATE_FORMAT(datecmd, \'%Y%m%d\')<= :NOW ', array('NOW' => $now));

		      //$fraisup =$DB->querys('SELECT SUM(montant) AS montfsup FROM fraisup WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW', array('NOW' => $now));

		      $montdec_gnf=$decumul['montdg']+$decdepcumul['montdg']+$decloycumul['montdg']+$decperscumul['montdg']+($frais['montf']+$frais['frais']);

		      

		      $date1=$now;
		      if (!empty($this->montantCloture($date1))) {
		        $totalcaisse=$this->montantCloture($date1);
		      }else{
		        $totalcaisse=($totenc-$credclient_gnf+$this->versementgnf()-$montdec_gnf)+ ($this->manque());
		      }

					return $totalcaisse;			
				}


			public function fondCaisse(){

				$prodnbre =$this->DB->querys("SELECT sum(montant) as montant FROM banque");

				return ($this->totalcaisse());
			}

			#**************GESTION DE LA LICENCE*****************************

			public function licence(){
				
				$licence="";

				$products = $this->DB->queryI('SELECT num_licence, DATE_FORMAT(date_souscription, \'%d/%m/%Y\') AS debut, DATE_FORMAT(date_fin, \'%d/%m/%Y\') AS datefin, date_fin AS fin FROM licence');

		        foreach ( $products as $product ):?>

		       	<?php endforeach; ?>

		       	<?php
		       	$now = date('Y-m-d');
		       	$datefin = $product->fin;

		       	$now = new DateTime( $now );
		       	$now = $now->format('Ymd');
		       	$datefin = new DateTime( $datefin );
		       	$datefin = $datefin->format('Ymd');

		       	if ($now >= $datefin) {

		       		$licence="expiree";

		       	}else{

		       		$licence="ok";
		       	}

				return $licence;
				
			}

		

		public function manque(){
			
			$manque=0;


			$products = $this->DB->query('SELECT SUM(difference) AS diff FROM cloture');

			foreach( $products as $cloture ) {

				$manque = $cloture->diff;

			}

			return $manque;
			
		}

		public function versementgnf(){
			
			$versementgnf=0;
			

			$products = $this->DB->query('SELECT SUM(montant) AS sommeverse, date_versement FROM versement where comptedep!=:compte', array('compte'=>36));

			foreach( $products as $versement ) {

				$versementgnf = $versement->sommeverse ;

			}

			return $versementgnf;
			
		}

		public function soldegnf(){
			
			$soldegnf=0;

	        $products= $this->DB->query('SELECT montant FROM bulletin where nom_client!=:nom', array('nom'=>'DMS'));
	         

	        foreach ($products as $product ){

	            $soldegnf+=$product->montant; 

	        }

			return $soldegnf;
			
		}


		public function soldecgnf(){
			
			$sommeachatfournisseur=0;

	        $products = $this->DB->query('SELECT SUM(montant) AS montant, SUM(prix_reel) AS prix FROM decaissement WHERE motif=:MOTIF', array('MOTIF' => "achat fournisseur"));        

	        foreach ($products as $product ){

	        	$sommeachatfournisseur=-($product->prix-$product->montant);        		

	        }

	        $sommedeclientgnf=0;
	        $decaissementclient = $this->DB->query('SELECT SUM(montant) AS montant FROM decaissement WHERE motif=:MOTIF', array('MOTIF' => "decaissement client"));        

	        foreach ($decaissementclient as $product ){

	        	$sommedeclientgnf=($product->montant);        		

	        }

			return ($sommeachatfournisseur+$sommedeclientgnf);
			
		}
	# FONCTION POUR CALCULER LES CREANCES DU MAGASIN
		public function creditfm(){
			
			$creditfm=0;
			$Etat="credit";
			$type="VIP";
			$products = $this->DB->query('SELECT montant, prix_reel, typeclient FROM decaissement WHERE etat=:ETAT', array('ETAT' => $Etat));
	         

	        foreach ($products as $product ){

	            if ($product->typeclient!="VIP") {

	                $creditfm+=($product->prix_reel-$product->montant);
	            }

	        }

	        $soldegnf=0;

	        $products= $this->DB->query('SELECT SUM(montant)AS montant FROM bulletin where nom_client!=:nom', array('nom'=>'DMS'));
	         

	        foreach ($products as $productb ){

	        	if ($productb->montant>0) {
	        		
	            	$soldegnf=$productb->montant;
	            }else{

	            	$soldegnf=0;

	            }

	        }

			return $creditfm+$soldegnf;
			
		}

		public function credits(){
			
			$credit_client=0;
			$Etat="credit";
			$soldegnf=0;
			if (isset($_POST['mensuelle']) or isset($_GET['mensuelle'])) {

				$product = $this->DB->querys('SELECT sum(reste) as reste FROM payement WHERE etat=:ETAT AND DATE_FORMAT(date_cmd, \'%m/%Y\') = :ANNEE', array('ETAT' => $Etat,'ANNEE'=>$_SESSION['date']));

				$productb= $this->DB->querys('SELECT SUM(montant)AS montant FROM bulletin WHERE DATE_FORMAT(date_versement, \'%m/%Y\') = :ANNEE', array('ANNEE' => $_SESSION['date']));

			}else{

				$product = $this->DB->querys('SELECT sum(reste) as reste FROM payement WHERE etat=:ETAT AND YEAR(date_cmd) = :ANNEE', array('ETAT' => $Etat, 'ANNEE'=>$_SESSION['date']));

	      		$productb= $this->DB->querys('SELECT SUM(montant)AS montant FROM bulletin WHERE YEAR(date_versement) = :ANNEE', array('ANNEE' => $_SESSION['date']));
			}

	    	$credit_client=($product['reste']);

	      	if ($productb['montant']>0) {
	      		
	          $soldegnf=0;

	        }else{

	        	$soldegnf=$productb['montant'];
	        }

			return $credit_client;
		
		}

		public function creditfs(){
			
			$creditfs=0;
			$Etat="credit";
			$type="VIP";
			$soldegnf=0;

			if (isset($_POST['mensuelle']) or isset($_GET['mensuelle'])) {

		    	$productb= $this->DB->querys('SELECT SUM(montant)AS montant FROM bulletin WHERE DATE_FORMAT(date_versement, \'%m/%Y\') = :ANNEE', array('ANNEE' => $_SESSION['date']));

		    	$productf = $DB->querys('SELECT  sum(montantht+montantva-montantpaye) FROM facture  WHERE YEAR(datecmd) = :annee ORDER BY(montantpaye) DESC', array('annee'=> $_SESSION['date']));

		    }else{

		      $productb= $this->DB->querys('SELECT SUM(montant)AS montant FROM bulletin WHERE YEAR(date_versement) = :ANNEE', array('ANNEE' => $_SESSION['date']));

		      $productf = $this->DB->querys('SELECT  sum(montantht+montantva-montantpaye) as reste FROM facture  WHERE YEAR(datecmd) = :annee ORDER BY(montantpaye) DESC', array('annee'=> $_SESSION['date']));
		    }

	    	if ($productb['montant']>0) {
	    		
		      	$soldegnf=$productb['montant'];

	      	}else{

	      		$soldegnf=0;

	      	}

			return $productf['reste'];			
		}

		public function soldecredit(){
			$etat='credit';

			$prodsolde=$this->DB->querys('SELECT sum(montant) as montant FROM bulletin WHERE DATE_FORMAT(date_versement, \'%Y\') = :ANNEE', array('ANNEE' => $_SESSION['date']));

			//$product = $this->DB->querys('SELECT sum(reste) as reste FROM payement WHERE etat=:ETAT AND typeclient!=:TYPE AND YEAR(date_cmd) = :ANNEE', array('ETAT' => $etat, 'TYPE'=>"VIP", 'ANNEE'=>$_SESSION['date']));
			$product['reste']=0;

			if ($prodsolde['montant']>0) {
				$solde=-$prodsolde['montant'];
			}else{

				$solde=$prodsolde['montant'];

			}

			return $solde+$product['reste'];			
		}

		

		public function totdepense($date1){//permet de recuperer le prix total des depenses

			$prodnbre =$this->DB->querys("SELECT sum(montant) as tot FROM decdepense WHERE DATE_FORMAT(date_payement, \"%Y\")='{$date1}'");

			return ($prodnbre['tot']);
		}

		


	    // solde client

	    
	    public function soldeclient(){
	    	$solde=0;
        	$prod =$this->DB->querys('SELECT sum(montant) as montant FROM bulletin WHERE nom_client= :CLIENT',array(
            'CLIENT' => $_SESSION['nameclient']));

	        $solde=$prod['montant'];

	        return $solde;
	    }

	    public function soldeclientgen($nom,$devise){
	    	$solde=0;
        	$prod =$this->DB->querys("SELECT sum(montant) as montant FROM bulletin WHERE nom_client='{$nom}' and devise='{$devise}'");

	        $solde=$prod['montant'];

	        return $solde;
	    }

		
		// Sauvegarde de la base de donnée

		public function dumpMySQL($serveur, $login, $password, $base, $mode){
		    $connexion = mysql_connect($serveur, $login, $password);
		    mysql_select_db($base, $connexion);
		 
		    $entete = "-- ----------------------\n";
		    $entete .= "-- dump de la base ".$base." au ".date("d-M-Y")."\n";
		    $entete .= "-- ----------------------\n\n\n";
		    $creations = "";
		    $insertions = "\n\n";
		 
		    $listeTables = mysql_query("show tables", $connexion);
		    while($table = mysql_fetch_array($listeTables))
		    {
		        // si l'utilisateur a demandé la structure ou la totale
		        if($mode == 1 || $mode == 3)
		        {
		            
		            $listeCreationsTables = mysql_query("show create table ".$table[0], $connexion);
		            while($creationTable = mysql_fetch_array($listeCreationsTables))
		            {
		              $creations .= $creationTable[1].";\n\n";
		            }
		        }
		        // si l'utilisateur a demandé les données ou la totale
		        if($mode > 1)
		        {
		            $donnees = mysql_query("SELECT * FROM ".$table[0]);
		            while($nuplet = mysql_fetch_array($donnees))
		            {
		                $insertions .= "INSERT INTO ".$table[0]." VALUES(";
		                for($i=0; $i < mysql_num_fields($donnees); $i++)
		                {
		                  if($i != 0)
		                     $insertions .=  ", ";
		                  if(mysql_field_type($donnees, $i) == "string" OR mysql_field_type($donnees, $i) == "datetime" OR mysql_field_type($donnees, $i) == "date" || mysql_field_type($donnees, $i) == "blob")
		                     $insertions .=  "'";
		                  $insertions .= addslashes($nuplet[$i]);
		                  if(mysql_field_type($donnees, $i) == "string" OR mysql_field_type($donnees, $i) == "datetime" OR mysql_field_type($donnees, $i) == "date" || mysql_field_type($donnees, $i) == "blob")
		                    $insertions .=  "'";
		                }
		                $insertions .=  ");\n";
		            }
		            $insertions .= "\n";
		        }
		    }
		 
		    mysql_close($connexion);
		 
		    $fichierDump = fopen("export.sql", "wb");
		    fwrite($fichierDump, $entete);
		    fwrite($fichierDump, $creations);
		    fwrite($fichierDump, $insertions);
		    fclose($fichierDump);
		}
	}