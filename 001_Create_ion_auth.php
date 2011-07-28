<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_ion_auth extends	Migration {
	
	// Table names
	private $groups			= 'groups';
	private $meta 			= 'meta';
	private $users			= 'users';
	// Join names
	private $groups_join	= 'group_id';
	private $users_join		= 'user_id';
	
	function up() {	
		/*
		* In order to  add default data with migrations 
		*/
		$this->load->library('database');
		
		$this->migrations->verbose AND print "Creating ion auth default tables...";

		// groups
		if (!$this->db->table_exists($this->groups)) {	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => FALSE),
				'description' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE)
			));
			// create table
			$this->dbforge->create_table($this->groups, TRUE);
			
			// default data
			$this->db->insert($this->groups, array('id'=>null,'name'=>'admin','description'=>'Administrator'));
			$this->db->insert($this->groups, array('id'=>null,'name'=>'members','description'=>'General User'));
		}

		// meta
		if (!$this->db->table_exists($this->meta)) {	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			// Define custom meta data here
			$this->dbforge->add_field(array(
				'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
				"$this->users_join" => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => FALSE, 'null' => TRUE),
				'first_name' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
				'last_name' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
				'company' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
				'phone' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE)
			));
			// create table
			$this->dbforge->create_table($this->meta, TRUE);
			
			// default data
			$data = array(
				"$this->users_join" => "1",
				'first_name' => "Admin",
				'last_name' => "istrator",
				'company' => "ADMIN",
				'phone' => "0"
			);
			$this->db->insert($this->meta, $data);
		}
		

		// users
		if (!$this->db->table_exists($this->users)) {	
			// Setup Keys
			$this->dbforge->add_key('id', TRUE);
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
				"$this->groups_join" => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE),
				'ip_address' => array('type' => 'CHAR', 'constraint' => '16', 'null' => FALSE),
				'username' => array('type' => 'VARCHAR', 'constraint' => '15', 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => FALSE),
				'salt' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'email' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
				'activation_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'forgotten_password_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'remember_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'created_on' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => FALSE),
				'last_login' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE),
				'active' => array('type' => 'tinyint', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE)
			));
			// create table
			$this->dbforge->create_table($this->users, TRUE);
			
			// default data
			$data = array(
				"$this->groups_join"=>'1',
				'ip_address'=>'127.0.0.1',
				'username'=>'administrator',
				'password'=>'59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4',
				'salt'=>'9462e8eee0',
				'email'=>'admin@admin.com',
				'activation_code'=>'',
				'forgotten_password_code'=>NULL,
				'created_on'=>'1268889823',
				'last_login'=>'1268889823',
				'active'=>'1'
			);
			$this->db->insert($this->users, $data);
		}
	}

	function down() {
		$this->dbforge->drop_table($this->groups);
		$this->dbforge->drop_table($this->meta);
		$this->dbforge->drop_table($this->users);
	}
}
