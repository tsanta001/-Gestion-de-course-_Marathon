<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etape;
use App\Models\Coureur;
use App\Models\Etape_coureur;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    public function index(){return view('home');}

    public function liste_etape(Request $request){
        $id_equipe=$request->id_equipe;
        $etapes=Etape::all();
        /*$etapes=DB::select("select etapes.id as id,etapes.nom as etape_nom, etapes.longueur as longueur,
         etapes.nbr_coureur as nbr_coureur , coureurs.nom as coureur_nom , v_etape_coureur_points.temps as temps,
         v_etape_coureur_points.id_equipe as id_equipe from v_etape_coureur_points join  etapes 
         on v_etape_coureur_points.id_etape=etapes.id join coureurs on v_etape_coureur_points.id_coureur=coureurs.id
         where v_etape_coureur_points.id_equipe=$id_equipe group by etapes.nom, etapes.longueur , etapes.nbr_coureur, coureurs.nom ,
         v_etape_coureur_points.temps , v_etape_coureur_points.id_equipe, etapes.id;");*/


        return  view('equipe.liste_etape',['etapes'=>$etapes]);
    }




    public function insert_etape_coureur($id_equipe, $id_etape){
        $coureurs = DB::select("
            SELECT etapes.id AS id, etapes.nom AS etape_nom, etapes.longueur AS longueur,
                   etapes.nbr_coureur AS nbr_coureur, coureurs.nom AS coureur_nom, v_etape_coureur_points.temps AS temps,
                   v_etape_coureur_points.id_equipe AS id_equipe 
            FROM v_etape_coureur_points 
            JOIN etapes ON v_etape_coureur_points.id_etape = etapes.id 
            JOIN coureurs ON v_etape_coureur_points.id_coureur = coureurs.id
            WHERE v_etape_coureur_points.id_equipe = ? 
              AND etapes.id = ? 
            GROUP BY etapes.nom, etapes.longueur, etapes.nbr_coureur, coureurs.nom,
                     v_etape_coureur_points.temps, v_etape_coureur_points.id_equipe, etapes.id
        ", [$id_equipe, $id_etape]);
        $nbr_coureurs = DB::select("SELECT nbr_coureur FROM etapes WHERE id = ?", [$id_etape]);
        $nbr_coureur = $nbr_coureurs[0]->nbr_coureur;
    
        return view('equipe.insertEtapeCoureur', [
            'coureurs' => $coureurs,
            'id_etape' => $id_etape,
            'nbr_coureur' => $nbr_coureur
        ]);
    }
    
    public function v_EtapeCoureur(Request $request){
        $id_etape = $request->id_etape;
        $id_equipe = $request->id_equipe;
        $nbr_coureur_inscri = $request->nbr_coureur_inscri;
        $nbr_coureur = $request->nbr_coureur;
    
        $coureurs = DB::select("SELECT id, nom FROM coureurs WHERE id_equipe = ?", [$id_equipe]);
    
        return view('equipe.v_EtapeCoureur', [
            'id_etape' => $id_etape,
            'coureurs' => $coureurs,
            'nbr_coureur_inscri' => $nbr_coureur_inscri,
            'nbr_coureur' => $nbr_coureur
        ]);
    }
    
    public function createEtapeCoureur(Request $request){
        $data = $request->validate([
            'id_etape' => 'required',
            'id_coureur' => 'required|array',
        ]);
    
        $nbr_coureur_inscri = $request->nbr_coureur_inscri;
        $nbr_coureur = $request->nbr_coureur;
        $id_equipe=$request->id_equipe;
        $id_etape=$request->id_etape;
    
        if ($nbr_coureur_inscri >= $nbr_coureur) {
            return redirect()->route('equipe.insert_etape_coureur', ['id_equipe' => $id_equipe, 'id_etape' => $id_etape])
                ->with('error', 'Vous ne pouvez plus inscrire de joueur pour cette étape !');
        } else {
            foreach ($data['id_coureur'] as $id_coureur) {
                Etape_coureur::create([
                    'id_etape' => $data['id_etape'],
                    'id_coureur' => $id_coureur,
                    'date_depart' => null,
                    'heure_depart' => null,
                    'arriver' => null,
                    'point' => null,
                ]);
            }
    
            return redirect()->route('equipe.insert_etape_coureur', ['id_equipe' => $id_equipe, 'id_etape' => $id_etape])->with('success', 'Les coureurs ont été inscrits avec succès.');
        }
    }
    
    


    public function liste_coureur_classement(){
        $classement_coureurs=DB::select("select * from v_classement_coureurs");
        $i=1;
        return  view('equipe.liste_coureur_classement',['classement_coureurs'=>$classement_coureurs,'i'=>$i]);
    }


    public function liste_equipe_classement() {
        
        $classement_equipes=DB::select("select * from v_classement_equipes");
        $i=1;
        return  view('equipe.liste_equipe_classement',['classement_equipes'=>$classement_equipes,'i'=>$i]);

    }

    public function liste_categorie_general_classement(){
        $i=1;
        $nomCategories=DB::select("select nom from categories");
        $classement_categories=DB::select("select * from v_classement_equipes_categories;");

        return view('equipe.liste_categorie_general_classement',['classement_categories'=>$classement_categories,'i'=>$i,'nomCategories'=>$nomCategories]);
    }

    public function liste_categorie_classement(Request $request){
        $i=1;
        $categorie=$request->categorie;
        $nomCategories=DB::select("select nom from categories");
        $classement_categories=DB::select("select * from v_classement_equipes_categories where  categorie='$categorie';");
        return view('equipe.liste_categorie_classement',['classement_categories'=>$classement_categories,'i'=>$i,'nomCategories'=>$nomCategories]);
     }

    





     public function home2(){return view('equipe.home2');}
    
}
