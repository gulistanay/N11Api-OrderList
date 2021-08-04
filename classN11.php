<?php
 Class N11 {
    protected static $_appKey, $_appSecret, $_parameters, $_sclient;
    public $_debug = false;
    
    public function __construct(array $attributes = array()) {
        self::$_appKey = $attributes['appKey'];
        self::$_appSecret = $attributes['appSecret'];
        self::$_parameters = ['auth' => ['appKey' => self::$_appKey, 'appSecret' => self::$_appSecret]];
    }
    
    public function setUrl($url) {
        self::$_sclient = new \SoapClient($url);
    }

    public function orderList(array $searchData = Array()) {
        $this->setUrl('https://api.n11.com/ws/OrderService.wsdl');
        self::$_parameters['searchData'] = $searchData;
        return self::$_sclient->orderList(self::$_parameters);
    }

    public function __destruct() {
        if ($this->_debug) {
            print_r(self::$_parameters);
        }
    }   
}
