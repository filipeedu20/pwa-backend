<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Download extends CI_Controller { 
    /**
    * Responsavél por zipar aquivo para download e contabilizar os downloads realizados 
    */  
   public function realizarDownload(){
      $this->load->helper('download');
      $this->load->model('Model_arquivo');      
      $this->load->library('zip');
      $this->load->library('session');    
      //   recebe id do arquivo para realizar o download
      $idArquivo = $this->uri->segment(3);
      // lista informações do arquivo 
      $arquivo = $this->Model_arquivo->retornaDownload($idArquivo);
      
      // verifica se houve se foi incrementado o valor do arquivo
      if(!empty($arquivo)){
         $caminho = 'uploads/'.$arquivo->nome_dir;
         $data =file_get_contents($caminho); // Read the file's contents   
         $nome = $arquivo->nome_sistema;
         $nome = str_replace(" ","_",$nome);
         $this->zip->read_file($caminho);
         $file = $nome.".zip";
         $this->zip->download($file);
      }else{
         echo "não foi possível realizar o download";
      }
   }
}

/* End of file Download.php */
