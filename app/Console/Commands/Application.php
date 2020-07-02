<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\User;
use Carbon\Carbon;
class Application extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application Installation';

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
     * @return mixed
     */
    public function handle()
    {
        if($this->confirm('Do you want install application web system information school ?')){
            if($this->confirm('Has been creating database with name ' . env('DB_DATABASE') . '?')){
                $this->info('Install migrate table...');
                $this->call('migrate:install');
                $this->call('migrate');
                $this->info('Successfuly to install migrate table...');
                $name = $this->ask('What your name ?');
                $email = $this->ask('What your email ?');
                $nisn = $this->ask('Input your NISN ?');
                $gender = $this->choice('Your gender ?', ['Male', 'Female']);
                $pw = $this->secret('Your password ?');
                $this->info('Create a users...');
                if($gender == 0) {
                    User::create([
                        'id' => '1',
                        'sc_school_id' => '1',
                        'name' => $name,
                        'email' => $email,
                        'nisn' => $nisn,
                        'password' => bcrypt($pw),
                        'role' => 'administrator',
                        'born' => Carbon::now(),
                        'location' => 'indonesia',
                        'avatar' => 'avatar.png',
                        'languange' => 'en',
                        'gender' => 'male',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                if($gender == 1) {
                    User::create([
                        'id' => '1',
                        'sc_school_id' => '1',
                        'name' => $name,
                        'email' => $email,
                        'nisn' => $nisn,
                        'password' => bcrypt($pw),
                        'role' => 'administrator',
                        'born' => Carbon::now(),
                        'location' => 'indonesia',
                        'avatar' => 'avatar.png',
                        'languange' => 'en',
                        'gender' => 'female',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
                $this->info('Create users successfuly...');
                $this->info('Create a seed database...');
                $this->call('db:seed');
                $this->info('Creating seed successfuly...');
                $this->info('Create token api');
                $this->call('passport:install', ['--force' => true]);
                $this->info('Create token api successfuly');
                $this->info('Thanks your for using this application');
                $this->info('Copyright 2020 @Ferdiansyah');
                if($this->confirm('Do you want start application ?')){
                    $this->call('serve');
                } else {
                    $this->info('OK');
                }
            }else{
                $this->error('Please created database before instalation');
            }
        }
    }
}
