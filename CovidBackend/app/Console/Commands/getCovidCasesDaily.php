<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\State;
use App\Cases;

class getCovidCasesDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getCovidCasesDaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule to get covid cases daily.';

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
        //

        $result = $this->getCovidCases();

        foreach($result as $key => $values){
            $state = State::where('name' , '=' , $key)->first();
            $latestData = $values[count($values)-1];

            $exists = Cases::where('date' , '=' , $latestData['date'])->where('state_id' , '=' , $state->id)->first();

            if(!$exists){
                $case = new Cases();
                $case->date = $value['date'];
                $case->state_id = $state->id;
                $case->confirmed = $value['confirmed'];
                $case->deaths = $value['deaths'];
                $case->recovered = $value['recovered'];
                $case->save();
            }
        }

    }

    protected function getCovidCases(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://pomber.github.io/covid19/timeseries.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($result,true);
        return $result;
    }
}
