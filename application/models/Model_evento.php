<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_evento extends CI_Model {

	var $tab = "evento";
    var $id  = "idEvento";
    
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
	}
	// retorna todos os eventos 
	public function retorna($ativo=null){
		$this->db->select('*');		
		$query = $this->db->get($this->tab);
		return $query->result();
	}


	// Retorna lista de pessoas que vão particiar de um evento 
	public function ocupacao_evento($id){
		$this->db->select('*, u.nome as nome_user');
		$this->db->where('idEvento', $id);
		$this->db->join('usuario u', 'u.idUsuario = i.idUsuario_u','left');
		$this->db->join('evento e', 'e.idEvento = i.idEvento_e','left');
		$query = $this->db->get("inscricao i");
		return $query->result();
	}


	// Retorna eventos que o usuario participou 
	public function participacao_evento($id){
		$this->db->select('*, u.nome as nome_user');
		$this->db->where('idUsuario	', $id);
		$this->db->join('usuario u', 'u.idUsuario = i.idUsuario_u','left');
		$this->db->join('evento e', 'e.idEvento = i.idEvento_e','left');
		$query = $this->db->get("inscricao i");
		return $query->result();
	}

	// Verifica se usuário ja está inscrito em um evento
	public function registrado_evento($id,$idEvento){
		$this->db->select('*');
		$this->db->where('idUsuario_u', $id);
		$this->db->where('idEvento_e', $idEvento);
		$query = $this->db->get("inscricao i");
		return $query->result();
	}
}