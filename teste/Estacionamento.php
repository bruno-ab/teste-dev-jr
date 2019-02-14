<?php
class Estacionamento
{
    public $numberOfCars;
    public $tickets;
    public $vacancies;
    
    public function generateTicket($carPlate)
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        
        return md5($carplate.$date);
    }

    public function registerCar($carPlate)
    {   
        if($hasVacancies){
            $this->manageSpots("in");
            return $this->generateTicket($carPlate);
        }
        
    }

    public function removeCar($ticketOut,$carPlate,$time)
    {
      if(md5($carplate.$ticketOut->time) == $this->ticket->md5){
            $this->manageSpots("out");
            return $this->calculateValue($time);

      }  
        
    }

    public function manageSpots($type)
    {
        if($type == "in"){
            $vacancies = $vacancies - 1;
            if(vacancies == 0){
                $this->vancacies = false;
            }
        }else{
            $vacancies = $vacancies + 1;
            if(vacancies > 0){
                $this->vancacies = true;
            }
        }
    }

    public function calculateValue($date)
    {
        $value * date('H', $date);
        return $value;
    }
}
?>