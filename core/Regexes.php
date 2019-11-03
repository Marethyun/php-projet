<?php


namespace core;


abstract class Regexes {
    public const ADMIN_PROPERTY_TYPE = '#type_(\w)+#';
    public const RESET_TOKEN = '#[a-zA-Z0-9]{32}#';
    public const USERNAME = '#[a-zA-Z0-9_]{6,255}#';
    public const PASSWORD = '#.{6,255}#';

    public const THREAD_ID = '#[a-zA-Z0-9]{6}#';
    // Basically the same format
    public const MESSAGE_ID = self::THREAD_ID;

    public const END_MESSAGE = '#.*[\?\!\.]$#';
    public const VALID_FRAGMENT = '#^([A-Za-zÀ-ÖØ-öø-ÿ\']+|[A-Za-zÀ-ÖØ-öø-ÿ\']+[\?\!\,\.]? [A-Za-zÀ-ÖØ-öø-ÿ\']+) ?[\?\!\,\.]?$#';
}