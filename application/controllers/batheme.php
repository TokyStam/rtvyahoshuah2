<?php

/**
 * Created by PhpStorm.
 * User: johnyftr
 * Date: 30/10/2018
 * Time: 12:07
 */
class Batheme extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('batheme_model');
        $this->load->helper('assets');
    }

    public function index()
    {

        $data['bathemes']=$this->batheme_model->get_all_batheme();
        $this->load->view('batheme/batheme_view',$data);
    }

    public function batheme_add()
    {
        $data = array(
            'date_bat' => $this->input->post('date_bat'),
            'date_close' => $this->input->post('date_close'),
            'description' => $this->input->post('description'),
        );
        $insert = $this->batheme_model->batheme_add($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->batheme_model->get_by_id($id);
        echo json_encode($data);
    }

    public function batheme_update()
    {
        $data = array(
            'date_bat' => $this->input->post('date_bat'),
            'date_close' => $this->input->post('date_close'),
            'description' => $this->input->post('description'),
        );
        $this->batheme_model->batheme_update(array('bat_id' => $this->input->post('bat_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function batheme_delete($id)
    {
        $this->batheme_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}