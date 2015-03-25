<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// default authenticator; may be overridden by FCPATH/config/application.php
$config['authenticator'] = 'Ldap_authenticator';

// default authorizer; may be overridden by FCPATH/config/application.php
$config['authorizer'] = 'Array_authorizer';

// authorized users; overridden by in FCPATH/config/application.php
$config['authorized_users'] = array();


// pull in credentials from the config file at the application root,
// which is not part of the repo. see FCPATH/config/application.php-default
// for details on what should be stored there.
require_once FCPATH . 'config/application.php';

// LDAP/AD authentication config
$config['ldap_host']    = 'hshsl-staff.umaryland.edu';
$config['ldap_base_dn'] = 'OU=HSHSL Staff,DC=hshsl-staff,DC=umaryland,DC=edu';
$config['ldap_filter']  = '(samaccountname={USERNAME})';
$config['ldap_fields']  = array('cn');
