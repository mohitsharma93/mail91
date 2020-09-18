<?php
namespace Mail91;

use Mail91\GuzzleTrait;

class Domain {
    use GuzzleTrait;

    protected $validToken;
    protected $host;

    public function __construct($token) {
        $this->validToken = $token;
        $this->host = 'http://mailer.msg91.com/api/domains';
        // $this->host = 'http://mail91.com/api/domains/verify';
    }

    public function getAll($paramValue) {
        // $url = $this->host . '?per_page=10&order_by=id&order_type=DESC&group_by=id&return_type=count&with=user';
        $url = $this->host .'?'. http_build_query($paramValue);
        $data = array();
        return $this->httpCall($this->validToken, 'GET', $url, $data);
    }

    public function registerDomain($domain) {
        return $this->httpCall($this->validToken, 'POST', $this->host, $domain);
    }

    public function verifyDomain($domain) {
        return $this->httpCall($this->validToken, 'POST', $this->host, $domain);
    }

    public function getSpecific($id) {
        $valid = $this->validation($id);
        if ($valid['valid'] == 'false') {
            unset($valid['valid']);
            return $valid;
        }
        $url = $this->host . '/' . $id;
        return $this->httpCall($this->validToken, 'GET', $url, $data = array());
    }

    private function validation($id) {
        $pass = 'true'; $status = 422;
        $msg = [
            "Message" => 'Validation pass'
        ];
        if (!$id) {
            $msg = [
                "Message" => 'The given data was invalid.',
                "errors" => [
                    "id" => ["The id field is required."]
                ]
            ];
            $pass = 'false';
        }
        if (!is_numeric($id)) {
            $msg = [
                "Message" => 'The given data was invalid.',
                "errors" => [
                    "id" => ["The id field is not string."]
                ]
            ];
            $pass = 'false';
        }

        return array(
            "status" => 422,
            "data" => $msg,
            "valid" => $pass
        );
    }
}