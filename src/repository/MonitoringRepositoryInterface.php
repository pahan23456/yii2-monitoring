<?php
namespace pahan23456\monitoring\src\repository;

interface MonitoringRepositoryInterface
{
    /**
     * Создание события
     *
     * @param $status
     * @param $message
     * @param  $data
     * @param  $eventId
     * @param  $command
     * @return mixed
     */
    public function create($status, $message = null, $data = null, $eventId = null, $command = null);
}