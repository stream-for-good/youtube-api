<?php

namespace OldSound\RabbitMqBundle\RabbitMq;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

/**
 * Producer, that publishes AMQP Messages
 */
class Producer extends BaseAmqp implements ProducerInterface
{
    protected $contentType = 'text/plain';
    protected $deliveryMode = 2;
    protected string $id = '';
    protected $responseQueue = '';
    protected $task = '';

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function setDeliveryMode($deliveryMode)
    {
        $this->deliveryMode = $deliveryMode;

        return $this;
    }

    public function setResponseQueue($responseQueue)
    {
        $this->responseQueue = $responseQueue;

        return $this;
    }
    
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    protected function getBasicProperties()
    {
        return array('content_type' => $this->contentType, 'content_encoding' => 'utf-8', 'correlation_id' => $this->id, 'reply_to' => $this->responseQueue,'delivery_mode' => $this->deliveryMode);
    }

    /**
     * Publishes the message and merges additional properties with basic properties
     *
     * @param string $msgBody
     * @param string $routingKey
     * @param array $additionalProperties
     * @param array $headers
     */
    public function publish($msgBody, $routingKey = 'celery', $additionalProperties = array(), array $headers = null)
    {
        if ($this->autoSetupFabric) {
            $this->setupFabric();
        }

        $msg = new AMQPMessage((string) $msgBody, array_merge($this->getBasicProperties(), $additionalProperties));

            $headersTable = new AMQPTable(array(

                "id" =>	$this->id,
                "root_id" => $this->id,
                "origin" => 	"php-server",
                "task" =>	$this->task
            ));
            $msg->set('application_headers', $headersTable);

        $this->getChannel()->basic_publish($msg, $this->exchangeOptions['name'], (string)$routingKey);
        $this->logger->debug('AMQP message published', array(
            'amqp' => array(
                'body' => $msgBody,
                'routingkeys' => $routingKey,
                'properties' => $additionalProperties,
                'headers' => $headers
            )
        ));
    }
}
