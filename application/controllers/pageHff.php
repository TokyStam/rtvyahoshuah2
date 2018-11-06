
<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');
require_once APPPATH . 'core/MY_Controller.php';
class PageHff extends CI_Controller
{
    public function __construct()
    {
            parent::__construct();
            $this->load->helper('assets');
            $this->load->model('batheme_model');
    }

    public function index()
    {
        $this->accueil();
    }


    public function accueil(){
        $this->load->view('theme/en_tete');
        $this->load->view('hffPage/accueil');
        $this->load->view('theme/footer');
    }

    public function Programme(){
        $data['bathemes']=$this->batheme_model->get_all_batheme();

        $this->load->view('theme/en_tete');
        $this->load->view('hffPage/programme', $data);
        $this->load->view('theme/footer');
    }

    public function declaration(){
        $this->load->view('theme/en_tete');
        $this->load->view('hffPage/declaration');
        $this->load->view('theme/footer');
    }

    public function contact(){
        $this->load->library('googlemaps');

        $config['center'] = '-21.428776, 47.104012';
        $config['zoom'] = 'auto';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = '-18.174868, 49.398156';
        $marker['onclick'] = 'NewOnglet("https://www.google.com/maps/place/18%C2%B010\'29.5%22S+49%C2%B023\'53.4%22E/@-18.174868,49.3959727,17z/data=!3m1!4b1!4m5!3m4!1s0x0:0x0!8m2!3d-18.174868!4d49.398156");';
        $this->googlemaps->add_marker($marker);

        $marker = array();
        $marker['position'] = '-21.428776, 47.104012';
        $marker['onclick'] = ' NewOnglet("https://www.google.com/maps/place/21%C2%B025\'43.6%22S+47%C2%B006\'14.4%22E/@-21.428776,47.1018287,471m/data=!3m1!1e3!4m5!3m4!1s0x0:0x0!8m2!3d-21.428776!4d47.104012")';
        $this->googlemaps->add_marker($marker);

         $marker = array();
        $marker['position'] = '-19.875266, 47.028810';
        $marker['onclick'] =  ' NewOnglet("https://www.google.com/maps/place/19%C2%B052\'31.0%22S+47%C2%B001\'43.7%22E/@-19.8752224,47.028207,132m/data=!3m1!1e3!4m5!3m4!1s0x0:0x0!8m2!3d-19.875266!4d47.02881")';
        $this->googlemaps->add_marker($marker);

        $marker = array();
        $marker['position'] = '-18.896369, 47.472513';
        $marker['onclick'] =  ' NewOnglet("https://www.google.com/maps/place/18%C2%B053\'46.9%22S+47%C2%B028\'21.1%22E/@-18.89646,47.4723789,64m/data=!3m1!1e3!4m5!3m4!1s0x0:0x0!8m2!3d-18.896369!4d47.472513")';
        $this->googlemaps->add_marker($marker);

        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('theme/en_tete', $data);
        $this->load->view('hffPage/contact');
        $this->load->view('theme/footer');
    }

    public function liveRadio(){
        $this->load->view('theme/en_tete');
        $this->load->view('hffPage/liveRadio');
        $this->load->view('theme/footer');
    }

}