<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etape;
use App\Models\Coureur;
use App\Models\Etape_coureur;
use App\Models\ImportEtape;
use App\Models\ImportResultat;
use App\Models\ImportPoint;
use App\Models\Resultat;
use App\Models\Equipe;
use App\Models\Point;
use App\Models\Penalite;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Dompdf\Dompdf;
use Dompdf\Options;




class AdminController extends Controller
{
    //
    public function homeAdmin(){return view('homeAdmin');}




    public function liste_etape(){
        $etapes=Etape::all();

        return  view('admin.liste_etape',['etapes'=>$etapes]);
    }



    public function maj_temps_coureur(Request $request){
        $id_etape = $request->id_etape;
        $coureurs = DB::table('v_coureur_etape')->where('id_etape', $id_etape)->get();
    
        return view('admin.update_temps_coureur', ['coureurs' => $coureurs,'id_etape' => $id_etape]);
    }
    

    public function update_temps_coureur(Request $request){
        $data = $request->validate([
            'temps' => 'required|array',
            'temps.*' => ['nullable', 'regex:/^(?:[01]\d|2[0-3]):(?:[0-5]\d):(?:[0-5]\d)\.\d{3}$/']
            //'temps.*' => 'nullable|regex:/^\d{2}:\d{2}:\d{2}\.\d{3}$/'
        ]);
    

        foreach ($data['temps'] as $id_coureur => $temps) {
            
            Etape_coureur::where('id_etape', $request->id_etape)
                         ->where('id_coureur', $id_coureur)
                         ->update(['temps' => $temps ]);
            
        }

        return redirect()->route('admin.liste_etape');
    }



    public function liste_coureur_classement(){
        $classement_coureurs=DB::select("select * from v_classement_coureurs");
        $i=1;
        return  view('admin.liste_coureur_classement',['classement_coureurs'=>$classement_coureurs,'i'=>$i]);
    }


    public function liste_equipe_classement() {
        
        $classement_equipes=DB::select("select * from v_classement_equipes");
        $i=1;
         // Préparation des données pour le graphique en camembert
        $labels = [];
        $points = [];
        foreach ($classement_equipes as $equipe) {
            $labels[] = $equipe->nom;
            $points[] = $equipe->sum;
        }

        return view('admin.liste_equipe_classement', [
            'classement_equipes' => $classement_equipes,
            'labels' => $labels,
            'points' => $points,
            'i'=>$i
        ]);
    }
    
    

    public function v_imporationCSV_etape_resultat(){
        return view('admin.v_imporationCSV_etape_resultat');
    }



    protected function convertDecimalFormat($value){
        return str_replace(',', '.', $value);
    }
    
    
    
    
    function isValidDataTypeEtape($value, $columnIndex) {
        switch ($columnIndex) {
            case 0: //etape
                if (!is_string($value)) {
                    return false;
                }
                break;
    
            case 1: // longueur
                $value = $this->convertDecimalFormat($value);
                if (!is_numeric($value)) {
                    return false;
                }
                break;
    
            case 2: // nbcoureur
            case 3: // rang
                if (!is_int($value) && !ctype_digit($value)) { // ctype_digit vérifie les strings numériques
                    return false;
                }
                break;
    
            case 4: // date depart
                $date = \DateTime::createFromFormat('d/m/Y', $value);
                if (!$date || $date->format('d/m/Y') !== $value) {
                    return false;
                }
                break;
    
            case 5: // heure depart
                $timestamp = strtotime($value);
                if ($timestamp === false || date('H:i:s', $timestamp) !== $value) {
                    return false;
                }
                break;
    
            default:
                return false;
        }
    
        return true;
    }




