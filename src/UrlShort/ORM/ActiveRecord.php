<?php

namespace Bisix21\src\UrlShort\ORM;

use Bisix21\src\Core\Config;
use Illuminate\Database\Capsule\Manager;

class ActiveRecord
{
	public array $configDbConnection;

	public function __construct(
	)
	{
		$this->configDbConnection = Config::instance()->get('config.db_connection.active_record');
		$this->connectToDB();
	}

	public function connectToDB(): void
	{
		$manager = new Manager();
		$manager->addConnection($this->configDbConnection);
		$manager->setAsGlobal();
		$manager->bootEloquent();
	}
}