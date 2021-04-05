<?php
namespace Services\Queue;

class ProducerService extends \Zeedhi\Queue\Producer {

    protected static $queueName = "/queue/Integration_ConciliateOrders";

    public function __construct() {
        parent::__construct(new \Zeedhi\Queue\Connection(
            "192.168.122.53",
            "61613",
            "admin",
            "password",
            "pm_broker"
        ));
    }

    public function sendProducer($dataset)
    {
        //var_dump($dataset);die;
        
        /*$message = json_encode(array(
                'SAVE_WORKED_TIME' => array(
                    array(
                        "EMAIL"            => $dataset[0]["EMAIL"],            // email do usuario
                        "EXTERNAL_ID"      => $dataset[0]["EXTERNAL_ID"],      // organização + id do usuario
                        "WORK_DATE"        => $dataset[0]["WORK_DATE"],        // data da apuação
                        "WORK_TIME"        => $dataset[0]["WORK_TIME"],        // tempo de total de trabalho em segundos
                        "JUSTIFIED_TIME"   => $dataset[0]["JUSTIFIED_TIME"],   // tempo de total de ausência justificada em segundos
                        "UNJUSTIFIED_TIME" => $dataset[0]["UNJUSTIFIED_TIME"], // tempo de total de ausência injustificada em segundos
                        "EXTRA_TIME"       => $dataset[0]["EXTRA_TIME"],       // tempo de total de horas extras em segundos
                        "NRVINCULO_SAAS"   => $dataset[0]["NRVINCULO_SAAS"],   // número do vinculo na base teknisa_saas
                        "CPF"              => $dataset[0]["CPF"],              // número do CPF do funcionário
                        "ESTRUTURA_LEGAL"  => $dataset[0]["ESTRUTURA_LEGAL"]   // nome da estrutura legal do funcionário
                    )
                )
            )
        );*/
        $this->send(json_encode($dataset));
    }
}