<?php
namespace LaravelQueueLike\Queue\Connectors;

use Illuminate\Support\Arr;
use Illuminate\Queue\Connectors\DatabaseConnector;
use LaravelQueueLike\Queue\DatabaseQueue;

class QueueLikeConnector extends DatabaseConnector
{
	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Contracts\Queue\Queue
	 */
	public function connect(array $config)
	{
			return new DatabaseQueue(
					$this->connections->connection(Arr::get($config, 'connection')),
					$config['table'],
					$config['queue'],
					Arr::get($config, 'expire', 60)
			);
	}
}
