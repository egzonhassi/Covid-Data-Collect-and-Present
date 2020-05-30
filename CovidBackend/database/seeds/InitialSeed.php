<?php

use Illuminate\Database\Seeder;
use App\Cases;
use App\State;

class InitialSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = $this->getCovidCases();

        foreach($result as $key => $values){
            $state = new State();
            $state->name = $key;
            $state->save();
            foreach($values as $value){
                $case = new Cases();
                $case->date = $value['date'];
                $case->state_id = $state->id;
                $case->confirmed = $value['confirmed'];
                $case->deaths = $value['deaths'];
                $case->recovered = $value['recovered'];
                $case->save();
            }
        }

        return $result;
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
