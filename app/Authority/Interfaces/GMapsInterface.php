<?php

namespace Authority\Interfaces;

interface GMapsInterface {

    public function initialize($config = array());

    public function add_marker($params = array());

    public function add_polyline($params = array());

    public function add_polygon($params = array());

    public function add_circle($params = array());

    public function add_rectangle($params = array());

    public function add_ground_overlay($params = array());

    public function create_map();

    public function is_lat_long($input);

    public function get_lat_long_from_address($address, $attempts = 0);
}