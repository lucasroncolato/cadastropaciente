<?php

class CustomerController extends Zend_Controller_Action {

    /**
     * @var Zend_Log
     */
    private $logger = null;

    public function init() {
        //$this->logger = Zend_Registry::get('logger');
    }

    public function indexAction() {
        //  $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/search-customer.ini', 'form');
        //  $this->view->form = new Application_Form_SearchCustomer($config);
        //  $dbTable = new Application_Model_DbTable_Customer();
    }

    public function createAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/customer.ini', 'create');
        // $this->view->form = new Application_Form_Customer($config);

        $form = new Application_Form_Customer($config);


        $form->addDisplayGroup(array('id', 'cpf', 'name'), 'cadastro1');
        $create1 = $form->getDisplayGroup('cadastro1');
        $create1->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-right: 60px;'))
        ));


        $form->addDisplayGroup(array('convenio', 'birthday'), 'cadastro2');
        $create2 = $form->getDisplayGroup('cadastro2');
        $create2->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-right: 60px;'))
        ));

        $form->addDisplayGroup(array('gender'), 'cadastro3');
        $create3 = $form->getDisplayGroup('cadastro3');
        $create3->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-right: 60px;'))
        ));

        $form->addDisplayGroup(array('submit'), 'cadastro4');
        $create4 = $form->getDisplayGroup('cadastro4');
        $create4->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:right;padding-bottom:10px;'))
        ));

        $form->addDisplayGroup(array('reset'), 'cadastro5');
        $create5 = $form->getDisplayGroup('cadastro5');
        $create5->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:right;padding-bottom:10px;'))
        ));


        $form->getElement('cpf')->setAttrib('required', 'required');


        $form->getElement('gender')->setAttrib('required', 'required');

        /*

          $form->getElement('cpf')->addValidator('regex', false, array('/^[0-9]/i')); */



        $this->view->form = $form;
        // $this->view->form->setAction($this->view->url());
        // $this->view->jsonEncoded = false;
        $dadosFormulario = $this->getRequest()->getPost();
        if ($this->_request->isPost()) {
            if ($form->isValid($dadosFormulario)) {
                $values = $form->getValues();
                // var_dump($values['gender']);
                //  $formData = $this->getRequest()->getPost();

                $cpf = $values['cpf'];
                $name = $values['name'];
                $gender = $values['gender'];
                $convenio = $values['convenio'];
                $birthday = $values['birthday'];
                $birthday = date("Y-m-d",strtotime(str_replace('/','-',$birthday)));


                $data = array(
                    'cpf' => $cpf,
                    'name' => $name,
                    'gender' => $gender,
                    'convenio' => $convenio,
                    'birthday' => $birthday,
                );


                $cadastro = new Application_Model_DbTable_Customer();
                if ($cadastro->gravar($data)) {

                    // $this->view->resp = "Nome:  " . $name . ", enviado com sucesso!";
                    //   $form->populate($formData);
                    $this->view->titulo = "Sucesso!";
                    // $this->view->form = $form;
                    $this->view->resp = "Paciente:  " . $name . ",  foi envidado com sucesso!";
                    $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-success";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;
                    
                    
                } else {
                    // $this->view->resp = "Nome:  " . $name . ", nao foi gravado!";
                    // $form->populate($values);
                    $this->view->titulo = "Sinto Muito!";
                    // $this->view->form = $form;
                    $this->view->resp = "Paciente:  " . $name . ",  não pode ser cadastrado!";
                   $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-danger";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;
                }
            } else {

                $form->populate($dadosFormulario);
            }
        }
    }

    public function editAction() {

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/customer.ini', 'edit');
        $form = new Application_Form_Customer($config);
        $customerModel = new Application_Model_DbTable_Customer();

        $form->addDisplayGroup(array('id', 'cpf', 'name'), 'cadastro1');
        $create1 = $form->getDisplayGroup('cadastro1');
        $create1->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-right: 60px;')),
        ));

        $form->addDisplayGroup(array('convenio', 'birthday'), 'cadastro2');
        $create2 = $form->getDisplayGroup('cadastro2');
        $create2->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-right: 60px;'))
        ));

        $form->addDisplayGroup(array('gender'), 'cadastro3');
        $create3 = $form->getDisplayGroup('cadastro3');
        $create3->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-right: 60px;'))
        ));

        $form->addDisplayGroup(array('submit'), 'cadastro4');
        $create4 = $form->getDisplayGroup('cadastro4');
        $create4->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:left;padding-bottom:10px;'))
        ));

        $form->addDisplayGroup(array('reset'), 'cadastro5');
        $create5 = $form->getDisplayGroup('cadastro5');
        $create5->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-bottom:10px;padding-right: 120px;'))
        ));

        $id = $this->_getParam("id");
        $name = $this->_getParam("name");

        $form->addElement('button', 'Excluir');
        $form->getElement('Excluir')->setAttrib('class', 'btn btn-danger');
        $form->getElement('Excluir')->setAttrib("onClick", "location='/default/customer/deletar/id/$id/name/$name';");

        $form->addDisplayGroup(array('Excluir'), 'cadastro6');
        $create6 = $form->getDisplayGroup('cadastro6');
        $create6->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-bottom:10px;'))
        ));







        // $form->getElement('cpf')->setAttrib('required', 'required');


        $form->getElement('gender')->setAttrib('required', 'required');
      
        // $form->setAction($this->getRequest()->getPathInfo());
        $usuarioBuscado = $customerModel->find($this->_getParam('id'));

        $row = $usuarioBuscado->current();

        $row['birthday'] = date('d/m/Y', strtotime($row['birthday']));
        $row['convenio'] = $row['convenio'];
        $form->populate($row->toArray());



        $form->getElement('name')->setRequired(true);

        // $form->getElement('cpf')->addValidator('alnum');
        $dadosFormulario = $this->getRequest()->getPost();

        $this->view->form = $form;
        //  $this->view->form->setAction($this->view->url());
        // $this->view->jsonEncoded = false;

        if ($this->_request->isPost()) {

            if ($form->isValid($dadosFormulario)) {

                // $values = $this->view->form->getValues();

                $id = $this->getRequest()->getParam("id", "");
                $name = $this->getRequest()->getParam("name", "");

                $values = $form->getValues();

                $convenio = $values['convenio'];
                $gender = $values['gender'];
                $birthday = $values['birthday'];
                $birthday = date("Y-m-d",strtotime(str_replace('/','-',$birthday))); 



                $notes = $values['notes'];


                $data = array(
                    'name' => $name,
                    'gender' => $gender,
                    'convenio' => $convenio,
                    'birthday' => $birthday,
                );


                if ($customerModel->editar($data, $id)) {
                    $usuarioBuscado = $customerModel->find($this->_getParam('id'));

                    $row = $usuarioBuscado->current();

                    $row['birthday'] = date('d/m/Y', strtotime($row['birthday']));
                    $form->populate($row->toArray());


                    $this->view->titulo = "Sucesso!";
                    // $this->view->form->setAction($this->view->url());
                    // $this->view->jsonEncoded = false;
                    $this->view->form = $form;
                    $this->view->resp = "Paciente:  " . $name . ",  foi atualizado(a) com sucesso!";
                    $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-success";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;
                } else {

                    $usuarioBuscado = $customerModel->find($this->_getParam('id'));

                    $row = $usuarioBuscado->current();

                    $row['birthday'] = date('d/m/Y', strtotime($row['birthday']));
                    $form->populate($row->toArray());



                    // $this->view->form = $form;
                    $this->view->titulo = "Sinto Muito!";

                    $this->view->resp = "Paciente:  " . $name . ", não pode ser atualizado(a)!  Voce tem que modificar um campo.";
                    $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-danger";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;
                }
            } else {


                $form->populate($dadosFormulario);
                $this->view->form = $form;
            }
        }
    }

    public function paymentAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/payment.ini', 'form');
        $this->view->form = new Application_Form_Payment($config);
    }

    public function listarAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/search-customer.ini', 'search-customer');
        $form = new Application_Form_Customer($config);
        $pacientes = new Application_Model_DbTable_Customer();

        $lista = $pacientes->listar();
        if (count($lista)) {
            $resp = "Sucesso!";
            $alerta = "alert-success";
            $this->view->alerta = $alerta;
            $this->view->resp = $resp;


            $this->view->listaPacientes = $lista;
            $form->setAction('/default/customer/buscar/');
            $this->view->form = $form;
        } else {

            $resp = "Paciente não encontrado";
            $alerta = "alert-danger";
            $this->view->resp = $resp;
            $this->view->alerta = $alerta;
            $form->setAction('/default/customer/buscar/');
            $this->view->form = $form;
        }
    }

    public function buscarAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/search-customer.ini', 'search-customer');
        $form = new Application_Form_Customer($config);
        $pacientes = new Application_Model_DbTable_Customer();


        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {

            $id = $this->getRequest()->getParam("id", "");
            $name = $this->getRequest()->getParam("name", "");
            $status1 = $this->getRequest()->getParam("option1", "");
            $status2 = $this->getRequest()->getParam("option2", "");
            $status3 = $this->getRequest()->getParam("option3", "");










            // $pacienteBuscado = $pacientes->find($this->_getParam('id'));
            //$this->view->listaPacientes = $pacienteBuscado;

            $lista = $pacientes->buscar($id, $name, $status1, $status2, $status3);
            if (count($lista)) {
                $this->view->listaPacientes = $lista;




                $resp = "Sucesso!";
                $alerta = "alert-success";
                $this->view->alerta = $alerta;
                $this->view->resp = $resp;
                //$this->view->form = $form;
            } else {

                $resp = "Paciente não encontrado";
                $alerta = "alert-danger";
                $this->view->resp = $resp;
                $this->view->alerta = $alerta;
            }
        }
    }

    public function deletarAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/search-customer.ini', 'search-customer');
        $form = new Application_Form_Customer($config);
        $this->view->form = $form;
        $form->setAction('/default/customer/buscar/');
        $customerModel = new Application_Model_DbTable_Customer();
        $id = $this->_getParam("id");
        $name = $this->_getParam("name");

        if ($customerModel->deletar($id)) {
            $alerta = "alert-success";
            $this->view->alerta = $alerta;
            $this->view->titulo = "Sucesso!";
            // $this->view->form = $form;
            $this->view->respdel = "Paciente:  " . $name . ",  foi excluido com sucesso!";
            $resp1 = $this->view->layout()->scriptTags = '<script>
                $(function(){
                   $("#dialog").dialog({
                      modal: open
                   });
                });</script>';

            $this->view->resp1 = $resp1;
        } else {
            $alerta = "alert-danger";
            $this->view->titulo = "Sinto Muito!!";
            $this->view->alerta = $alerta;

            $this->view->respdel = "Paciente:  " . $name . ",  não pode ser excluido!";
            $resp1 = $this->view->layout()->scriptTags = '<script>
                $(function(){
                   $("#dialog").dialog({
                      modal: open
                   });
                });</script>';

            $this->view->resp1 = $resp1;
        }
    }

    public function anyAction() {
        
    }

}
