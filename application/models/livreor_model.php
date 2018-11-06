<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Livreor_model extends MY_Model
{
    protected $table = 'livreor_commentaires';

    //ajout commentaire
    public function ajouter_commentaire($options_echappees = array(), $options_non_echappees = array())
    {
        return $this->create($options_echappees, $options_non_echappees);
    }

    //compter les nomber des commentaire dans la table
    public function count($champ = array(), $valeur = null)
    {
        return $this->countt($champ, $valeur);
    }

    //compter les nomber des commentaire dans la table
    public function suprimer($id)
    {
        return $this->delete($id);
    }

    //recupererer les commentaire
    public function get_commentaires($nb, $debut = 0)
    {
        if(!is_integer($nb) OR $nb < 1 OR !is_integer($debut) OR $debut < 0)
        {
            return false;
        }

        return $this->db->select('`id`, `pseudo`, `message`, DATE_FORMAT(`date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'date\'', false)
            ->from($this->table)
            ->order_by('id', 'desc')
            ->limit($nb, $debut)
            ->get()
            ->result();
    }

}