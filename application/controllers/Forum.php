<?php

/**
 * Created by PhpStorm.
 * User: johnyftr
 * Date: 23/08/2018
 * Time: 05:58
 */
class Forum extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->titre_defaut = 'Mon super site';
        $this->load->helpers("url");
        $this->load->library("Alphabet");
        $this->load->model("commentaire");
    }


    public function index()
    {
        $this->listeCommentaire();

    }

    public function listeCommentaire()
    {
       $data = array();
       $data['data'] = $this->commentaire->liste_commentaire();
       $this->load->view('commentaire', $data);
    }

    public function accueil(){
        echo " - " . $this->session->message;
        echo "</br> ====> " . $this->session->nom . " <====";

        $this->load->model('news_model', 'newsManager');
        $resultat = $this->newsManager->ajouter_news('Arthur',
            'Un super titre',
            'Un super contenu !');
        var_dump($resultat);

        $this->load->view('accueil');
    }

    public function connexion_reussi(){

        $this->load->view('connexion_reussi');
    }
    public function poste(){
        var_dump(current_url());

        $this->session->set_flashdata("message", "je suis rediriger vers page d accueil");
        $_SESSION['nom'] ="fetra";
        redirect('forum', $this->accueil());
        $this->load->view('postes');
    }
    public function teste_form(){

        // Chargement de la bibliothèque
        $this->load->library('form_validation');

        //les regles
        $this->form_validation->set_rules('pseudo', 'pseudo', 'trim|required|min_length[5]|max_length[52]');
        $this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|min_length[5]|max_length[52]');

        if($this->form_validation->run())
        {
        // Le formulaire est valide
            echo $this->input->post('pseudo');
            $this->load->view('connexion_reussi');
        }
        else
        {
        // Le formulaire est invalide ou vide
                    $_SESSION['erreur'] = "Champs invalide";
                    $this->connexion();
        }
    }

    public function connexion(){
        echo $this->session->erreur;
        $this->load->view('formulaire');
    }

    public function fonctionArgumenter($a = "", $b=""){
        var_dump($this->titre_defaut);
        echo $this->session->pseudo ;
        echo " - " . $this->session->message;
        $this->load->view('postes', array("valeurA" => $a, "valeurB" => $b));
    }
}