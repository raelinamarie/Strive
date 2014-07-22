<?php

class BaseModel extends Eloquent{
    public function update(array $attributes = [])
    {
        // Here, we determine the validator path dynamically.
        // Alternative, you can set a validator prop on your model
        // and remove this portion. Either works.
        $class = get_class($this);
        $path = "Authority\\Service\\Validation\\{$class}Validator";

        if (class_exists($path))
        {
            App::make($path)->validateForUpdate($attributes);
        }

        parent::update($attributes);
    }
}