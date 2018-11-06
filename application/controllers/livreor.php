<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Livreor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('assets');
        $this->load->model('livreor_model', 'livreorManager');
//        $this->output->enable_profiler(true);
        $this->session->set_userdata('pseudo', 'fetra');
        $this->load->view('theme/en_tete');
    }


    public function index($g_nb_commentaire = 1)
    {
        $this->voir($g_nb_commentaire);
    }

    public function voir($g_nb_commentaire = 1)
    {
        $this->load->library('pagination');
        $data = array();
        $nb_commentaire_total = $this->livreorManager->count(array('pseudo' => 'Mathieu'));
        if($g_nb_commentaire > 1)
        {
            if($g_nb_commentaire <= $nb_commentaire_total)
            {
              $nb_commentaire = intval($g_nb_commentaire);
            }
            else
            {
            $nb_commentaire = 1;
            }
    }
    else
    {
        $nb_commentaire = 1;
    }
       define('NB_COMMENTAIRE_PAR_PAGE', 5);
       $this->pagination->initialize(array('base_url' => base_url() .
                                            'index.php/livreor/voir/',
                                            'total_rows' => $nb_commentaire_total,
                                            'per_page' => NB_COMMENTAIRE_PAR_PAGE));

    $data['pagination'] = $this->pagination->create_links();
    $data['nb_commentaires'] = $nb_commentaire_total;

    $data['messages'] = $this->livreorManager->get_commentaires(NB_COMMENTAIRE_PAR_PAGE, $nb_commentaire-1);

    // On charge la vue
        $this->load->view('livreor/commentaire', $data);
        $this->load->view('theme/footer');

    }

    public function ecrire(){


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="form_erreur">', '</p>');

        $this->form_validation->set_rules('pseudo', '"Pseudo"','trim|required|min_length[3]|max_length[25]|alpha_dash');
        $this->form_validation->set_rules('contenu', '"Contenu"', 'trim|required|min_length[3]|max_length[3000]');

        if($this->form_validation->run())
        {
            $data = array();
            $data['pseudo'] = $this->input->post('pseudo');
            $data['message'] = $this->input->post('contenu');

            $date['date'] = 'NOW()';

            $this->livreorManager->ajouter_commentaire($data, $date);
            $this->load->view('livreor/confirmation');
        }
        else
        {
           $this->load->view('livreor/ecrire_commentaire');
           $this->load->view('theme/footer');
        }
    }

    public function suprimer($id){
        $this->livreorManager->suprimer(intval($id));
        $this->load->view('theme/footer');
        redirect('livreor', $this->voir());
    }
}