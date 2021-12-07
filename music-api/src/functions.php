<?php
    
    // It debugs the received information to an HTML file
    function debug($info) {
        define('LOG_FILE_NAME', 'log.htm');

        $text = '';
        if (!file_exists(LOG_FILE_NAME)) {
            $text .= '<pre>';
        }
        $text .= '--- ' . date('Y-m-d h:i:s A', time()) . ' ---<br>';

        $logFile = fopen(LOG_FILE_NAME, 'a');

        if (gettype($info) === 'array') {
            $text .= print_r($info, true);
        } else {
            $text .= $info;
        }
        fwrite($logFile, $text);

        fclose($logFile);
    }
    
    function url_path() {
        $first = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
        return $first . $_SERVER['HTTP_HOST'] . '/' . basename(__DIR__) . '/';     
    }

    function API_description() {
        return add_HATEOAS();
    }   
    function add_HATEOAS($information = null, $entity = null) {
        $curDir = url_path();

        if (!is_null($entity)) {
            $apiInfo[$entity] = $information;
        }
        $apiInfo['_links'] = array(
            array(
                'rel' => ($entity == ENTITY_ADMIN ? 'self' : ENTITY_ADMIN),
                'href' => $curDir . ENTITY_ADMIN ,
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_ARTIST ? 'self' : ENTITY_ARTIST),
                'href' => $curDir . ENTITY_ARTIST . '{?name=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_ALBUM ? 'self' : ENTITY_ALBUM),
                'href' => $curDir . ENTITY_ALBUM . '{?title=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_ALBUM ? 'self' : ENTITY_ALBUM),
                'href' => $curDir . ENTITY_ALBUM . '{?artistId=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_TRACK),
                'href' => $curDir . ENTITY_TRACK . '{?name=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_TRACK),
                'href' => $curDir . ENTITY_TRACK . '{?albumId=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_TRACK),
                'href' => $curDir . ENTITY_TRACK . '{?trackId=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_TRACK),
                'href' => $curDir . ENTITY_TRACK,
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_TRACK),
                'href' => $curDir . ENTITY_TRACK . '{/new}',
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_TRACK),
                'href' => $curDir . ENTITY_TRACK . '{/id}',
                'type' => 'DELETE'
            ),
            array(
                'rel' => ($entity == ENTITY_INVOICE ? 'self' : ENTITY_INVOICE),
                'href' => $curDir . ENTITY_INVOICE . '{/id}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_INVOICE ? 'self' : ENTITY_INVOICE),
                'href' => $curDir . ENTITY_INVOICE . '{?customerId=}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_INVOICE),
                'href' => $curDir . ENTITY_INVOICE,
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity == ENTITY_CUSTOMER ? 'self' : ENTITY_CUSTOMER),
                'href' => $curDir . ENTITY_CUSTOMER . '{/email}',
                'type' => 'GET'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_CUSTOMER),
                'href' => $curDir . ENTITY_CUSTOMER,
                'type' => 'POST'
            ),
            array(
                'rel' => ($entity == ENTITY_TRACK ? 'self' : ENTITY_CUSTOMER),
                'href' => $curDir . ENTITY_CUSTOMER . '{/new}',
                'type' => 'POST'
            )
        );        
        return json_encode($apiInfo);
    }
    function format_error() {
        $output['message'] = 'Incorrect format';
        return add_HATEOAS($output, '_error');
    }
?>