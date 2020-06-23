<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_inscricao extends CI_Model {

	var $tab = "inscricao";
    var $id  = "idInscricao";
    
    public function insere($insert){
		$this->db->insert($this->tab, $insert);
		$inserido = $this->db->insert_id();
		if(empty($inserido)){
			return 0;
		}else{
			return $inserido;
		}
	}
	// Altera pagamento
	public function altera($idAltera,$altera){
		$this->db->where($this->id, $idAltera);
		$this->db->update($this->tab, $altera);

		 if($this->db->affected_rows()>=0){
      return true;
		}else{
		return false;
		}
    }
    
    // retorna evento especificado
	public function retorna_e($id){
		$this->db->select('*');
		$this->db->where($this->id, $id);
		$this->db->join('video v', 'v.idEvento_e = e.idEvento','left');
		$query = $this->db->get("evento e");

		return $query->row();


		// $this->db->select('*');
		// // $this->db->join('video v', 'v.idEvento = e.idEvento','left');
		// 	// $this->db->join('ordem_pagamento op', 'op.id_op = d.op_id_op', 'left');
		// $this->db->where($this->id, $id);
		// return $this->db->get("evento e");
		// return $query->result();
	}
	// retorna todos os eventos 
	public function retorna($ativo=null){
		$this->db->select('*');		
		$query = $this->db->get($this->tab);
		return $query->result();
	}

	// Altera pagamento
	public function altera_inscricao($idInscricao,$altera){
		$this->db->where($this->id, $idInscricao);
		$this->db->update('inscricao',$altera);
		 if($this->db->affected_rows()>=0){
      		return true;
		}else{
			return false;
		}
    }

}