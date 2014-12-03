<?php

require_once('./includes/nusoap.php');

class connector1 {

    private $userId = '';
    private $password = '';
    private $environmentId = '';
    private $connectorId = '';
    private $filtersXml = '';
    private $url_get = 'https://profitweb.afasonline.nl/profitservices/getconnector.asmx?WSDL';
    private $url_get_local = 'http://pnawi.afasgroep.nl/profitservices/getconnector.asmx?WSDL';
    private $url_update_aol = 'https://profitweb.afasonline.nl/profitservices/updateconnector.asmx?WSDL';
    private $url_update_local = 'http://pnawi.afasgroep.nl/profitservices/updateconnector.asmx?WSDL';

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEnvironmentId() {
        return $this->environmentId;
    }

    public function setEnvironmentId($environmentId) {
        $this->environmentId = $environmentId;
    }

    public function getConnectorId() {
        return $this->connectorId;
    }

    public function setConnectorId($connectorId) {
        $this->connectorId = $connectorId;
    }

    public function getFiltersXml() {
        return $this->filtersXml;
    }

    public function setFiltersXml($filtersXml) {
        $this->filtersXml = $filtersXml;
    }

    public function get_aol() {
        $client = new nusoap_client($this->url_get, 'wsdl');
        $client->setCredentials('AOL\\' . $this->userId, $this->password, 'ntlm');
        $client->soap_defencoding = 'ISO-8859-1';


        $args = array(
            'userId' => $this->userId,
            'password' => $this->password,
            'environmentId' => $this->environmentId,
            'connectorId' => $this->connectorId,
            'options' => '<options><Outputmode>1</Outputmode><Metadata>1</Metadata><OutputOptions>2</OutputOptions></options>',
            'filtersXml' => $this->filtersXml
        );

        $result = $client->Call('GetDataWithOptions', $args);

//foutcontrole
        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }


        $xml_string = $result['GetDataWithOptionsResult'];
        return $xml_string;
    }

    public function get_local() {

        $client = new nusoap_client($this->url_get_local, 'wsdl');
        $client->soap_defencoding = 'ISO-8859-1';

        $args = array(
            'userId' => $this->userId,
            'password' => $this->password,
            'environmentId' => $this->environmentId,
            'connectorId' => $this->connectorId,
            'options' => '<options><Outputmode>1</Outputmode><Metadata>1</Metadata><OutputOptions>2</OutputOptions></options>',
            'filtersXml' => $this->filtersXml
        );

  
        $result = $client->Call('GetDataWithOptions', $args);

//foutcontrole
        if ($client->fault) {
            echo '<h2>Fault</h2><pre>';
            print_r($result);
            echo '</pre>';
        } else {
            $err = $client->getError();
            if ($err) {
                echo '<h2>Error</h2><pre>' . $err . '</pre>';
            }
        }


        $xml_string = $result['GetDataWithOptionsResult'];
        return $xml_string;
    }

    public function update_aol($xml_update, $connectorType) {
        
        $client = new nusoap_client($this->url_update_aol, 'wsdl');
        $client->setCredentials('AOL\\' . $this->userId, $this->password, 'ntlm');
        $client->soap_defencoding = 'ISO-8859-1';

        $args = array(
            'userId' => $this->userId,
            'password' => $this->password,
            'environmentId' => $this->environmentId,
            'connectorType' => $connectorType,
            'logonAs' => '',
            'connectorVersion' => '1',
            'dataXml' => $xml_update
        );
        
        $result = $client->Call('Execute', $args);
        
        //foutcontrole
        
        if(isset($result)) {
            return $result;
        } else {
            $err = $client->getError();
            if ($err) {
                return $err;
            } else {
                return 'Update Succesvol';
            }
        }
        
       //$result = $result['detail']["ProfitApplicationException"];
       //var_dump($result);
       //return $result;
    }

    public function update_local($xml_update, $connectorType) {

        $client = new nusoap_client($this->url_update_local, 'wsdl');
        $client->soap_defencoding = 'ISO-8859-1';

        $args = array(
            'userId' => 'awi',
            'password' => '',
            'environmentId' => 'ERPDEMO',
            'connectorType' => $connectorType,
            'logonAs' => '',
            'connectorVersion' => '1',
            'dataXml' => $xml_update
        );

        $result = $client->Call('Execute', $args);

        
        //foutcontrole
        if ($client->fault) {
            return $result;
        } else {
            $err = $client->getError();
            if ($err) {
                return $err;
            } else {
                return 'Update Succesvol';
            }
        }
    }

}

?>       