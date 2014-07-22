<?php


use Authority\AuthToken\Exceptions\NotAuthorizedException;
use Authority\Exceptions\DuplicateMembershipException;
use Authority\Exceptions\DuplicateRatingException;
use Authority\Exceptions\GoogleTranslateException;
use Authority\Exceptions\MissingParametersException;
use Authority\Exceptions\NonAuthorizedDelete;
use Authority\Exceptions\NonExistantException;
use Authority\Exceptions\NonSkillIdException;
use Authority\Exceptions\NoSearchResultsException;
use Authority\Exceptions\PostsAvailableException;
use Authority\Exceptions\UpdatingErrorException;
use Authority\Exceptions\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
if(App::environment() == 'Production') {
    App::error(function (Exception $exception, $code) {
        Bugsnag::notifyException($exception);
        Log::error($exception);
    });
    App::error(function (MethodNotAllowedHttpException $e) {
        Bugsnag::notifyException($e);
        return Restable::missing()->render();
    });
    App::error(function (ValidationException $e) {
        Bugsnag::notifyException($e);
        return Restable::unprocess($e->getErrors())->render();
    });
    App::error(function (NonExistantException $e) {
        Bugsnag::notifyException($e);
        return Restable::missing()->render();
    });
    App::error(function (Stripe_InvalidRequestError $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getMessage())->render();
    });
    App::error(function (Stripe_CardError $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getMessage())->render();
    });
    App::error(function (DuplicateMembershipException $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getMessage())->render();
    });
    App::error(function (NotAuthorizedException $e) {
        Bugsnag::notifyException($e);
        return Restable::unauthorized()->render();
    });
    App::error(function (MissingParametersException $e) {
        Bugsnag::notifyException($e);
        return Restable::bad($e->getErrors())->render();
    });
    App::error(function (NoSearchResultsException $e) {
        Bugsnag::notifyException($e);
        return Restable::listing([])->render();
    });
    App::error(function (NonSkillIdException $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getErrors())->render();
    });
    App::error(function (PostsAvailableException $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getMessage())->render();
    });
    App::error(function (NonAuthorizedDelete $e) {
        Bugsnag::notifyException($e);
        return Restable::unauthorized()->render();
    });
    App::error(function (ValidationException $e) {
        Bugsnag::notifyException($e);
        return Restable::unprocess($e->getErrors())->render();
    });
    App::error(function (GoogleTranslateException $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getErrors())->render();
    });
    App::error(function (UpdatingErrorException $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getErrors())->render();
    });
    App::error(function (DuplicateRatingException $e) {
        Bugsnag::notifyException($e);
        return Restable::error($e->getMessage())->render();
    });
}
else{

    App::error(function(Exception $exception, $code){
        Log::error($exception);
    });
    App::error(function(MethodNotAllowedHttpException $e){
        return Restable::missing()->render();
    });
    App::error(function(ValidationException $e){
        return Restable::unprocess($e->getErrors())->render();
    });
    App::error(function(NonExistantException $e){
        return Restable::missing()->render();
    });
    App::error(function(Stripe_InvalidRequestError $e){
        return Restable::error($e->getMessage())->render();
    });
    App::error(function(Stripe_CardError $e){
        return Restable::error($e->getMessage())->render();
    });
    App::error(function(DuplicateMembershipException $e){
        return Restable::error($e->getMessage())->render();
    });
    App::error(function(NotAuthorizedException $e){
        return Restable::unauthorized()->render();
    });
    App::error(function(MissingParametersException $e){
        return Restable::bad($e->getErrors())->render();
    });
    App::error(function(NoSearchResultsException $e){
        return Restable::listing([])->render();
    });
    App::error(function(NonSkillIdException $e){
        return Restable::error($e->getErrors())->render();
    });
    App::error(function(PostsAvailableException $e){
        return Restable::error($e->getMessage())->render();
    });
    App::error(function(NonAuthorizedDelete $e){
        return Restable::unauthorized()->render();
    });
    App::error(function(ValidationException $e){
        return Restable::unprocess($e->getErrors())->render();
    });
    App::error(function(GoogleTranslateException $e){
        return Restable::error($e->getErrors())->render();
    });
    App::error(function(UpdatingErrorException $e){
        return Restable::error($e->getErrors())->render();
    });
    App::error(function(DuplicateRatingException $e){
        return Restable::error($e->getMessage())->render();
    });
}