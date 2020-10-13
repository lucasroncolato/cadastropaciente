<?php

class CustomerController extends Zend_Controller_Action {

    /**
     * @var Zend_Log
     */
    private $logger = null;

    public function init() {
        //$this->logger = Zend_Registry::get('logger');
        $messages = $this->_helper->flashMessenger->getMessages();
        if (!empty($messages)) {
            $this->_helper->layout->getView()->message = $messages[0];
        }      
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
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-left:60px;')),
        ));


        $form->addDisplayGroup(array('convenio', 'birthday'), 'cadastro2');
        $create2 = $form->getDisplayGroup('cadastro2');
        $create2->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-left:60px;'))
        ));

        $form->addDisplayGroup(array('gender'), 'cadastro3');
        $create3 = $form->getDisplayGroup('cadastro3');
        $create3->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-left:60px;padding-right: 60px;'))
        ));

        $form->addDisplayGroup(array('submit'), 'cadastro4');
        $create4 = $form->getDisplayGroup('cadastro4');
        $create4->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:right;padding-bottom:10px;padding-right:60px'))
        ));

        $form->addDisplayGroup(array('reset'), 'cadastro5');
        $create5 = $form->getDisplayGroup('cadastro5');
        $create5->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:right;padding-bottom:10px;'))
        ));


        $form->getElement('cpf')->setAttrib('required', 'required');
        $form->getElement('name')->setAttrib('required', 'required');

        // $form->getElement('reset')->removeDecorator('reset');
        //   $form->getElement('submit')->removeDecorator('submit');


        /*

          $form->getElement('cpf')->addValidator('regex', false, array('/^[0-9]/i')); */



        // $this->view->form->setAction($this->view->url());
        // $this->view->jsonEncoded = true;
        //$this->view->json_encode = true;
        $this->view->form = $form;


        $dadosFormulario = $this->getRequest()->getPost();
        if ($this->_request->isPost()) {
            if ($form->isValid($dadosFormulario)) {
                $values = $form->getValues();
                // var_dump($values['gender']);
                //  $formData = $this->getRequest()->getPost();




                $this->view->id = $id;
                $cpf = $values['cpf'];
                $name = $values['name'];


                $convenio = $values['convenio'];
                $birthday = $values['birthday'];
                $birthday = date("Y-m-d", strtotime(str_replace('/', '-', $birthday)));


                $data = array(
                    'cpf' => $cpf,
                    'name' => $name,                    
                    'convenio' => $convenio,                    
                    'birthday' => $birthday,
                );


                $cadastro = new Application_Model_DbTable_Customer();
                if ($cadastro->gravar($data)) {



                    $last_id = $cadastro->getAdapter()->lastInsertId();


                    $this->view->last_id = $last_id;

                    // $this->view->resp = "Nome:  " . $name . ", enviado com sucesso!";
                    //   $form->populate($formData);
                    $this->view->titulo = "Sucesso!";
                    // $this->view->form = $form;

                    $this->view->resp = "Paciente:  " . $name . ",  foi cadastrado(a) com sucesso!";
                    $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-success";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;
                    $form->populate($dadosFormulario);

                    $this->view->form = $form;
                } else {
                    // $this->view->resp = "Nome:  " . $name . ", nao foi gravado!";
                    // $form->populate($values);
                    $this->view->titulo = "Sinto Muito!";

                    $this->view->resp = "Paciente:  " . $name . "Nao pode ser cadastrado!";
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
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-left:60px;')),
        ));

        $form->addDisplayGroup(array('convenio', 'birthday'), 'cadastro2');
        $create2 = $form->getDisplayGroup('cadastro2');
        $create2->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-left:60px;'))
        ));

        $form->addDisplayGroup(array('gender'), 'cadastro3');
        $create3 = $form->getDisplayGroup('cadastro3');
        $create3->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-left:60px;padding-right:60px'))
        ));

        $form->addDisplayGroup(array('submit'), 'cadastro4');
        $create4 = $form->getDisplayGroup('cadastro4');
        $create4->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:left;padding-left:60px;padding-bottom:10px;'))
        ));

        $form->addDisplayGroup(array('reset'), 'cadastro5');
        $create5 = $form->getDisplayGroup('cadastro5');
        $create5->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-bottom:10px;'))
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
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:right;padding-right:60px;padding-bottom:10px;'))
        ));







        // $form->getElement('cpf')->setAttrib('required', 'required');

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

        
                $birthday = $values['birthday'];
                $birthday = date("Y-m-d", strtotime(str_replace('/', '-', $birthday)));


                $data = array(
                    'name' => $name,
                    'birthday' => $birthday,
                );


                if ($customerModel->editar($data, $id)) {
                    $usuarioBuscado = $customerModel->find($this->_getParam('id'));

                    $row = $usuarioBuscado->current();
                    $row['birthday'] = date('d/m/Y', strtotime($row['birthday']));

                    $row['convenio'] = $row['convenio'];
                    // $row['monthly_payment'] = str_replace(".", ",", $row['monthly_payment']);
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
                    $row['convenio'] = $row['convenio'];
                    $form->populate($row->toArray());



                    // $this->view->form = $form;
                    $this->view->titulo = "Sinto Muito!";

                    $this->view->resp = "Paciente:  " . $name . ", não pode ser atualizado(a)!<br>Voce deve 1º alterar um campo.";
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

    public function listarAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/search-customer.ini', 'search-customer');
        $form = new Application_Form_Customer($config);
        $paciente = new Application_Model_DbTable_Customer();

        $lista = $paciente->listar();
        if (count($lista)) {
            $resp = "Sucesso!";
            $alerta = "text-success";
            $this->view->alerta = $alerta;
            $this->view->resp = $resp;
            $this->view->listaPacientes = $lista;
            $form->setAction('/default/customer/buscar/');
            $this->view->form = $form;
        } else {

            $resp = "Não existem Paciente cadastrados!";
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
        $paciente = new Application_Model_DbTable_Customer();

        $form->addDisplayGroup(array('id', 'name', 'option1', 'option2', 'option3'), 'cadastro6');
        $create6 = $form->getDisplayGroup('cadastro6');
        $create6->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;'))
        ));


        $form->addElement('button', 'Pesquisar');


        $form->addElement('reset', 'Limpar');
        $form->addDisplayGroup(array('Pesquisar'), 'cadastro7');
        $create7 = $form->getDisplayGroup('cadastro7');
        $create7->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:left;padding-bottom:10px;'))
        ));

        $form->addDisplayGroup(array('Limpar'), 'cadastro8');
        $create8 = $form->getDisplayGroup('cadastro8');
        $create8->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-bottom:10px;'))
        ));

        $form->getElement('Limpar')->setAttrib("class", "btn btn-info icon-info");
        $form->getElement('Pesquisar')->setAttrib("class", "btn btn-success icon-search");
        $form->getElement('Pesquisar')->setAttrib("onClick", "document.search.submit();");









        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {


            $id = $this->getRequest()->getParam("id");
            $name = $this->getRequest()->getParam("name");
            $option1 = $this->getRequest()->getParam("option1", "");
            $option2 = $this->getRequest()->getParam("option2", "");
            $option3 = $this->getRequest()->getParam("option3", "");










            // $pacienteBuscado = $paciente->find($this->_getParam('id'));
            //$this->view->listaPacientes = $pacienteBuscado;

            $lista = $paciente->buscar($id, $name, $option1, $option2, $option3);
            if (count($lista)) {
                $this->view->listaPacientes = $lista;
                $resp = "Sucesso!";
                $alerta = "text-success";
                $this->view->alerta = $alerta;
                $this->view->alerta = $alerta;
                $this->view->resp = $resp;
                //$this->view->form = $form;
            } else {

                $resp = "Paciente não encontrado!";
                $alerta = "text-error";
                $this->view->resp = $resp;
                $this->view->alerta = $alerta;
            }
        }
    }

    public function deletarAction() {
        //  $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/search-customer.ini', 'search-customer');
        // $form = new Application_Form_Customer($config);
        //$form->setAction('default/customer/deletar');
        $customerModel = new Application_Model_DbTable_Customer();

        $id = $this->_getParam("id");
        $name = $this->_getParam("name");
        $this->view->id = $id;
        $this->view->name = $name;

        if ($this->getRequest()->getParam("excluir")) {
            $del = $this->_getParam("id");
            $name = $this->_getParam("name");
            if ($customerModel->deletar($del)) {
                $alerta = "alert-success";
                $this->view->alerta = $alerta;
                $this->view->titulo = "Sucesso!";
                // $this->view->form = $form;
                $this->view->resp = "Paciente:  " . $name . ",  foi excluido com sucesso!";
                //$resp1 = $this->view->layout()->scriptTags = '<script>
                //   $(function(){
                //     $("#dialog").dialog({
                //     modal: open
                //    });
                //   });</script>';
                // $this->view->resp1 = $resp1;
            } else {
                $alerta = "alert-danger";
                $this->view->titulo = "Sinto Muito!!";
                $this->view->alerta = $alerta;

                $this->view->resp = "Paciente:  " . $name . ",  não pode ser excluido!";
                //   $resp1 = $this->view->layout()->scriptTags = '<script>
                //     $(function(){
                //       $("#dialog").dialog({
                //          modal: open
                //        });
                //    });</script>';
                //     $this->view->resp1 = $resp1;
                $this->_redirect('default/customer/buscar');
            }
        }
    }

    public function paymentAction() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/payment.ini', 'form');
        $form = new Application_Form_Payment($config);
        $customerModel = new Application_Model_DbTable_Customer();
        $paciente = new Application_Model_DbTable_Payment();

        $form->addElement('button', 'Pesquisar');
        $form->addElement('reset', 'Limpar');
        $form->addDisplayGroup(array('customer', 'name', 'Pesquisar'), 'cadastro9');
        $create9 = $form->getDisplayGroup('cadastro9');
        $create9->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;'))
        ));
        $form->getElement('Pesquisar')->setAttrib("class", "btn btn-info icon-search");
        $form->getElement('Limpar')->setAttrib("class", "btn btn-info");
        $form->getElement('Pesquisar')->setAttrib("id", "Pesquisar");



        $form->addElement('submit', 'Adicionar');
        $form->getElement('Limpar')->setAttrib("id", "Limpar");
        $form->getElement('customer')->setAttrib('required', 'required');
        $form->getElement('value')->setAttrib('required', 'required');
         $form->getElement('name')->setAttrib('required', 'required');
         $form->getElement('customer')->setAttrib('placeholder', 'Busca pela ID');
          $form->getElement('name')->setAttrib('placeholder', 'Busca pelo Nome do Paciente');


        $form->addDisplayGroup(array('date', 'value', 'description'), 'cadastro10');
        $create10 = $form->getDisplayGroup('cadastro10');
        $create10->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:left;padding-bottom:10px;'))
        ));

        $form->addDisplayGroup(array('Limpar'), 'cadastro11');
        $create11 = $form->getDisplayGroup('cadastro11');
        $create11->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'clear:left;float:left;padding-bottom:10px;'))
        ));

        $form->addDisplayGroup(array('Adicionar'), 'cadastro12');
        $create12 = $form->getDisplayGroup('cadastro12');
        $create12->setDecorators(array(
            'FormElements',
            'Fieldset',
            array('HtmlTag', array('tag' => 'div', 'style' => 'float:left;padding-bottom:10px;'))
        ));


        $form->getElement('Adicionar')->setAttrib("class", "btn btn-success");
        // $form->getElement('Adicionar')->setAttrib("onClick", "document.payment.submit();");


        $this->view->form = $form;

        $dadosFormulario = $this->getRequest()->getPost();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($dadosFormulario)) {
                $values = $form->getValues();




                $nome = $values['name'];
                $customer = $values['customer'];


                $description = $values['description'];
                $date = $values['date'];

                $value = $values['value'];
                $valor = str_replace(".", "", $value);
                $value = str_replace(",", ".", $valor);
                $data = array(
                    'customer' => $customer,
                    'description' => $description,
                    'value' => $value,
                );

                $dbPayment = new Application_Model_DbTable_Payment();
                if ($dbPayment->gravaPayment($data)) {



                    // $last_id = $cadastro->getAdapter()->lastInsertId();
                    // $this->view->last_id = $last_id;
                    // $this->view->resp = "Nome:  " . $name . ", enviado com sucesso!";
                    //   $form->populate($formData);
                    $this->view->titulo = "Sucesso!";
                    $this->view->form = $form;

                    $this->view->resp = "O Pagamento do Paciente: " . $nome . ", foi registrado com sucesso!";
                    $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-success";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;


                    //$this->view->form = $form;
                } else {
                    // $this->view->resp = "Nome:  " . $name . ", nao foi gravado!";
                    // $form->populate($values);
                    $this->view->titulo = "Sinto Muito!";

                    $this->view->resp = "O Pagamento do Paciente: " . $nome . ", Nao pode ser registrado!";
                    $resp1 = $this->view->layout()->scriptTags = '<script>
                        $(function(){
                           $("#dialog").dialog({
                              modal: open
                           });
                        });</script>';
                    $alerta = "alert-danger";
                    $this->view->alerta = $alerta;
                    $this->view->resp1 = $resp1;
                    $form->populate($dadosFormulario);
                    $this->view->form = $form;
                }
            }
        } else {

            $form->populate($dadosFormulario);
            $this->view->form = $form;
        }
    }

}