    public function importEtape(UploadedFile $file){
        $errors = [];
    
        if ($file) {
            
            // Vérifiez si le fichier est valide, par exemple, s'il s'agit d'un fichier CSV
            if ($file->getClientOriginalExtension() === 'csv') {
                $delimiter = ',';
                $fileContents = file($file->getPathname());
    
                $firstLine = true;
                foreach ($fileContents as $lineNumber => $line) {
                    if ($firstLine) {
                        $firstLine = false;
                        continue; // Passer à la prochaine itération sans traiter la première ligne
                    }
                    
                    $data = str_getcsv($line, $delimiter);
    
                    // Vérifier si le nombre de colonnes est correct
                    if (count($data) !== 6 || in_array('', $data)) {
                        $errors[] = "Ligne $lineNumber : Le nombre de colonnes est incorrect.";
                        continue; // Passer à la prochaine itération
                    }
    
                    // Trim des données
                    $trimmedData = array_map('trim', $data);
    
                    // Vérifier les erreurs spécifiques aux données
                    $rowData = [];
                    foreach ($trimmedData as $columnIndex => $value) {
                        if (!$this->isValidDataTypeEtape($value, $columnIndex)) {
                            $errors[] = "Ligne $lineNumber, Colonne $columnIndex : Type de données invalide.";
                            continue 2; // Passer à la prochaine ligne
                        }
                        $rowData[$columnIndex] = $value;
                    }                    
                    
                    try {
    
    //------------------------------------------------------------------------------
                        ImportEtape::create([
                            'nom' => $rowData[0],
                            'longueur' => str_replace(',', '.', $rowData[1]),
                            'nbr_coureur' => $rowData[2],
                            'rang' => $rowData[3],
                            'date_depart' => $rowData[4],
                            'heure_depart' => $rowData[5],
                        ]);
    
                $longueur = str_replace(',', '.', $rowData[1]);
                            $longueurDecimal = (float) $longueur;
    
    
                // Vérifier si etape existe -------------------------------------------------------------------
                            $existingEtape = Etape::where('nom', $rowData[0])
                                                    ->where('longueur', $longueurDecimal)
                                                    ->where('nbr_coureur', $rowData[2])
                                                    ->where('rang', $rowData[3])
                                                    ->first();
    
                            if (!$existingEtape) {
                                $etape = Etape::create([
                                    'nom' => $rowData[0],
                                    'longueur' => $longueurDecimal,
                                    'nbr_coureur' => $rowData[2],
                                    'rang' => $rowData[3],
                                ]);
                            }else {
                                $etape = $existingEtape;
                            }
    
                $etapeId = $etape->id;
    

    
                // Vérifier si existe dans etape_coureurs ---------------------------------------------------------
                 $existingEtapeCoureur = Etape_coureur::where('id_etape', $etapeId)
                                                    ->where('date_depart', $rowData[4])
                                                    ->where('heure_depart', $rowData[5])
                                                    ->first();
    
                            if (!$existingEtapeCoureur) {
                                $etape_coureur = Etape_coureur::create([
                                    'id_etape' => $etapeId,
                                    'date_depart' => $rowData[4],
                                    'heure_depart' => $rowData[5],
                                ]);
                            }else {
                                $etape_coureur = $existingEtapeCoureur;
                            }
                
        
      //------------------------------------------------------------------------------
                          
                    } catch (\Exception $e) {
                        $errors[] = "Ligne $lineNumber : Erreur lors de l'insertion dans la base de données - " . $e->getMessage();
                        dd($e->getMessage());
                    }
                }
                return $errors;
            } else {
                $errors[] = "Le fichier doit être au format CSV.";
                return $errors;
            }
        } else {
            $errors[] = "Aucun fichier n'a été sélectionné.";
            return $errors;
        }
    }
    
    
    
    
    



