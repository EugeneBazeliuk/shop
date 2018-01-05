<?php namespace Djetson\Shop\Console;

use Illuminate\Console\Command;
use Djetson\Shop\Models\Reserve;

class ReserveCheck extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'djetshop:reservecheck';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        /** @var \October\Rain\Support\Collection $models */
        $models = Reserve::isExpired()->get();
        $models->each(function (Reserve $reserve) {
            $reserve->delete();
        });

        $this->info(sprintf('Deleted: %s', $models->count()));
    }
}
