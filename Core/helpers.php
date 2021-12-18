<?php


function authedUser() {
    $token = (new class { use \App\Traits\JWT; })->bearerToken();

    return (new \App\Models\User())->find(['token' => $token]);
}