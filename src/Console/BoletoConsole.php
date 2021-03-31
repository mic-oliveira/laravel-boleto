<?php


namespace Boleto\Console;


use Illuminate\Console\Command;

class BoletoConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boleto:install
                            {--force : Sobrecreve todas as migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Iugu';

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
        if($this->option('force'))
        {
            $this->call('migrate:fresh',
                [
                    '--database'=>config('boleto.connection'),
                    '--path'=>'/vendor/michaelferreira/laravel-boleto/src/migrations'
                ]
            );
        } else {
            $this->call('migrate',
                [
                    '--database'=>config('boleto.connection'),
                    '--path'=>'/vendor/michaelferreira/laravel-boleto/src/migrations'
                ]
            );
        }

    }
}
