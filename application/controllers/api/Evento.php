<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
use chriskacerguis\RestServer\RestController;
class Evento extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_evento','Model_eventoMDL');
        $this->load->model('Model_inscricao','Model_inscricaoMDL');
        $this->load->model('Model_arquivo','Model_arquivoMDL');
        $this->methods['index_get']['limit'] = 10;   // Configuração para os limites de requisições (por hora)
    }

    // Lista todos os eventos ou filtra por id
   public function index_get()
    {
        $retorno = null;
         // Recebe id passada pela url
         $evento =  (string) $this->uri->segment(3);

         if (!empty($evento)){   
            $retorno['dados'] = $this->Model_eventoMDL->retorna_e($evento);   
            $retorno['dados_arquivo'] = $this->Model_arquivoMDL->retorna_evento($evento);  
         }else{             
            $resultado = $this->Model_eventoMDL->retorna();
            $retorno['dados'] = array('resultado'=>$resultado);   
         }
 
         // usando os devidos cabeçalhos
         if ($retorno) {
            $response = $retorno;
              $this->response($response, REST_Controller::HTTP_OK);
         } else {
            $response = array('status' => false,'msg' => 'Nenhum evento encontrado');
              $this->response($response,REST_Controller::HTTP_NO_CONTENT);
         }
    }

    // Insere novo envento 
    public function index_post()
    {
        // recupera os dados informado no formulário
        $dados_evento = $this->post();

        if(empty($dados_evento)){
            $response['dados'] = "Nenhuma informação inserida!";
        }else{
            $insert = $this->Model_eventoMDL->insere($dados_evento);
            $response['msg'] = array('msg'=>'Não foi possível realizar o cadastro','retorno'=>'sucesso'); 
        }
        $response['form'] = $dados_evento;  
        $this->response($response,200); 
    }


    // Insere nova inscricao
    public function inscricao_post()
    {
        // recupera os dados informado no formulário
        $dados_evento = $this->post();

        if(empty($dados_evento)){
            $response['dados'] = "Nenhuma informação inserida!";
        }else{
            $insert = $this->Model_inscricaoMDL->insere($dados_evento);
            $response['msg'] = array('msg'=>'Não foi possível realizar o cadastro','retorno'=>'sucesso'); 
        }
        $response['form'] = $dados_evento;  
        $this->response($response,200); 
    }


    // Retorna lista de curso com os 
    public function ocupacao_get(){
        $retorno = null;
         // Recebe id passada pela url
         $evento =  (string) $this->uri->segment(4);

         if (!empty($evento)){   
            $retorno['dados'] = $this->Model_eventoMDL->ocupacao_evento($evento);     
         }else{
            $retorno['dados'] = array('resultado'=>'Eveneto não encontrado');   
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


    // altera estado da 
    public function ocupacao_put(){
        $dadosAltera = $this->put();
        $idInscricao = $this->uri->segment(4);

        // processa o update no banco de dados
        $update = $this->Model_inscricaoMDL->altera_inscricao($idInscricao, $dadosAltera);
        // define a mensagem do processamento
        // verifica o status do update para retornar o cabeçalho corretamente
        if ($update==true) {
            $response['status'] = true;
            $response['msg']    = "Alteração realizada com sucesso";
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // altera estado da 
    public function participacao_get(){
        $id = $this->uri->segment(4);
        $response ="";
        // processa o update no banco de dados
        $evento = $this->Model_eventoMDL->participacao_evento($id);
      
        if (empty($evento)) {
              $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        } else {
          $response['status'] = true;
            $response['dados']    = $evento;
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }

     public function inscrito_get(){
        $idUsuario = $this->uri->segment(4);
        $idEvento = $this->uri->segment(5);

        $response ="";
        //verifica se o usuário está cadastrado no evento
        $evento = $this->Model_eventoMDL->registrado_evento($idUsuario,$idEvento);
        if (empty($evento)) {
            $response['status'] = false;
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $response['status'] = true;
            $response['dados']    = $evento;
            $this->response($response, REST_Controller::HTTP_OK);
        }
    }
}