<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
use chriskacerguis\RestServer\RestController;
class Video extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_video','Model_videoMDL');
        $this->methods['index_get']['limit'] = 10;   // Configuração para os limites de requisições (por hora)
    }

    // Lista todos os eventos ou filtra por id
    public function index_get()
    {
        $retorno = null;
         // Recebe id passada pela url
         $evento =  (string) $this->uri->segment(3);

         if (!empty($evento)){   
            $retorno['dados'] = $this->Model_videoMDL->retorna_e($evento);     
         }else{
             
            $resultado = $this->Model_videoMDL->retorna();

            $retorno['dados'] = array('resultado'=>$resultado);   
         }
 
         // usando os devidos cabeçalhos
         if ($retorno) {
            $response = $retorno;
             $this->response($response,200);
         } else {
             $this->response([
                'status' => false,
                'msg' => 'Nenhum evento encontrado',
                'retorno'=>$evento
            ], 404 );
         }
    }

    // Insere novo envento 
    public function index_post()
    {
        
        $dados_evento = $this->post();
        if(empty($dados_evento)){
            $response['dados'] = "Nenhuma informação inserida!";
        }else{
            $insert = $this->Model_videoMDL->insere($dados_evento);
            $response['msg'] = array('msg'=>'Não foi possível realizar o cadastro','retorno'=>'sucesso'); 
        }
        $response['form'] = $dados_evento;  
        $this->response($response,200); 
    }

     // Lista todos os eventos ou filtra por id
    public function inscricao_get()
    {
        $retorno = null;
         // Recebe id passada pela url
         $evento =  (string) $this->uri->segment(4);

         if (!empty($evento)){   
            $retorno['dados'] = $this->Model_videoMDL->retorna_e($evento);     
         }else{
             
            $resultado = $this->Model_videoMDL->retorna();

            $retorno['dados'] = array('resultado'=>$resultado);   
         }
 
         // usando os devidos cabeçalhos
         if ($retorno) {
            $response = $retorno;
             $this->response($response,200);
         } else {
             $this->response([
                'status' => false,
                'msg' => 'Nenhum evento encontrado',
                'retorno'=>$evento
            ], 404 );
         }
    }
}