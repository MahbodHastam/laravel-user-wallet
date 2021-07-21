<?php

if (!function_exists('createHash')) {
    function createHash(): string {
        return hash('sha256', uniqid(time()));
    }
}
