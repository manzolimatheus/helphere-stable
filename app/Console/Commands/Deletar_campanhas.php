<?php

namespace App\Console\Commands;

use App\Models\Campanha;
use Illuminate\Console\Command;

class Deletar_campanhas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campanhas:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleta todas as campanhas que passam da validade';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Campanha::where('data_fim', '<', date('Y-m-d'))->each(function ($item) {
            $item->delete();
        });
    }
}
