<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		// Load our config file into view
		$this->load->helper('file');	
		$this->load->helper('form');

		$data['file'] = read_file('/opt/smokeping/etc/config');

		$this->load->view('welcome_message', $data);


	}

	/*
		Save the config file (and back up the old one)
	*/
	public function save_file() {
		$this->load->helper('file');

		if (isset($_POST['file'])) {
	
			// Lets back up the file.
			copy("/opt/smokeping/etc/config", "/opt/smokeping/etc/config".date('Y-m-d s'));


			if ( ! write_file('/opt/smokeping/etc/config', $_POST['file'])) {
			    echo 'Unable to write the file';
			   	echo '<meta http-equiv="refresh" content="3;URL=\'/\'" />';
			} else {
				// Please forgive me for this nasty version 1 hack.
			    echo 'File written! Reload the process to take effect.';
			    echo '<meta http-equiv="refresh" content="3;URL=\'/\'" />';
			}


		} else {
		    echo "nothing posted";
		  	echo '<meta http-equiv="refresh" content="3;URL=\'/\'" />';
		}

	}

	/*
		HUP the process
	*/
	public function reload_smokeping()
	{
		$this->load->helper('file');
		// can't run this as not root
		// exec("kill -HUP 14376")


		if (write_file('/opt/smokeping/etc/HUPME/HUPME', "1")) {
			echo "process gonna get hupped, wait for it";
			echo '<meta http-equiv="refresh" content="3;URL=\'/\'" />';
		} else {
			echo "failed";
			echo '<meta http-equiv="refresh" content="3;URL=\'/\'" />';
		}
	}



}