    function isValidDataTypeResultat($value, $columnIndex) {
        switch ($columnIndex) {
            case 0: //etape_rang
            case 1: //num_dossard
                if (!is_int($value) && !ctype_digit($value)) { // ctype_digit vérifie les strings numériques
                    return false;
                }
                break;
    
            case 2: // nom
            case 3: // genre
            case 5: // genre
                if (!is_string($value)) {
                    return false;
                }
                break;
    
            case 4: // date de naissance
                $date = \DateTime::createFromFormat('d/m/Y', $value);
                if (!$date || $date->format('d/m/Y') !== $value) {
                    return false;
                }
                break;
    
            case 6: // arrivee
                $dateTime = \DateTime::createFromFormat('d/m/Y H:i:s', $value);
                if (!$dateTime || $dateTime->format('d/m/Y H:i:s') !== $value) {
                    return false;
                }
                break;
    
            default:
                return false;
        }
    
        return true;
    }

    



    
public function importResultat(UploadedFile $file){
    $errors = [];

    if ($file) {
        //$file = $request->file('file');
        
        // Vérifiez si le fichier est valide, par exemple, s'il s'agit d'un fichier CSV
        if ($file->getClientOriginalExtension() === 'csv') {
            $delimiter = ',';
            $fileContents = file($file->getPathname());

            $firstLine = true;
            foreach ($fileContents as $lineNumber => $line) {
                if ($firstLine) {
                    $firstLine = false;
                    continue; // Passer à la prochaine itération sans traiter la première ligne
                }
                
                $data = str_getcsv($line, $delimiter);

                // Vérifier si le nombre de colonnes est correct
                if (count($data) !== 7 || in_array('', $data)) {
                    $errors[] = "Ligne $lineNumber : Le nombre de colonnes est incorrect.";
                    continue; // Passer à la prochaine itération
                }

                // Trim des données
                $trimmedData = array_map('trim', $data);

                // Vérifier les erreurs spécifiques aux données
                $rowData = [];
                foreach ($trimmedData as $columnIndex => $value) {
                    if (!$this->isValidDataTypeResultat($value, $columnIndex)) {
                        $errors[] = "Ligne $lineNumber, Colonne $columnIndex : Type de données invalide.";
                        continue 2; // Passer à la prochaine ligne
                    }
                    $rowData[$columnIndex] = $value;
                }                    
                
                try {
                    ImportResultat::create([
                        'etape_rang' => $rowData[0],
                        'num_dossard' => $rowData[1],
                        'coureur_nom' => $rowData[2],
                        'genre' => $rowData[3],
                        'ddn' => $rowData[4],
                        'equipe_nom' => $rowData[5],
                        'arrivee' => $rowData[6],
                    ]);

		$etape = Etape::where('rang', $rowData[0])->first();

   		 $etapeId = $etape->id;
		
//------------------------------------------------------------------------------
			
		// Vérifier si existe dans Equipe ---------------------------------------------------------
			 $existingEquipe =Equipe::where('nom', $rowData[5])
                                     ->first();

                        if (!$existingEquipe) {
                            $equipe =  Equipe::create([
			                    'nom'=> $rowData[5],
                                'email'=>$rowData[5],
                                'password'=>\Hash::make($rowData[5]),
                            ]);
                        }else {
                            $equipe = $existingEquipe;
                        }
		

		// Vérifier si existe dans Coureurs ---------------------------------------------------------
			 $existingCoureur = Coureur::where('num_dossard', $rowData[1])
                                        ->where('nom', $rowData[2])
                                        ->where('genre', $rowData[3])
                                        ->where('ddn', $rowData[4])
                                        ->where('id_equipe', $equipe->id)
                                        ->first();

                        if (!$existingCoureur) {
                            $coureur = Coureur::create([
                                'num_dossard'=>$rowData[1],
                                'nom'=> $rowData[2],
                                'genre'=> $rowData[3],
                                'ddn'=> $rowData[4],
                                'id_equipe'=> $equipe->id,

                            ]);
                        }else {
                            $coureur = $existingCoureur;
                        }

		


		// Vérifier si existe dans Etape_coureurs ---------------------------------------------------------
			 $existingEtapeCoureur = Etape_coureur::where('id_etape', $etapeId)
						                            ->where('id_coureur', $coureur->id)
						                            ->where('arriver', $rowData[6])
                                                    ->first();

                        if (!$existingEtapeCoureur) {
                            $etape_coureur =  Etape_coureur::create([
                                'id_etape'=>$etapeId,
				                'id_coureur'=> $coureur->id,
			                    'arriver'=> $rowData[6],
                            ]);
                        }else {
                            $etape_coureur = $existingEtapeCoureur;
                        }


//------------------------------------------------------------------------------

                } catch (\Exception $e) {
                    $errors[] = "Ligne $lineNumber : Erreur lors de l'insertion dans la base de données - " . $e->getMessage();
                    dd($e->getMessage());
                }
            }
            return $errors;
        } else {
            $errors[] = "Le fichier doit être au format CSV.";
            return $errors;
       }
    } else {
        $errors[] = "Aucun fichier n'a été sélectionné.";
        return $errors;
    }
}





public function importCSVEtapeResultat(Request $request){
    $errors = [];

    // Appel à la fonction importEtape
    $etapeErrors = $this->importEtape($request->file('file'));
    if ($etapeErrors) {
        $errors = array_merge($errors, $etapeErrors);
    }

    // Appel à la fonction importResultat
    $resultatErrors = $this->importResultat($request->file('file2'));
    if ($resultatErrors) {
        $errors = array_merge($errors, $resultatErrors);
    }

    // Si des erreurs sont présentes, redirigez avec les erreurs
    if (!empty($errors)) {
        $messageBag = new MessageBag($errors);
        return redirect()->route('admin.v_imporationCSV_etape_resultat')->with('errors', $messageBag);
    }

    // Si aucune erreur n'est présente, vous pouvez rediriger avec un message de succès
    return redirect()->route('admin.v_imporationCSV_etape_resultat')->with('success', 'Fichiers CSV importés avec succès.');

}





public function v_importationCSV_point(){ return view('admin.v_importationCSV_point');}
    
        

public function isValidDataTypePoint($value, $columnIndex) {
    switch ($columnIndex) {
        case 0: //classement
        case 1: //point
            if (!is_int($value) && !ctype_digit($value)) { // ctype_digit vérifie les strings numériques
                return false;
            }
            break;

        default:
            return false;
    }
    return true;
}




public function importCSVPoint(Request $request)
{
    $errors = [];

    $file = $request->file('file');
    if ($file) {
        // Vérifiez si le fichier est valide, par exemple, s'il s'agit d'un fichier CSV
        if ($file->getClientOriginalExtension() === 'csv') {
            $delimiter = ',';
            $fileContents = file($file->getPathname());

            $firstLine = true;
            foreach ($fileContents as $lineNumber => $line) {
                if ($firstLine) {
                    $firstLine = false;
                    continue; // Passer à la prochaine itération sans traiter la première ligne
                }

                $data = str_getcsv($line, $delimiter);

                // Vérifier si le nombre de colonnes est correct
                if (count($data) !== 2 || in_array('', $data)) {
                    $errors[] = "Ligne $lineNumber : Le nombre de colonnes est incorrect.";
                    continue; // Passer à la prochaine itération
                }

                // Trim des données
                $trimmedData = array_map('trim', $data);

                // Vérifier les erreurs spécifiques aux données
                $rowData = [];
                foreach ($trimmedData as $columnIndex => $value) {
                    if (!$this->isValidDataTypePoint($value, $columnIndex)) {
                        $errors[] = "Ligne $lineNumber, Colonne $columnIndex : Type de données invalide.";
                        continue 2; // Passer à la prochaine ligne
                    }
                    $rowData[$columnIndex] = $value;
                }

                try {
                    // Insertion dans ImportPoint
                    ImportPoint::create([
                        'classement' => $rowData[0],
                        'point' => $rowData[1],
                    ]);

                    // Vérifier si existe dans Point
                    $existingPoint = Point::where('classement', $rowData[0])
                        ->where('point', $rowData[1])
                        ->first();

                    if (!$existingPoint) {
                        Point::create([
                            'classement' => $rowData[0],
                            'point' => $rowData[1],
                        ]);
                    }

                } catch (\Exception $e) {
                    $errors[] = "Ligne $lineNumber : Erreur lors de l'insertion dans la base de données - " . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                return redirect()->back(); // Si des erreurs sont présentes, redirigez simplement sans afficher les erreurs
            }

            return redirect()->route('admin.v_importationCSV_point')->with('success', 'Importation réussie.');
        } else {
            return redirect()->back(); // Redirection si le fichier n'est pas un CSV
        }
    } else {
        return redirect()->back(); // Redirection si aucun fichier n'est sélectionné
    }
}



    public function v_generer_categorie(){return view('admin.v_generer_categorie');}

    public function generer_categorie(){
        DB::unprepared('CALL assigner_categorie()');
        return redirect()->route('admin.v_generer_categorie')->with('success', 'Catégories assignées avec succès.');
    }



    public function liste_categorie_general_classement(){
        $i=1;
        $nomCategories=DB::select("select nom from categories");
        $classement_categories=DB::select("select * from v_classement_equipes_categories;");

          // Préparation des données pour le graphique en camembert
          $labels = [];
          $points = [];
          foreach ($classement_categories as $equipe) {
              $labels[] = $equipe->equipe;
              $points[] = $equipe->total_points;
          }
  
          return view('admin.liste_categorie_general_classement', [
              'classement_categories' => $classement_categories,
              'nomCategories'=>$nomCategories,
              'labels' => $labels,
              'points' => $points,
              'i'=>$i
          ]);

       }



       public function changement($tableau,$point){
            $count=0;
            foreach ($tableau as $obj) {
                // Assumons que la propriété que vous voulez comparer est 'total_points'
                if ($obj->total_points == $point) {
                    $count++;
                }
            }
            if($count>=2){
                return "red";
            }
            return "none";
       }



      

     public function liste_categorie_classement(Request $request){
        $i=1;
        $listString;


        $categorie=$request->categorie;
        $nomCategories=DB::select("select nom from categories");
        $classement_categories=DB::select("select * from v_classement_equipes_categories where  categorie='$categorie';");

                  // Préparation des données pour le graphique en camembert
                  $labels = [];
                  $points = [];
                  $listString = [];
                  $k = 0;
                  foreach ($classement_categories as $equipe) {
                      $labels[] = $equipe->equipe;
                      $points[] = $equipe->total_points;
                      $listString[$k]=$this->changement($classement_categories,$equipe->total_points);
                      $k++;
                  }

                  
                  return view('admin.liste_categorie_classement', [
                      'classement_categories' => $classement_categories,
                      'nomCategories'=>$nomCategories,
                      'labels' => $labels,
                      'points' => $points,
                      'i'=>$i,
                      'listString'=>$listString,
                  ]);
        

      //  return view('admin.liste_categorie_classement',['classement_categories'=>$classement_categories,'i'=>$i,'nomCategories'=>$nomCategories]);
     }


     
    public function liste_penaliter(){
        $penalites=DB::select("select penalites.id as id, etapes.nom as etape_nom,equipes.nom as equipe_nom,
                                penalites.temps as temps from penalites join etapes on 
                                penalites.id_etape=etapes.id join equipes on penalites.id_equipe=equipes.id; ");
        return view('admin.liste_penaliter',['penalites'=>$penalites]);
    }
    


        public function v_insertion_penaliter(){
            $etapes=Etape::all();
            $equipes=Equipe::all();
            return view('admin.v_insertion_penaliter',['etapes'=>$etapes,'equipes'=>$equipes]);
        }




        private function formatTempsPostgreSQL($temps){return "'$temps'::interval";}

        public function insertion_penaliter(Request $request)
        {
            // Validation des données
            $data = $request->validate([
                'id_etape' => 'required|integer',
                'id_equipe' => 'required|integer',
                'temps' => 'required', // La validation du temps peut être faite dans le formulaire HTML
            ]);
        
            // Création de la pénalité
            Penalite::create($data);
        
            // Convertir le temps en un intervalle de temps PostgreSQL
            $temps = $this->formatTempsPostgreSQL($request->temps);
        
            // Requête pour mettre à jour les temps des coureurs
            DB::statement("
                UPDATE etape_coureurs
                SET arriver = arriver + $temps
                WHERE id_etape = :id_etape
                AND id_coureur IN (
                    SELECT id_coureur
                    FROM v_etape_coureur_chrono
                    WHERE id_etape = :id_etape
                        AND id_equipe = :id_equipe
                        AND id_coureur IN (
                            SELECT id_coureur 
                            FROM penalites 
                            WHERE id_etape = :id_etape 
                            AND id_equipe = :id_equipe
                        )
                )
            ", [
                'id_etape' => $request->id_etape,
                'id_equipe' => $request->id_equipe,
            ]);
        
            return redirect()->route('admin.v_insertion_penaliter');
        }
        
        
            



        public function suppression($id) {
             $penalite = Penalite::findOrFail($id);
            
            DB::statement("
                UPDATE etape_coureurs
                SET arriver = arriver - INTERVAL '$penalite->temps'
                WHERE id_etape = :id_etape
                AND id_coureur IN (
                    SELECT id_coureur
                    FROM v_etape_coureur_chrono
                    WHERE id_etape = :id_etape
                        AND id_equipe = :id_equipe
                        AND id_coureur IN (
                            SELECT id_coureur 
                            FROM penalites 
                            WHERE id_etape = :id_etape 
                            AND id_equipe = :id_equipe
                        )
                )
            ", [
                'id_etape' => $penalite->id_etape,
                'id_equipe' => $penalite->id_equipe,
            ]);
        
            $penalite->delete();
            
            return redirect(route('admin.liste_penaliter'))->with('success', 'Pénalité supprimée');
        }

        

