<?php

class MY_Input extends CI_Input
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Don't choke when run from the CLI. The default implmentation attempts
     * to access $_SERVER['REMOTE_ADDR'] without first checking to see if it
     * exists.
     *
     * (non-PHPdoc)
     * @see CI_Input::ip_address()
     */
    public function ip_address()
    {
        if ($this->ip_address !== FALSE) {
            return $this->ip_address;
        }

        $proxy_ips = config_item('proxy_ips');
        if (! empty($proxy_ips)) {
            $proxy_ips = explode(',', str_replace(' ', '', $proxy_ips));
            foreach (array(
                'HTTP_X_FORWARDED_FOR',
                'HTTP_CLIENT_IP',
                'HTTP_X_CLIENT_IP',
                'HTTP_X_CLUSTER_CLIENT_IP'
            ) as $header) {
                if (($spoof = $this->server($header)) !== FALSE) {
                    // Some proxies typically list the whole chain of IP
                    // addresses through which the client has reached us.
                    // e.g. client_ip, proxy_ip1, proxy_ip2, etc.
                    if (strpos($spoof, ',') !== FALSE) {
                        $spoof = explode(',', $spoof, 2);
                        $spoof = $spoof[0];
                    }

                    if (! $this->valid_ip($spoof)) {
                        $spoof = FALSE;
                    } else {
                        break;
                    }
                }
            }

            $this->ip_address = ($spoof !== FALSE && in_array($_SERVER['REMOTE_ADDR'], $proxy_ips, TRUE)) ? $spoof : $_SERVER['REMOTE_ADDR'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $this->ip_address = $_SERVER['REMOTE_ADDR'];
            } else {
                $this->ip_address = '0.0.0.0';
            }
        }

        if (! $this->valid_ip($this->ip_address)) {
            $this->ip_address = '0.0.0.0';
        }

        return $this->ip_address;
    }
}