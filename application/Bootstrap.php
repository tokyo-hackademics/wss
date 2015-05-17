<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDb()
    {

		$options = new Zend_Config($this->getOptions());

		$connect = Zend_Db::factory(
		    $options->db->default->adapter,
		    $options->db->default->params
		);

		Zend_Db_Table::setDefaultAdapter($connect);

		Zend_Registry::set('db', $connect);
    }
}

