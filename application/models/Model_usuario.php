<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_usuario extends CI_Model {

	var $tab = "usuario";
    var $id  = "idUsuario";
    
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
		return $this->db->get($this->tab)->row();
	}
	// retorna todos os eventos 
	public function retorna($ativo=null){
		$this->db->select('*');		
		$query = $this->db->get($this->tab);
		return $query->result();
	}

}