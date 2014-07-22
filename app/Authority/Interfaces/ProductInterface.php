<?php  namespace Authority\Interfaces;

interface ProductInterface {
    public function findById($plan_id);
    public function findByName($plan_name);
    public function getAll();
} 