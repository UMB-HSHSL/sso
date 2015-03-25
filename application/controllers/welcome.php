<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        // load requested authenticator and check if the user is already authenticated.
        $this->load->add_package_path(APPPATH.'third_party/authenticator/');
        $this->load->library(config_item('authenticator'), array(), 'authenticator');
        $this->load->remove_package_path();
    }


    /**
     *
     * @param string $app nick-name of the app the user should be redirected to on success
     */
    public function index($app = NULL)
    {
        $rules = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim'
            )
        );

        $this->form_validation->set_rules($rules);


        // handle already-authenticated users
        if ($this->authenticator->is_authenticated()) {
            $this->handle_redirect($app);
        }
        // handle an authentication request
        elseif ($this->is_post() && $this->form_validation->run()) {
            $this->authenticate($this->input->post('username'), $this->input->post('password'));
        }
        // show the authentication form
        else {
            $this->template->title = 'Sign In';
            $this->template->content->view('index', array('app' => $app));
            $this->template->publish();
        }
    }


    /**
     * Authenticate the user and redirect to the requested app, or set a
     * flash-error-message and redisplay the login page.
     */
    private function authenticate($username, $password)
    {
        try {
            $this->authenticator->authenticate($username, $password);
            $this->handle_redirect($this->input->post('app'));
        }
        catch (Authentication_exception $e) {
            $this->logger->warn("Authentication failure for {$username}");
            flash_message('error', "Authentication error: " . $e->getMessage());
            redirect('/');
        }
    }

    /**
     * Redirect to the requested application on success, or to the homepage
     * if no application was specified.
     * @param string $app
     */
    private function handle_redirect($app)
    {
        $apps = config_item('apps');

        if (array_key_exists($app, $apps)) {
            redirect($apps[$app]);
        }

        redirect('https://www.hshsl.umaryland.edu');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