        public function restaurer(){
            DB::statement('TRUNCATE TABLE import_etapes');
            DB::statement('TRUNCATE TABLE import_resultats');
            DB::statement('TRUNCATE TABLE import_points');
            DB::statement('TRUNCATE TABLE etape_coureurs');
            DB::statement('TRUNCATE TABLE coureur_categories');
            DB::statement('DELETE FROM penalites');
            DB::statement('DELETE FROM etapes');
            DB::statement('DELETE FROM coureurs');
            DB::statement('DELETE FROM equipes');
            DB::statement('DELETE FROM points');
     
             return redirect()->back()->with('success', 'La base de données a été réinitialisée avec succès, sauf la table "users".');
        }
   

        public function liste_resultat($id_etape){
            $classementCoureurs = DB::select("select * from v_rank_coureurs where id_etape=$id_etape");
            return view('admin.liste_resultat', ['classementCoureurs' => $classementCoureurs]);
        }

        public function v_exportPDF(){

            $classement_equipes=DB::select("select * from v_classement_equipes limit 1");
            $dompdf = new Dompdf();

            // Options pour dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);
            $dompdf->setOptions($options);

            // Chemin vers le fichier HTML
            $html = view('admin.v_exportPDF',['classement_equipes'=>$classement_equipes])->render();

            // Chargement du HTML dans dompdf
            $dompdf->loadHtml($html);

            // Rendu du PDF
            $dompdf->render();

            // Envoi du PDF en réponse
            return $dompdf->stream('certificat.pdf');
            //return view('admin.v_exportPDF',['classement_equipes'=>$classement_equipes]);
        }



      /*  public function exportPDF($classement_equipe_id) {
            // Récupérez les données de l'équipe à partir de l'identifiant
            $classement_equipe1 = DB::table('v_classement_equipes')->where('id', $classement_equipe_id)->first();
        
            // Si l'équipe n'existe pas, redirigez ou affichez une erreur
            if (!$classement_equipe1) {
                // Gérer l'erreur
            }
        
            // Passer les données à la vue PDF
            $pdf = PDF::loadView('nom_de_votre_vue_pdf', ['classement_equipe1' => $classement_equipe1]);
            
            // Retournez le PDF à télécharger
            return $pdf->download('export.pdf');
        }*/
        
        public function homeAdmin2(){return view('admin.homeAdmin2');}
        public function v_aleas(){return view('admin.v_aleas');}

        public function aleas(Request $request){
            $message='';
            if($request->nbr>10000){
                 $message='ERROR';
            }else{
                $message='Yes';
            }

           return view('admin.v_aleas ', ['message' => $message]);
        }
 }
