<?php namespace Authority\Validation;

class ProfileValidator extends Validator {
    static $createRules = ['profile_picture' => 'image|max:30000',];
}