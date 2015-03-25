<?php
/**
 * Dummy authenticator puts stores dummy credentials in the sessalways returns true.
 *
 */
class Passthrough_authenticator
{

    public function is_authenticated() {
        return TRUE;
    }

    public function authenticate()
    {
        $this->ci =& get_instance();
        $user_info = array(
            'cn' => 'Dummy User',
            'username' => 'username',
            'is_authenticated' => true
        );
        $this->ci->session->set_userdata($user_info);

    }

    public function username()
    {
        return 'zburke';
    }

    public function name()
    {
        return 'Zak Burke';
    }
}
