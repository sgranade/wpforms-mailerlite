<?php

namespace WPFormsMailerLite\Api;

class Client
{
    private $url;
    private $headers;
    private $useragent = 'WPForms-MailerLite/' . WPFORMSMAILERLITE_VERSION;

    /**
     * Client constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct($url, $headers)
    {
        $this->url = $url;
        $this->headers = $headers;
    }

    /**
     * Client for GET requests
     *
     * @access      public
     */
    public function remote_get($endpoint, $args = [])
    {

        $args['body'] = $args;
        $args['headers'] = $this->headers;
        $args['user-agent'] = $this->useragent;

        return wp_remote_get($this->url.$endpoint, $args);
    }

    /**
     * Client for POST requests
     *
     * @access      public
     */
    public function remote_post($endpoint, $args = [])
    {

        $params = [];
        $params['headers'] = $this->headers;
        $params['body'] = json_encode( $args );
        $params['user-agent'] = $this->useragent;

        return wp_remote_post($this->url.$endpoint, $params);
    }
}