<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;



Route::get('/', function () {return view('auth.login');})->name('login');

Route::controller(LoginController::class)->group(function(){
    Route::post('login',  'loginAction')->name('loginAction');
    Route::get('logout', 'logout')->name('logout');
});




// Route pour la page admin
Route::middleware(['auth:web'])->group(function () {
    Route::controller(AdminController::class)->group(function(){ 
        Route::get('/admin/home', 'homeAdmin')->name('homeAdmin');
        Route::get('/admin/homeAdmin2', 'homeAdmin2')->name('admin.homeAdmin2');
        Route::get('/admin/liste_etape', 'liste_etape')->name('admin.liste_etape');
        Route::get('/admin/maj_temps_coureur', 'maj_temps_coureur')->name('admin.maj_temps_coureur');
        Route::post('/admin/update_temps_coureur', 'update_temps_coureur')->name('admin.update_temps_coureur');
        Route::get('/admin/liste_coureur_classement', 'liste_coureur_classement')->name('admin.liste_coureur_classement');
        Route::get('/admin/liste_equipe_classement', 'liste_equipe_classement')->name('admin.liste_equipe_classement');
        Route::get('/admin/v_imporationCSV_etape_resultat', 'v_imporationCSV_etape_resultat')->name('admin.v_imporationCSV_etape_resultat');
        Route::get('/admin/v_importationCSV_point', 'v_importationCSV_point')->name('admin.v_importationCSV_point');
        Route::post('/admin/importCSVEtapeResultat', 'importCSVEtapeResultat')->name('admin.importCSVEtapeResultat');
        Route::post('/admin/importCSVPoint', 'importCSVPoint')->name('admin.importCSVPoint');
        Route::get('/admin/v_generer_categorie', 'v_generer_categorie')->name('admin.v_generer_categorie');
        Route::post('/admin/generer_categorie', 'generer_categorie')->name('admin.generer_categorie');
        Route::get('/admin/liste_categorie_general_classement', 'liste_categorie_general_classement')->name('admin.liste_categorie_general_classement');
        Route::post('/admin/liste_categorie_classement', 'liste_categorie_classement')->name('admin.liste_categorie_classement');
        Route::get('/admin/liste_penaliter', 'liste_penaliter')->name('admin.liste_penaliter');
        Route::get('/admin/v_insertion_penaliter', 'v_insertion_penaliter')->name('admin.v_insertion_penaliter');
        Route::post('/admin/insertion_penaliter', 'insertion_penaliter')->name('admin.insertion_penaliter');
        Route::post('/admin/{penalite}/suppression', 'suppression')->name('admin.suppression');
        Route::get('/admin/restaurer', 'restaurer')->name('admin.restaurer');
        Route::get('/admin/liste_resultat/{id_etape}', 'liste_resultat')->name('admin.liste_resultat');
        Route::get('/admin/v_exportPDF', 'v_exportPDF')->name('admin.v_exportPDF');
        Route::get('/admin/v_aleas', 'v_aleas')->name('admin.v_aleas');
        Route::post('/admin/aleas', 'aleas')->name('admin.aleas');

        //v_exportPDF
    });
});



// Route pour la page home equipe
Route::middleware(['auth:equipe'])->group(function () {
    Route::controller(HomeController::class)->group(function(){ 
        Route::get('/home', 'index')->name('home');
        Route::get('/equipe/home2', 'home2')->name('equipe.home2');
        Route::get('/equipe/liste_etape', 'liste_etape')->name('equipe.liste_etape');
        Route::get('/equipe/insert_etape_coureur/{id_equipe}/{id_etape}', 'insert_etape_coureur')->name('equipe.insert_etape_coureur');
        Route::post('/equipe/createEtapeCoureur', 'createEtapeCoureur')->name('equipe.createEtapeCoureur');
        Route::get('/equipe/liste_coureur_classement', 'liste_coureur_classement')->name('equipe.liste_coureur_classement');
        Route::get('/equipe/liste_equipe_classement', 'liste_equipe_classement')->name('equipe.liste_equipe_classement');
        Route::get('/equipe/liste_categorie_general_classement', 'liste_categorie_general_classement')->name('equipe.liste_categorie_general_classement');
        Route::post('/equipe/liste_categorie_classement', 'liste_categorie_classement')->name('equipe.liste_categorie_classement');
        Route::post('/equipe/v_EtapeCoureur', 'v_EtapeCoureur')->name('equipe.v_EtapeCoureur');

        //
    });
});


