<?php
namespace LaravelQueueLike\Queue;

use Illuminate\Queue\DatabaseQueue as OriginalDatabaseQueue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Expression;

class DatabaseQueue extends OriginalDatabaseQueue
{

  /**
   * Release the jobs that have been reserved for too long.
   *
   * @param  string  $queue
   * @return void
   */
  protected function releaseJobsThatHaveBeenReservedTooLong($queue)
  {
      if (random_int(1, 10) < 10) {
          return;
      }

      $this->database->beginTransaction();

      $stale = $this->database->table($this->table)
                  ->lockForUpdate()
                  ->where('queue', 'like', $this->getQueue($queue))
                  ->where('reserved', 1)
                  ->where('reserved_at', '<=', Carbon::now()->subSeconds($this->expire)->getTimestamp())
                  ->get();

      $this->database->table($this->table)
          ->whereIn('id', Collection::make($stale)->pluck('id')->all())
          ->update([
              'reserved' => 0,
              'reserved_at' => null,
              'attempts' => new Expression('attempts + 1'),
          ]);

      $this->database->commit();
  }

  /**
   * Get the next available job for the queue.
   *
   * @param  string|null  $queue
   * @return \StdClass|null
   */
  protected function getNextAvailableJob($queue)
  {
      $job = $this->database->table($this->table)
                  ->lockForUpdate()
                  ->where('queue', 'like', $this->getQueue($queue))
                  ->where('reserved', 0)
                  ->where('available_at', '<=', $this->getTime())
                  ->orderBy('id', 'asc')
                  ->first();

      return $job ? (object) $job : null;
  }

}
