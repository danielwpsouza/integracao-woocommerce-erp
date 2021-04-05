<?php
namespace Controllers\Queue;

use Services\Queue\ProducerService;

class ProducerController {

    public function sendProducer($data) {
        try {
            $producerService = new ProducerService();
            $producer = $producerService->sendProducer($data);
        } catch(\Exception $e) {
            throw $e;
        }
    }

}