<?php
  class BaseController{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments){
      $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * GET URI elements.
     * 
     * @return array
     */
    protected function getUriSegments(){
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $uri = explode('/', $uri);

      return $uri;
    }

    /**
     * Get querystring params.
     * 
     * @return array
     */
    protected function getQuerystringParams(){
      return parse_str($_SERVER['QUERY_STRING'], $query);
    }

    /**
     * Get values passed from form.
     * 
     */
    protected function getFormParams(){
      return $_POST;
    }

    /**
     * get payload from request
     * 
    */
    protected function getPayload(){
      $payload = file_get_contents('php://input');
      return json_decode($payload, true);
    }

    /**
     * Send API output.
     * 
     * @param mixed $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array()){
      header_remove('Set_Cookie');

      if(is_array($httpHeaders) && count($httpHeaders)){
        foreach ($httpHeaders as $httpheader) {
          header($httpheader);
        }
      }

      echo $data;
      exit;
    }
  }
?>