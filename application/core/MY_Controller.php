<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2016, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

require_once APPPATH . 'third_party/community_auth/core/Auth_Controller.php';

class MY_Controller extends Auth_Controller
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();

        $this->permissions = $this->config->item('user_role_permissions');

        /**
         * This will check if a user is logged in or not.
         * If a user is not logged in than he will be redirected to login page.
         * Enforcing security before any of the controllers/methods are called.
         */
        if ($this->auth_role == null) {
            switch($this->router->method){
                case 'login':
                case 'logout':
                case 'recover':
                case 'recovery_verification':
                    if ($this->router->class == 'myauth'){
                        break;
                    }
                default:
                    $this->require_min_level(1);
            }
        }
    }

    function post_auth_hook() {

        // Don't even bother going further if nobody is logged in or its a login, logout method
        if ($this->auth_role == null || $this->router->method == 'login' || $this->router->method == 'logout' || $this->router->method == 'recover' || $this->router->method == 'recovery_verification') {
            return parent::post_auth_hook();
        }

        // For admin everything is graceland!
        if ($this->auth_role <> null && $this->auth_role == 'admin') {
            return parent::post_auth_hook();
        }

        // Get current role permissions
        $this->role_permissions = $this->get_role_permissions();

        // Check if a controller is allowed
        if ($this->is_controller_allowed() == false) {
            $this->show_permission_denied();
        }

        // Check if a controller/method is allowed
        if ($this->is_controller_method_allowed() == false) {
            $this->show_permission_denied();
        }

        return parent::post_auth_hook(); // TODO: Change the autogenerated stub
    }

    /**
     * Checks if current user role can access a Controller
     *
     * @return bool
     */
    private function is_controller_allowed() {
        // Gets all methods in current router class if nothing is found than all methods are disabled for current role
        $controller_arr_flipped     = array_flip(array($this->router->class)); // Avoid Error @ Only variables should be passed by reference
        $controller_arr_intersected = array_intersect_key($this->role_permissions, $controller_arr_flipped); // Avoid Error @ Only variables should be passed by reference

        // If no controller was defined for a role than return false
        if (empty($controller_arr_intersected) || !is_array($controller_arr_intersected)) {
            return false;
        }
        // Its allowed if we found it! Note that this only checks for existence of a class/controller and not method.
        // To check both controller/method use is_controller_method_allowed()
        return true;
    }

    /**
     * Checks if current user role can access a Controller/Method
     *
     * @return bool
     */
    private function is_controller_method_allowed() {
        // Gets all methods in current router class if nothing is found than all methods are disabled for current role
        $controller_arr_flipped     = array_flip(array($this->router->class)); // Avoid Error @ Only variables should be passed by reference
        $controller_arr_intersected = array_intersect_key($this->role_permissions, $controller_arr_flipped); // Avoid Error @ Only variables should be passed by reference
        $permissible_methods        = array_shift($controller_arr_intersected);

        // If no controller/methods were defined for a role than return false
        if (empty($permissible_methods) || !is_array($permissible_methods)) {
            return false;
        }

        // Return TRUE or FALSE based on if a method is found in $permissible_methods array with router method
        return in_array($this->router->method, $permissible_methods);
    }

    /**
     * Returns current users role permissions. Only methods!
     *
     * @return mixed
     */
    private function get_role_permissions() {
        // Get current roles permissions
        $role_arr_flipped     = array_flip(array($this->auth_role)); // Avoid Error @ Only variables should be passed by reference
        $role_arr_intersected = array_intersect_key($this->permissions, $role_arr_flipped);
        $role_perms           = array_shift($role_arr_intersected);
        return $role_perms;
    }

    public function show_permission_denied() {
        $message = "
User {$this->auth_username} does not have permission to execute this operation.<br/> Please contact <cite>admin</cite> for more!
<br /><hr>
<button onclick='javascript:window.history.go(-1);'>Go Back</button>
";
        show_error($message, 500, 'Permission Denied');
        exit(4);
    }
}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */