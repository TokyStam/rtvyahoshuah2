<?php

/**
 * Created by PhpStorm.
 * User: johnyftr
 * Date: 10/09/2018
 * Time: 16:30
 */
class Test1 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }
    public function index()
    {
        $this->benchmark->mark('requete1_start');
        $query = $this->db->query('SELECT `id`, `pseudo`, `message`FROM `livreor_commentaires`')->result();
        $this->benchmark->mark('requete1_end');


        $this->benchmark->mark('requete2_start');
        $query = $this->db->select('id, pseudo, message')->from('livreor_commentaires')->get()->result();
        $this->benchmark->mark('requete2_end');

        $this->output->enable_profiler(true);
    }

}