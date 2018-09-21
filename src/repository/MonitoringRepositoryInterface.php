<?php
namespace pahan23456\monitoring\src\repository;

interface MonitoringRepositoryInterface
{
    /**
     * Создание события
     *
     * @param $message
     * @param $status
     * @param null $data
     * @return mixed
     */
    public function create($message, $status, $priority = 1, $data = null);
}