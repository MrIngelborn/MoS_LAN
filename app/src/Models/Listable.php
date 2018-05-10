<?php
namespace MoS\LAN\Models;

interface Listable
{
    public function fetchList();
    public function getList();
    public function getListTitle();
    public function getListHeader();
}