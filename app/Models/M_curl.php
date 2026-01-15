<?php 

namespace App\Models; 
use CodeIgniter\Model; 

class M_curl extends Model { 
    protected $table = 'users'; 
    
    public function __construct() 
    { 
        helper('lang'); 
        $this->session = \Config\Services::session(); 
    } 
    
    public function curl_config($url, $method='POST', $post=null) 
    { 
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array( 
            CURLOPT_URL => "http://192.168.10.67/majsf_rest_api/" . $url, 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_TIMEOUT => 50, 
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => $method, 
            CURLOPT_HTTPHEADER => array( 
                "Content-Type: application/x-www-form-urlencoded", 
                "Authorization: Bearer {$this->session->get('token')}" 
            ),
        )); 
        if ($post != null) { 
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post)); 
        } 
        
        $response = curl_exec($curl); 
        curl_close($curl); 
        return json_decode($response, TRUE); 
    } 
    
    public function refresh_token() 
    { 
        $curl = curl_init(); 
        curl_setopt_array($curl, array( 
            CURLOPT_URL => "http://192.168.10.67/majsf_rest_api/api/auth/login", 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 50, 
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => "POST", 
            CURLOPT_POSTFIELDS => array('username' => 'administrator', 'password' => 'ult1m4t3'), )); 
            
        $response = curl_exec($curl); 
        curl_close($curl); 
        $response = json_decode($response, TRUE); 
        $this->session->set($response); 
            
        return $response; 
    } 
        
    public function execute($method, $SAP_PARAMS) 
    { 
        if ($this->isTokenExpired()) { 
            $this->refresh_token(); 
        } 
            
        $url = "api/sap/execute"; 
        $response = $this->curl_config($url, $method, $SAP_PARAMS); 
            
        return $response; 
    } 
        
    private function isTokenExpired() 
    { 
        return !$this->session->get('token') || $this->session->get('token_expired'); 
    } 
        
    public function execute_array($method, $SAP_PARAMS) 
    { 
        $this->refresh_token(); 
            
        $url = "api/sap/execute_array"; 
        $response = $this->curl_config($url, $method, $SAP_PARAMS); 
            
        return $response; 
    } 
        
    public function insertDataToSAP($data) 
    { 
        $this->refresh_token(); 
            
        $curl = curl_init(); 
        curl_setopt_array($curl, array( 
            CURLOPT_URL => 'http://192.168.10.67/majsf_rest_api/api/sap/execute', 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 50, 
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_POSTFIELDS, 
            json_encode($data), 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => 'POST', 
            CURLOPT_HTTPHEADER => array( 
                "Content-Type: application/x-www-form-urlencoded", 
                "Authorization: Bearer {$this->session->get('token')}" 
            ), 
        )); 
            
        $response = curl_exec($curl); 
        curl_close($curl); 
            
        return json_decode($response, TRUE); 
    } 
} 

?>