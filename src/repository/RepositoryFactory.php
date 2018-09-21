<?php
namespace pahan23456\monitoring\src\repository;

class RepositoryFactory
{
    public static function createMonitoringRepository()
    {
      return new MonitoringRepository();
    }
}