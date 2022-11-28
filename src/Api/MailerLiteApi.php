<?php
namespace WPFormsMailerLite\Api;

use WPFormsMailerLite\Api\Client;
use WPFormsMailerLite\Models\MailerLiteAccount;
use WPFormsMailerLite\Models\MailerLiteGroup;

class MailerLiteApi
{
    private $url = 'https://connect.mailerlite.com/api';
    private $client;
    private $response;
    private $response_code;

    /**
     * MailerLiteAPI constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct($api_key)
    {
        $this->client = new Client($this->url, [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);
    }

    /**
     * Validate API Key
     *
     * @access      public
     * @return      mixed
     */
    public function validateKey()
    {

        $response = $this->client->remote_get('/account');
        $response = self::parseResponse($response);
        $account  = new MailerLiteAccount();

        if ( isset($response->data) ) {
            $account->id = $response->data->id;
            $account->subdomain = '';
        }

        return $account;
    }

    /**
     * Get groups
     *
     * @access      public
     * @return      MailerLiteGroup[]
     */
    public function getGroups($params)
    {
        $response = $this->client->remote_get('/groups', $params);
        $response = self::parseResponse($response);

        $groups = [];

        if (isset($response->data)) {
            foreach ($response->data as $record) {
                $group = new MailerLiteGroup();
                $group->id = $record->id;
                $group->name = $record->name;
                $group->total = $record->active_count;
                $group->opened = $record->open_rate->float;
                $group->clicked = $record->click_rate->float;
                $group->date_created = $record->created_at;

                $groups[] = $group;
            }
        }

        return $groups;
    }

    /**
     * Check if more groups need to be loaded
     *
     * @access      public
     * @return      mixed
     */
    public function checkMoreGroups($limit, $offset)
    {
        $response = $this->client->remote_get('/groups', [
            'limit' => $limit,
            'page' => $offset
        ]);

        $response = self::parseResponse($response);

        return count( $response->data ?? [] ) > 0;
    }

    /**
     * Get more groups
     *
     * @access      public
     * @return      mixed
     */
    public function getMoreGroups($limit, $offset)
    {
        $response = $this->client->remote_get('/groups', [
            'limit' => $limit,
            'page' => $offset
        ]);

        $response = self::parseResponse($response);

        return $response->data;
    }

    /**
     * Search groups
     *
     * @access      public
     * @return      mixed
     */
    public function searchGroups($name)
    {
        $response = $this->client->remote_get('/groups?page=1&limit=10&filter[name]='.$name);

        return self::parseResponse($response);
    }

    /**
     * Add subscriber
     *
     * @access      public
     * @return      mixed
     */
    public function addSubscriber($subscriber, $resubscribe)
    {
        $response = $this->client->remote_post('/subscribers', [
            'email' => $subscriber,
            'resubscribe' => $resubscribe,
            'ip_address' => $_SERVER["REMOTE_ADDR"]
        ]);

        return self::parseResponse($response);
    }

    /**
     * Add subscriber to group (by id)
     *
     * @access      public
     * @return      mixed
     */
    public function addSubscriberToGroup($subscriber, $group_id, $resubscribe = 0)
    {
        $subscriber['groups'] = [ $group_id ];
        $subscriber['ip_address'] = $_SERVER['REMOTE_ADDR'];

        $response = $this->client->remote_post('/subscribers', $subscriber);
        $response = self::parseResponse($response);

        if( isset( $response->errors ) )
            return false;

        return true;
    }

    /**
     * Get raw response body
     *
     * @access      public
     * @return      string
     */
    public function getResponseBody()
    {
        return $this->response;
    }

    /**
     * Get response code
     *
     * @access      public
     * @return      int
     */
    public function responseCode()
    {
        return $this->response_code;
    }

    /**
     * Get response code and body
     *
     * @access      private
     * @return      mixed
     */
    private function parseResponse($response)
    {
        $this->response = wp_remote_retrieve_body($response);
        $this->response_code = wp_remote_retrieve_response_code($response);

        if (!is_wp_error($this->response)) {
            $response = json_decode($this->response);

            if (json_last_error() == JSON_ERROR_NONE) {

                if (!isset($response->error)) {
                    return $response;
                }
            }
        } else {
            $errors = $this->response->get_error_messages();
            $this->response = 'WP Error: ';

            foreach ( $errors as $code => $msg ) {

                $this->response .= $code . ': ' . $msg . '. ';
            }
        }

        return false;
    }
}